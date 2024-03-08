<?php

namespace frontend\modules\racdms\controllers;

use Closure;
use Exception;
use kartik\tree\Module;
use kartik\tree\models\Tree;
use kartik\tree\TreeView;
use kartik\tree\TreeSecurity;
use Yii;
use yii\base\ErrorException;
use yii\base\Event;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\db\Exception as DbException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\View;
use common\models\Tblfolders;
use yii\web\NotFoundHttpException;
use common\models\Tbldocuments;
use yii\web\UploadedFile;
use common\models\TbldocumentsDetails;
use yii\helpers\Json;
use common\models\Tblacls;
use common\models\Tblgroups;
use common\models\User;
use common\models\UserHelper;




/**
 * The `NodeController` class manages all the manipulation actions for each tree node. It includes security
 * validations to ensure the actions are accessible only via `ajax` or `post` requests. In addition, it includes
 * stateless signature token validation to cross check data is not tampered before the request is sent via POST.
 */
class TblfoldersController  extends Controller
{
    /**
     * @var array the list of keys in $_POST which must be cast as boolean
     */
    public static $boolKeys = [
        'isAdmin',
        'softDelete',
        'showFormButtons',
        'showIDAttribute',
        'showNameAttribute',
        'multiple',
        'treeNodeModify',
        'allowNewRoots',
    ];

    /**
     * Processes a code block and catches exceptions
     *
     * @param Closure $callback the function to execute (this returns a valid `$success`)
     * @param string $msgError the default error message to return
     * @param string $msgSuccess the default success error message to return
     *
     * @return array outcome of the code consisting of following keys:
     * - `out`: _string_, the output content
     * - `status`: _string_, success or error
     */
    public static function process($callback, $msgError, $msgSuccess)
    {
        $error = $msgError;
        try {
            $success = call_user_func($callback);
        } catch (DbException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (NotSupportedException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (InvalidConfigException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (InvalidCallException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
        if ($success !== false) {
            $out = $msgSuccess === null ? $success : $msgSuccess;
            return ['out' => $out, 'status' => 'success'];
        } else {
            return ['out' => $error, 'status' => 'error'];
        }
    }

    /**
     * Gets the data from $_POST after parsing boolean values
     *
     * @return array
     */
    protected static function getPostData()
    {
        if (empty($_POST)) {
            return [];
        }
        $out = [];
        foreach ($_POST as $key => $value) {
            $out[$key] = in_array($key, static::$boolKeys) ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : $value;
        }
        return $out;
    }

    /**
     * Checks if request is valid and throws exception if invalid condition is true
     *
     * @param boolean $isJsonResponse whether the action response is of JSON format
     * @param boolean $isInvalid whether the request is invalid
     *
     * @throws InvalidCallException
     */
    protected static function checkValidRequest($isJsonResponse = true, $isInvalid = null)
    {
        $app = Yii::$app;
        if ($isJsonResponse) {
            $app->response->format = Response::FORMAT_JSON;
        }
        if ($isInvalid === null) {
            $isInvalid = !$app->request->isAjax || !$app->request->isPost;
        }
        if ($isInvalid) {
            throw new InvalidCallException(Yii::t('kvtree', 'This operation is not allowed.'));
        }
    }



    /**
     * Saves a node once form is submitted
     * @throws InvalidConfigException
     * @throws ErrorException
     */
    public function actionSave()
    {
        /**
         * @var Module $module
         * @var Tree $node
         * @var Tree $parent
         * @var \yii\web\Session $session
         */
        $post = Yii::$app->request->post();
        
        static::checkValidRequest(false, !isset($post['treeNodeModify']));
        $data = static::getPostData();
        $parentKey = ArrayHelper::getValue($data, 'parentKey', null);
        $treeNodeModify = ArrayHelper::getValue($data, 'treeNodeModify', null);
        $currUrl = ArrayHelper::getValue($data, 'currUrl', '');
        $treeClass = TreeSecurity::getModelClass($data);
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        
        
         //-----------------saving new node-------------------------------------------------------
        if ($treeNodeModify) {
            $node = new $treeClass;
            $successMsg = Yii::t('kvtree', 'The {node} was successfully created.', $nodeTitles);
            $errorMsg = Yii::t('kvtree', 'Error while creating the {node}. Please try again later.', $nodeTitles);
        } else {
         
         //-------------------------------------updating node--------------------------------------   
            $tag = explode("\\", $treeClass);
            $tag = array_pop($tag);
            $id = $post[$tag][$keyAttr];
            $node = $treeClass::findOne($id);
            $successMsg = Yii::t('kvtree', 'Saved the {node} details successfully.', $nodeTitles);
            $errorMsg = Yii::t('kvtree', 'Error while saving the {node}. Please try again later.', $nodeTitles);
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;
        $node->load($post);
        $node->user=Yii::$app->user->identity->user_id;
        $errors = $success = false;
        if (Yii::$app->has('session')) {
            $session = Yii::$app->session;
        }
        if ($treeNodeModify) {
            if ($parentKey == TreeView::ROOT_KEY) {
                $node->makeRoot();
            } else {
                $parent = $treeClass::findOne($parentKey);
                if ($parent->isChildAllowed()) {
                    $node->appendTo($parent);
                } else {
                    $errorMsg = Yii::t('kvtree', 'You cannot add children under this {node}.', $nodeTitles);
                    if (Yii::$app->has('session')) {
                        $session->setFlash('error', $errorMsg);
                    } else {
                        throw new ErrorException("Error saving {node}!\n{$errorMsg}", $nodeTitles);
                    }
                    return $this->redirect($currUrl);
                }
            }
        }
        if ($node->save()) {
            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "{node} # {id} - '{name}': {error}",
                            $err + $nodeTitles) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }
        if (Yii::$app->has('session')) {
            $session->set(ArrayHelper::getValue($post, 'nodeSelected', 'kvNodeId'), $node->{$keyAttr});
            
            if ($success) {
               
             
                   $session->setFlash('success', $successMsg); 
               
               
            } else {
                $session->setFlash('error', $errorMsg);
            }
        } elseif (!$success) {
            throw new ErrorException("Error saving {node}!\n{$errorMsg}", $nodeTitles);
        }
        return $this->redirect($currUrl);
    }
    
     /**
     * View, create, or update a tree node via ajax
     *
     * @return mixed json encoded response
     */
    public function actionCreate()
    {
        static::checkValidRequest();
        $data = static::getPostData();
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        
        $callback = function () use ($data, $nodeTitles) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parentKey = ArrayHelper::getValue($data, 'parentKey', '');
            $parsedData = TreeSecurity::parseManageData($data);
            $out = $parsedData['out'];
          /*  $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];*/
            /**
             * @var Module $module
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            if (!isset($id) || empty($id)) {
                $node = new $treeClass;
                $node->initDefaults();
            } else {
                $node = $treeClass::findOne($id);
            }
            $module = TreeView::module();
            $params = $module->treeStructure + $module->dataStructure + [
                    'node' => $node,
                    'parentKey' => $parentKey,
                    'treeManageHash' => $newHash,
                    'treeRemoveHash' => ArrayHelper::getValue($data, 'treeRemoveHash', ''),
                    'treeMoveHash' => ArrayHelper::getValue($data, 'treeMoveHash', ''),
                ] + $out;
            if (!empty($data['nodeViewParams'])) {
                $params = ArrayHelper::merge($params, unserialize($data['nodeViewParams']));
            }
            if (!empty($module->unsetAjaxBundles)) {
                $cb = function ($e) use ($module) {
                    foreach ($module->unsetAjaxBundles as $bundle) {
                        unset($e->sender->assetBundles[$bundle]);
                    }
                };
                Event::on(View::class, View::EVENT_AFTER_RENDER, $cb);
            }
            //TreeSecurity::checkSignature('manage', $oldHash, $newHash);
             
           
            return $this->renderAjax('_form', ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the {node}. Please try again later.', $nodeTitles),
            null
        );
    }
    
     /**
     * View Children via Table 
     *
     * @return mixed json encoded response
     */
     
  public function actionView2($id){
      
       $node=TblFolders::findOne($id);
       $currentUrl=$_GET['url'];
       
       if (Yii::$app->has('session')) {
            
            $session = Yii::$app->session;
            $session->set('w0-nodesel',$node->id);
        }
      
    return $this->redirect('/erp/racdms');
    
      
      
  }  
  
  
  
  public function actionGetContent($id){
   
       if (!is_numeric($id) || intval($id)<1){
       
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Folder Id!
              
               </div>'; 
               
         return $this->asJson($html);
         
         }
         
   
      $node=TblFolders::findOne($id);
      
      if($node==null){
          
      
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Folder Not Found  !
              
               </div>'; 
               
              return $this->asJson($html);
         
       
      }
   
       
      $html = $this->renderAjax('view-content',['node'=> $node]);
      return $this->asJson($html);
     
       
      
  }
  
  
  
  
  
  public function actionManageAccess($id){
      
      if (!is_numeric($id) || intval($id)<1){
       
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Folder Id!
              
               </div>'; 
               
              return $this->asJson($html);
         
         } 
         
          $folder=TblFolders::findOne($id);
      
      if($folder==null){
          
      
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Folder Not Found  !
              
               </div>'; 
               
               return $this->asJson($html);
         
       
      }
      
       $html = $this->renderAjax('manage-access',['folder'=> $folder]);
     
       return $this->asJson($html);
      
  }
  
   public function actionAccessList(){
         
         if(Yii::$app->request->post()){


if (isset($_POST['id']) && $_POST['id']!=null) {
    
    $action = $_POST['action'];
    
    switch ($action) {
        case 'groups' :
          return  $this->getGroupAccessList($_POST['id']);
            break;
         case 'users' :
          return  $this->getUsersAccessList($_POST['id']);
            break;
    }
}
             
             
              }
         
     }
     
       
     public function actionAddAccess(){
         
         
         
         if(Yii::$app->request->post()){
             
          $action=$_POST['action'];
          
         
         
          if($action=='setaccess'){
              
                 
          if(isset($_POST['GroupsAccessList'])){
              
              
           if(!isset($_POST['GroupsAccessList']['target']) || $_POST['GroupsAccessList']['target']==null){
               
               $response[data]=['flag'=>false,'error'=>'Invalid target ID'];
             
                return json_encode($response); 
           }
           
           if(empty($_POST['GroupsAccessList']['group']) ){
               
               $response[data]=['flag'=>false,'error'=>'no group selected !'];
               return json_encode($response); 
               
             }
             
            if(!isset($_POST['GroupsAccessList']['access_mode']) || $_POST['GroupsAccessList']['access_mode']==null) {
                
                $response[data]=['flag'=>false,'error'=>'no access level selected'];
               
                return json_encode($response); 
                
            }
            
            $target=$_POST['GroupsAccessList']['target'];
            $mode=$_POST['GroupsAccessList']['access_mode'];
            $group=$_POST['GroupsAccessList']['group'];
           
           
            $folder=Tblfolders::find()->where(['id'=>$target])->One();
           
            if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
           
           
           
             $flag=$folder->addAccess($mode,$group,false);
        
            
            
            if(!$flag){
                
               $response[data]=['flag'=>false,'error'=>'<ul style="margin:0"><li>' . implode('</li><li>', $folder->getFirstErrors()) . '</li></ul>'];
               return json_encode($response); 
            }
            
             $response[data]=['flag'=>true,'message'=>'Security Group Added!','target'=>'groups'];
             return json_encode($response);
              
          }
    
    //----------------------------------------------------users---------------------------------------------//    
            if(isset($_POST['UsersAccessList'])){
           
          
           if(!isset($_POST['UsersAccessList']['target']) || $_POST['UsersAccessList']['target']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid target ID'];
              return json_encode($response); 
           }
           
           if(empty($_POST['UsersAccessList']['user']) ){
               
               $response[data]=['flag'=>false,'error'=>'no users selected !'];
               return json_encode($response); 
               
             }
             
            if(!isset($_POST['UsersAccessList']['access_mode']) || $_POST['UsersAccessList']['access_mode']==null) {
                
                $response[data]=['flag'=>false,'error'=>'no access level selected'];
               
                return json_encode($response); 
                
            }
           
           $users=$_POST['UsersAccessList']['user'];
           $target=$_POST['UsersAccessList']['target'];
           $mode=$_POST['UsersAccessList']['access_mode'];
           
            $folder=Tblfolders::find()->where(['id'=>$target])->One();
           
            if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
           
           foreach($users as $user){
               
             if(!$flag=$folder->addAccess($mode,$user,true)) {
                 
                $errorMsg='<ul style="margin:0"><li>' . implode('</li><li>', $folder->getFirstErrors()) . '</li></ul>';   
           
             break;  
             } 
             
          
          
           }
            
           
            if($flag){
             
             $response[data]=['flag'=>true,'message'=>'User(s) Added!','target'=>'users'];
             return json_encode($response);   
                
            }else{
                
                $response[data]=['flag'=>false,'error'=>$errorMsg];
                return json_encode($response);
            } 
             
              
          }
         
          }
         else if($action=='setdefault'){
           
         
           
           if(!isset($_POST['folderid']) || $_POST['folderid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid folder ID'];
              
              return json_encode($response); 
           }
            
            $folderid=$_POST['folderid'];
            $defaultaccess=$_POST['Tblfolders']['defaultAccess'];
            
            $folder=Tblfolders::find()->where(['id'=>$folderid])->one();
            
             if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
              
              if(!$flag=$folder->setDefaultAccess( $defaultaccess)){
                  
                  $errorMsg='<ul style="margin:0"><li>' . implode('</li><li>', $folder->getFirstErrors()) . '</li></ul>';  
              }
              
              if($flag){
                   $response[data]=['flag'=>true,'message'=>'Default access changed !'];
               
                return json_encode($response); 
                  
              }else{
                  
                   $response[data]=['flag'=>false,'error'=>'Unable to change default access !'];
               
                   return json_encode($response); 
              }
             
             
         }else if($action=='notinherit'){
             
             if(!isset($_POST['folderid']) || $_POST['folderid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid folder ID'];
              
              return json_encode($response); 
           }
            
            $folderid=$_POST['folderid'];
            $mode=$_POST['mode'];
            
            $folder=Tblfolders::find()->where(['id'=>$folderid])->one();
            
             if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
             
          //------------------disable inherit access-----------------------------------   
             $folder->inheritAccess=false;
             
             if(!$folder->save(false)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to disable inheritance !'];
               
                 return json_encode($response);  
                 
             }
             
           
             elseif($mode=='copy'){
                 
                 
                 
             }
             
             $response[data]=['flag'=>true,'action'=>'notinherit'];
               
                 return json_encode($response);
             
             
         }
          else if($action=='inherit'){
             
             if(!isset($_POST['folderid']) || $_POST['folderid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid folder ID'];
              
              return json_encode($response); 
           }
            
            $folderid=$_POST['folderid'];
           
            
            $folder=Tblfolders::find()->where(['id'=>$folderid])->one();
            
             if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
             
          //------------------disable inherit access-----------------------------------   
             $folder->inheritAccess=true;
             
             if(!$folder->save(false)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to enable inheritance !'];
               
                 return json_encode($response);  
                 
             }
          //-----------------clear access list---------------------------------
          
             if(!$folder->clearAccessList()){
                 
                 $response[data]=['flag'=>false,'error'=>'unable to clear folder access list!'];
               
                 return json_encode($response);  
             }
             
             $response[data]=['flag'=>true,'message'=>'Inherit Access enabled'];
               
                 return json_encode($response);
             
             
         }
       //-----------------------------------set owner-------------------------------------------
       
        else if($action=='setowner'){
             
             if(!isset($_POST['folderid']) || $_POST['folderid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid folder ID'];
              
              return json_encode($response); 
           }
           
             if(!isset($_POST['owner']) || $_POST['owner']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid Owner ID'];
              
              return json_encode($response); 
           }
           
            
            $folderid=$_POST['folderid'];
            $owner=$_POST['owner'];
           
            
            $folder=Tblfolders::find()->where(['id'=>$folderid])->one();
            
             if($folder==null){
               
                $response[data]=['flag'=>false,'error'=>'target folder not found'];
               
                return json_encode($response);  
             }
             
          //------------------set owner----------------------------------   
            
             
             if(!$folder->setOwner($owner)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to set folder owner !'];
               
                 return json_encode($response);  
                 
             }
        
             
             $response[data]=['flag'=>true,'message'=>'Owner set successfully !'];
               
                 return json_encode($response);
             
             
         }
         
         
             
              }
         
     }
  
  
public function actionGetAccessMode($id){
    
//$folder=Tblfolders::find()->where(['id'=>$id])->One(); 
$user=Yii::$app->user->identity;
var_dump($user->isMemberOfGroup('CIT'));
/*$mode=$folder->getAccessMode($user);

$accesslist=$folder->getAccessList();

 var_dump($accesslist['users']) ;  
  */  
}  
     
     
public function actionRemoveAccess(){
    
     if(Yii::$app->request->post()){
         
           $isuser=$_POST['isuser'];
           $target=$_POST['target'];
           $grouporuserid=$_POST['grouporuserid'];
           
           $folder=Tblfolders::find()->where(['id'=>$target])->One(); 
           
          
           
           if($folder!=null){
              
            if(!$folder->removeAccess($grouporuserid, $isuser)) {
              
              $response[data]=['flag'=>false,'error'=>"Unable to remove access"];
            
              return json_encode($response);  
                
             }
             
             $response[data]=['flag'=>true,'message'=>"Access Removed !",'target'=> $isuser?"users":'groups'];
              return json_encode($response);
               
           }else{
               
                $response[data]=['flag'=>false,'error'=>"folder not found!"];
              return json_encode($response);
           }
           
           
         
       }
    
    
}     
   
     
     
      
 function getGroupAccessList($id){
     
$requestData = $_REQUEST; 
$searchValue =  $requestData['search']['value']; // Search value
$draw = $requestData['draw'];
$row = $requestData['start'];
$rowperpage = $requestData['length']; // Rows display per page
$columnIndex = $requestData['order'][0]['column']; // Column index
$columnName = $requestData['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $requestData['order'][0]['dir']; // asc or desc
   
## Total number of records without filtering
$totalRecords =Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$id])->andWhere(['<>', 'groupID',-1])->count();

$modelsGroup=Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$id])->andWhere(['<>', 'groupID',-1])->all();

$data = array();

foreach ($modelsGroup as $groupAcess) {

$model=Tblgroups::find()->where(['id'=>$groupAcess->groupID])->one();

if($model!=null){
    
  $data[] = array( 
      "group_id"=>$model->id,
      "group_name"=>$model->name,
      "restrict"=>$groupAcess->mode==Tblacls::M_NONE,
      "read"=>$groupAcess->mode==Tblacls::M_READ,
      "readwrite"=>$groupAcess->mode==Tblacls::M_READWRITE,
      "fullaccess"=>$groupAcess->mode==Tblacls::M_ALL,
      "5"=>5
   );  
    
}
 
   
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" =>0,
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $data
);
return  json_encode($response);
     
 }   


function getUsersAccessList($id){
     
$requestData = $_REQUEST; 
$searchValue =  $requestData['search']['value']; // Search value
$draw = $requestData['draw'];
$row = $requestData['start'];
$rowperpage = $requestData['length']; // Rows display per page
$columnIndex = $requestData['order'][0]['column']; // Column index
$columnName = $requestData['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $requestData['order'][0]['dir']; // asc or desc
   
## Total number of records without filtering
$totalRecords =Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$id])->andWhere(['<>', 'userID',-1])->count();


$modelsUser=Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$id])->andWhere(['<>', 'userID',-1])->all();

$data = array();

foreach ($modelsUser as $userAccess) {

$model=User::find()->where(['user_id'=>$userAccess->userID])->One();

if($model!=null){

$pos=UserHelper::getPositionInfo($model->user_id);    
  
  $data[] = array( 
      "user_id"=>$model->user_id,
      "user"=>$model->first_name." ".$model->last_name." / ".$pos['position'],
      "restrict"=>$userAccess->mode==Tblacls::M_NONE,
      "read"=>$userAccess->mode==Tblacls::M_READ,
      "readwrite"=>$userAccess->mode==Tblacls::M_READWRITE,
      "fullaccess"=>$userAccess->mode==Tblacls::M_ALL,
      "5"=>5
   );  
    
}
 
   
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" =>0,
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $data
);
return  json_encode($response);
     
 }   

    
     /**
     * View, create, or update a tree node via ajax
     *
     * @return mixed json encoded response
     */
    public function actionView()
    {
        static::checkValidRequest();
        $data = static::getPostData();
        
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        
        $callback = function () use ($data, $nodeTitles) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parentKey = ArrayHelper::getValue($data, 'parentKey', '');
            $parsedData = TreeSecurity::parseManageData($data);
            $out = $parsedData['out'];
            $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];
            
           
            
            /**
             * @var Module $module
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            if (!isset($id) || empty($id)) {
                $node = new $treeClass;
                $node->initDefaults();
            } else {
                $node = $treeClass::findOne($id);
                
            }
            $module = TreeView::module();
            $params = $module->treeStructure + $module->dataStructure + [
                    'node' => $node,
                    'parentKey' => $parentKey,
                    'treeManageHash' => $newHash,
                    'treeRemoveHash' => ArrayHelper::getValue($data, 'treeRemoveHash', ''),
                    'treeMoveHash' => ArrayHelper::getValue($data, 'treeMoveHash', ''),
                ] + $out;
            if (!empty($data['nodeViewParams'])) {
                $params = ArrayHelper::merge($params, unserialize($data['nodeViewParams']));
            }
            if (!empty($module->unsetAjaxBundles)) {
                $cb = function ($e) use ($module) {
                    foreach ($module->unsetAjaxBundles as $bundle) {
                        unset($e->sender->assetBundles[$bundle]);
                    }
                };
                Event::on(View::class, View::EVENT_AFTER_RENDER, $cb);
            }
            //TreeSecurity::checkSignature('manage', $oldHash, $newHash);
            
           
             
            return $this->renderAjax('view', ['params' => $params]);
            
        };
       
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the {node}. Please try again later.', $nodeTitles),
            null
        );
    }

    /**
     * View, create, or update a tree node via ajax
     *
     * @return mixed json encoded response
     */
    public function actionManage()
    {
        static::checkValidRequest();
        $data = static::getPostData();
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        
        $callback = function () use ($data, $nodeTitles) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parentKey = ArrayHelper::getValue($data, 'parentKey', '');
            $parsedData = TreeSecurity::parseManageData($data);
            $out = $parsedData['out'];
            $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];
            /**
             * @var Module $module
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            if (!isset($id) || empty($id)) {
                $node = new $treeClass;
                $node->initDefaults();
            } else {
                $node = $treeClass::findOne($id);
            }
            $module = TreeView::module();
            $params = $module->treeStructure + $module->dataStructure + [
                    'node' => $node,
                    'parentKey' => $parentKey,
                    'treeManageHash' => $newHash,
                    'treeRemoveHash' => ArrayHelper::getValue($data, 'treeRemoveHash', ''),
                    'treeMoveHash' => ArrayHelper::getValue($data, 'treeMoveHash', ''),
                ] + $out;
            if (!empty($data['nodeViewParams'])) {
                $params = ArrayHelper::merge($params, unserialize($data['nodeViewParams']));
            }
            if (!empty($module->unsetAjaxBundles)) {
                $cb = function ($e) use ($module) {
                    foreach ($module->unsetAjaxBundles as $bundle) {
                        unset($e->sender->assetBundles[$bundle]);
                    }
                };
                Event::on(View::class, View::EVENT_AFTER_RENDER, $cb);
            }
            TreeSecurity::checkSignature('manage', $oldHash, $newHash);
             
            //return $this->renderAjax($out['nodeView'], ['params' => $params]);
           return $this->renderAjax('view', ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the {node}. Please try again later.', $nodeTitles),
            null
        );
    }

    /**
     * Remove a tree node
     */
    public function actionRemove()
    {
        static::checkValidRequest();
        $data = static::getPostData();
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        $callback = function () use ($data) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parsedData = TreeSecurity::parseRemoveData($data);
            $out = $parsedData['out'];
           /* $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];*/
            /**
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            //TreeSecurity::checkSignature('remove', $oldHash, $newHash);
            /**
             * @var Tree $node
             */
            $node = $treeClass::findOne($id);
           
            $node->removeNode($out['softDelete']);
            
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error removing the {folder}. Please try again later.', $nodeTitles),
            Yii::t('kvtree', 'The {folder} was removed successfully.', $nodeTitles)
        );
    }
    
    

    /**
     * Move a tree node
     */
    public function actionMove()
    {
        static::checkValidRequest();
        $data = static::getPostData();
        $dir = ArrayHelper::getValue($data, 'dir', null);
        $idFrom = ArrayHelper::getValue($data, 'idFrom', null);
        $idTo = ArrayHelper::getValue($data, 'idTo', null);
        $parsedData = TreeSecurity::parseMoveData($data);
        /**
         * @var Tree $treeClass
         * @var Tree $node
         */
        $treeClass = $parsedData['out']['treeClass'];
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        /**
         * @var Tree $nodeFrom
         * @var Tree $nodeTo
         */
        $nodeFrom = $treeClass::findOne($idFrom);
        $nodeTo = $treeClass::findOne($idTo);
        $isMovable = $nodeFrom->isMovable($dir);
        $errorMsg = $isMovable ?
            Yii::t('kvtree', 'Error while moving the {node}. Please try again later.', $nodeTitles) :
            Yii::t('kvtree', 'The selected {node} cannot be moved.', $nodeTitles);
        $callback = function () use ($dir, $parsedData, $isMovable, $nodeFrom, $nodeTo, $nodeTitles) {
            $out = $parsedData['out'];
            $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];
            if (!empty($nodeFrom) && !empty($nodeTo)) {
                TreeSecurity::checkSignature('move', $oldHash, $newHash);
                if (!$isMovable || ($dir !== 'u' && $dir !== 'd' && $dir !== 'l' && $dir !== 'r')) {
                    return false;
                }
                if ($dir === 'r') {
                    $nodeFrom->appendTo($nodeTo);
                } else {
                    if ($dir === 'l' && $nodeTo->isRoot() && $out['allowNewRoots']) {
                        $nodeFrom->makeRoot();
                    } elseif ($nodeTo->isRoot()) {
                        throw new Exception(Yii::t('kvtree',
                            'Cannot move root level {nodes} before or after other root level {nodes}.', $nodeTitles));
                    } elseif ($dir == 'u') {
                        $nodeFrom->insertBefore($nodeTo);
                    } else {
                        $nodeFrom->insertAfter($nodeTo);
                    }
                }
                return $nodeFrom->save();
            }
            return true;
        };
        return self::process($callback, $errorMsg, Yii::t('kvtree', 'The {node} was moved successfully.', $nodeTitles));
    }
    
    
    public function actionAddDocument(){
    
    $docDetails=new TbldocumentsDetails();
    
    if (Yii::$app->request->post()){
        
         if(isset($_POST['folderid']) && $_POST['folderid']!=null){
             
             $folder=Tblfolders::find()->where(['id'=>$_POST['folderid']])->one();
          
             if($folder!=null){
              
               if(isset($_POST['TbldocumentsDetails'])){
                
              
                 //--------------------------check file errors------------------------------- 
                   if($_FILES && $_FILES['TbldocumentsDetails']['name']['uploaded_file']) {
                   
                  $docDetails->attributes=$_POST['TbldocumentsDetails'];
                   $docDetails->uploaded_file = UploadedFile::getInstance($docDetails, 'uploaded_file');
                  
                  $flag=$folder->addDocument($docDetails);
                  
                 
                  if($flag){
                      
                        $successMsg="Document Saved Successfully!";
                        Yii::$app->session->setFlash('success', $successMsg);
                        
                  }else{
                      
                      $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $folder->getFirstErrors()) . '</li></ul>';
                      Yii::$app->session->setFlash('error', $errorMsg);
                       
                      
                  }
                 
                   return $this->redirect(['view2','id'=>$folder->id]);
            }
    //----------------------ENDING FILE ERROR CHECK------------------------------        
            else{
                
                $errorMsg = '<ul style="margin:0"><li>' . "Error Uploading Empty Document !" . '</li></ul>'; 
                return $this->redirect(['view2','id'=>$folder->id]); 

                
              }
                  
                 
               }//-----------------END POST DOCUMENT------------
   
          }
  //-----------------------folder not found----------------------        
          else{
              
             $errorMsg = '<ul style="margin:0"><li>' . "Error Folder not found !" . '</li></ul>';    
                  
            Yii::$app->session->setFlash('error', $errorMsg); 
             
             return $this->redirect('/erp/racdms');
              
            }
             
              
             
         }
 //----------------------invalid folder id-------------------------------        
         else{
             
         $errorMsg = '<ul style="margin:0"><li>' . "Erro Invalid Folder Id !" . '</li></ul>';    
                  
         Yii::$app->session->setFlash('error', $errorMsg);  
         
         return $this->redirect('/erp/racdms');
             
           }
           
           
       
        
       }//---------END POST------------   
      
      
  }  
   
   public function actionFilesUpload(){
       
  if (Yii::$app->request->post()) {
    
        
        if(isset($_POST['folderid']) && $_POST['folderid']!=null){
             
             $folderid = $_POST['folderid'];
             $folder=Tblfolders::find()->where(['id'=>$folderid])->one();
             
             if($folder!=null){
              
              $files = UploadedFile::getInstancesByName('files'); 
              
              
                
                if(!empty($files)) {
                  
               
               foreach($files as $file){
                   
               
               
                $docDetails=new TbldocumentsDetails();
               
                $docDetails->name=$file->name;
                
                $docDetails->uploaded_file=$file;
                
               
                
                if(!$flag=$folder->addDocument($docDetails)){
                   
                   break;
                }
               
                
                   
                   
               }
               
               if($flag){
                   
                    return  json_encode(['success' => 'true']); 
               }
               
                else{
                 
                 $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $folder->getFirstErrors()) . '</li></ul>';   
                
                  return   json_encode(['success'=>'false','error'=>$errorMsg]);
                    
                   }
               
               
               
                }//---------------------No Files Uploaded--------------------
                else{
                    
                     return json_encode(['success'=>'false','error'=>"No Files Uploaded !"]);
                }
             }
             //----------------------Folder not found-------------------------
             else{
                 
                  return json_encode(['success'=>'false','error'=>"Folder Not Found!"]);
             }
             
        }//--------------------------------invalide folder id-----------------------------------
        else{
            
             return json_encode(['success'=>'false','error'=>"Invalid Folder Id !"]);
        }
         
           
        }      
       
       }
   
       public function actionUpdate($id){
      
        
         static::checkValidRequest();
        $data = static::getPostData();
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        
        $callback = function () use ($data, $nodeTitles) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parentKey = ArrayHelper::getValue($data, 'parentKey', '');
            $parsedData = TreeSecurity::parseManageData($data);
            $out = $parsedData['out'];
           /* $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];*/
            /**
             * @var Module $module
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            if (!isset($id) || empty($id)) {
                $node = new $treeClass;
                $node->initDefaults();
            } else {
                $node = $treeClass::findOne($id);
            }
            $module = TreeView::module();
            $params = $module->treeStructure + $module->dataStructure + [
                    'node' => $node,
                    'parentKey' => $parentKey,
                    'treeManageHash' => $newHash,
                    'treeRemoveHash' => ArrayHelper::getValue($data, 'treeRemoveHash', ''),
                    'treeMoveHash' => ArrayHelper::getValue($data, 'treeMoveHash', ''),
                ] + $out;
            if (!empty($data['nodeViewParams'])) {
                $params = ArrayHelper::merge($params, unserialize($data['nodeViewParams']));
            }
            if (!empty($module->unsetAjaxBundles)) {
                $cb = function ($e) use ($module) {
                    foreach ($module->unsetAjaxBundles as $bundle) {
                        unset($e->sender->assetBundles[$bundle]);
                    }
                };
                Event::on(View::class, View::EVENT_AFTER_RENDER, $cb);
            }
            //TreeSecurity::checkSignature('manage', $oldHash, $newHash);
             
           
            return $this->renderAjax('_form', ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the {node}. Please try again later.', $nodeTitles),
            null
        );
      
   
       }
 
 
    /**
     * Remove a tree node
     */
    public function actionDelete($id)
    {
        
        
        static::checkValidRequest();
        $data = static::getPostData();
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        $callback = function () use ($data) {
            $id = ArrayHelper::getValue($data, 'id', null);
            $parsedData = TreeSecurity::parseRemoveData($data);
            $out = $parsedData['out'];
            $oldHash = $parsedData['oldHash'];
            $newHash = $parsedData['newHash'];
            /**
             * @var Tree $treeClass
             * @var Tree $node
             */
            $treeClass = $out['treeClass'];
            TreeSecurity::checkSignature('remove', $oldHash, $newHash);
            /**
             * @var Tree $node
             */
            $node = $treeClass::findOne($id);
            
            $node->remove($out['softDelete']);
            
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error removing the {folder}. Please try again later.', $nodeTitles),
            Yii::t('kvtree', 'The {folder} was removed successfully.', $nodeTitles)
        );
    }
   
   
   protected function findModel($id)
    {
        if (($model = Tblfolders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}




