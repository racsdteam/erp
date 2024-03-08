<?php

namespace frontend\modules\racdms\controllers;

use Yii;
use common\models\Tbldocuments;
use common\models\TbldocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\UploadedFile;
use common\models\TbldocumentsDetails;
use yii\helpers\Json;
use common\models\Tblacls;
use common\models\Tblgroups;
use common\models\Tblfolders;
use common\models\User;
use common\models\UserHelper;
use yii\data\Pagination;
use common\models\Tbldocumentcontent;
/**
 * TbldocumentsController implements the CRUD actions for Tbldocuments model.
 */
class TbldocumentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tbldocuments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbldocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tbldocuments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }
    
   
      public function actionGetContent($id){
        
         if (!is_numeric($id) || intval($id)<1){
       
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Document Id!
              
               </div>'; 
               
              
               
              return Json::encode($html); 
         
         }
        
   
$doc=Tbldocuments::find()->where(['id'=>$id])->one();


if($doc==null){
    
     $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Document !
              
               </div>';
               
              
               
    return Json::encode($html); 
          
    
}

    $query = Tbldocumentcontent::find()->where(['document'=>$doc->id])->orderBy(['version' => SORT_DESC]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 1]);
    $contentmodels = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();


  
     //$contentModels=$doc->getContent();
     
     if(empty($contentmodels)){
         
         $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Document Content not Found!
              
               </div>'; 
               
               
            return Json::encode($html); 
       }
       
       
       
     
     if(Yii::$app->request->isAjax){
         
        $html = $this->renderAjax('view-content2',['doc'=> $doc,'contentmodels'=> $contentmodels,
     'pages'=>$pages]);
     
     if(isset($_GET['pajax']) && $_GET['pajax']==1){
         
         return $html;
     }
     
     //-------------------kartik tab ajax data set to  html--------------------------
    
     
     return Json::encode($html);  
         
     }
    
    
     
    return  $this->render('view-content2',['doc'=> $doc,'contentmodels'=> $contentmodels,
     'pages'=>$pages]);
        
    } 
    
    
    public function actionGetContentByVersion($id){
        
         if (!is_numeric($id) || intval($id)<1){
       
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Document Id!
              
               </div>'; 
               
                return $html;
               
               // return Json::encode($html); 
         
         }
        
        
     
     if (!isset($_GET['v']) || !is_numeric($_GET['v']) || intval($_GET['v'])<1){
         
          $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Document Version!
              
               </div>';
               
                return $html;
               
                //return Json::encode($html); 
         
        }
        
        
     $doc=Tbldocuments::find()->where(['id'=>$id])->one();
     
     $content=$doc->getContentByVersion($_GET['v']);
     
     if(!$content){
         
         $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Document Content not Found!
              
               </div>'; 
               
                return $html;
               // return Json::encode($html); 
       }
    
   
     $html = $this->renderAjax('view-content',['doc'=> $doc,'content'=> $content]);
     
     return $html;
     
    // return Json::encode($html);    
        
    }
    
    public function actionManageAccess($id){
      
      if (!is_numeric($id) || intval($id)<1){
       
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Document Id!
              
               </div>'; 
               
                return Json::encode($html); 
                // return $html;
         
         } 
         
          $doc=Tbldocuments::findOne($id);
      
      if($doc==null){
          
      
       $html='<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Document Not Found  !
              
               </div>'; 
               
                //return $html;
               
                return Json::encode($html); 
         
       
      }
      
       $html = $this->renderAjax('manage-access',['doc'=> $doc]);
       //return $html;
     
       return Json::encode($html);  
      
  } 
    
    
     /**
     * Add Document Access
     * If creation is successful, true flag will be sent.
     * @return mixed
     */
     
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
           
           
            $doc=Tbldocuments::find()->where(['id'=>$target])->One();
           
            if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target document not found'];
               
                return json_encode($response);  
             }
           
           
           
             $flag=$doc->addAccess($mode,$group,false);
        
            
            
            if(!$flag){
                
               $response[data]=['flag'=>false,'error'=>'<ul style="margin:0"><li>' . implode('</li><li>', $doc->getFirstErrors()) . '</li></ul>'];
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
           
            $doc=Tbldocuments::find()->where(['id'=>$target])->One();
           
            if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target document not found'];
               
                return json_encode($response);  
             }
           
           foreach($users as $user){
               
             if(!$flag=$doc->addAccess($mode,$user,true)) {
                 
                $errorMsg='<ul style="margin:0"><li>' . implode('</li><li>', $doc->getFirstErrors()) . '</li></ul>';   
           
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
           
         
           
           if(!isset($_POST['docid']) || $_POST['docid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid document ID'];
              
              return json_encode($response); 
           }
            
            $docid=$_POST['docid'];
            $defaultaccess=$_POST['Tbldocuments']['defaultAccess'];
            
            $doc=Tbldocuments::find()->where(['id'=>$docid])->one();
            
             if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target document not found'];
               
                return json_encode($response);  
             }
              
              if(!$flag=$doc->setDefaultAccess( $defaultaccess)){
                  
                  $errorMsg='<ul style="margin:0"><li>' . implode('</li><li>', $doc->getFirstErrors()) . '</li></ul>';  
              }
              
              if($flag){
                   $response[data]=['flag'=>true,'message'=>'document default access changed !'];
               
                return json_encode($response); 
                  
              }else{
                  
                   $response[data]=['flag'=>false,'error'=>'Unable to change document default access !'];
               
                   return json_encode($response); 
              }
             
             
         }else if($action=='notinherit'){
             
             if(!isset($_POST['docid']) || $_POST['docid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid document ID'];
              
              return json_encode($response); 
           }
            
            $docid=$_POST['docid'];
            $mode=$_POST['mode'];
            
            $doc=Tbldocuments::find()->where(['id'=>$docid])->one();
            
             if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target documents not found'];
               
                return json_encode($response);  
             }
             
          //------------------disable inherit access-----------------------------------   
             $doc->inheritAccess=false;
             
             if(!$doc->save(false)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to disable access inheritance !'];
               
                 return json_encode($response);  
                 
             }
             
             $response[data]=['flag'=>true,'action'=>'notinherit','mode'=>'empty','message'=>'access inheritance disabled !'];
           
             if($mode=='copy'){
             	
             	$parent=Tblfolders::find()->where(['id'=>$doc->folder])->one(); 
             
             	$accessList=$parent->getAccessList();
             	
             	foreach ($accessList["users"] as $userAccess){
             	    
             	    	if(!$doc->addAccess($userAccess->mode, $userAccess->userID, true)){
			    
			    $response[data]=['flag'=>false,'error'=>'error copying user access !'];
               
                 return json_encode($response); 
                 
                 break;
                  
			}
             	    
             	}
		
	   	foreach ($accessList["groups"] as $groupAccess){
	   	    
	   	    if(!$doc->addAccess($groupAccess->mode, $groupAccess->groupID, false)){
	   	        
	   	      $response[data]=['flag'=>false,'error'=>'error copying group access !'];
               
                 return json_encode($response); 
                 
                 break;  
	   	        
	   	    }
	   	    
	   	}
			
         $response[data]=['flag'=>true,'action'=>'notinherit','mode'=>'copy','message'=>'parent access copied!'];        
                 
             }
             
             
             
           
               
                 return json_encode($response);
             
             
         }
          else if($action=='inherit'){
             
             if(!isset($_POST['docid']) || $_POST['docid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid document ID'];
              
              return json_encode($response); 
           }
            
            $docid=$_POST['docid'];
            
            
            $doc=Tbldocuments::find()->where(['id'=>$docid])->one();
            
           
            
             if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target document not found'];
               
                return json_encode($response);  
             }
             
          //------------------disable inherit access-----------------------------------   
             $doc->inheritAccess=true;
             
             if(!$doc->save(false)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to enable accesss inheritance !'];
               
                 return json_encode($response);  
                 
             }
          //-----------------clear access list---------------------------------
          
             if(!$doc->clearAccessList()){
                 
                 $response[data]=['flag'=>false,'error'=>'unable to clear document access list!'];
               
                 return json_encode($response);  
             }
             
             $response[data]=['flag'=>true,'message'=>'Inherit Access enabled'];
               
                 return json_encode($response);
             
             
         }
       //-----------------------------------set owner-------------------------------------------
       
        else if($action=='setowner'){
             
             if(!isset($_POST['docid']) || $_POST['docid']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid document ID'];
              
              return json_encode($response); 
           }
           
             if(!isset($_POST['owner']) || $_POST['owner']==null){
               
              $response[data]=['flag'=>false,'error'=>'Invalid Owner ID'];
              
              return json_encode($response); 
           }
           
            
            $docid=$_POST['docid'];
            $owner=$_POST['owner'];
           
            
            $doc=Tbldocuments::find()->where(['id'=>$docid])->one();
            
             if($doc==null){
               
                $response[data]=['flag'=>false,'error'=>'target document not found'];
               
                return json_encode($response);  
             }
             
          //------------------set owner----------------------------------   
            
             
             if(!$doc->setOwner($owner)){
                
                 $response[data]=['flag'=>false,'error'=>'unable to set document owner !'];
               
                 return json_encode($response);  
                 
             }
        
             
             $response[data]=['flag'=>true,'message'=>'Owner set successfully !'];
               
                 return json_encode($response);
             
             
         }
         
         
             
              }
         
     }
     
     
public function actionRemoveAccess(){
    
     if(Yii::$app->request->post()){
         
           $isuser=$_POST['isuser'];
           $target=$_POST['target'];
           $grouporuserid=$_POST['grouporuserid'];
           
           $document=Tbldocuments::find()->where(['id'=>$target])->One(); 
           
          
           
           if($document!=null){
              
            if(!$document->removeAccess($grouporuserid, $isuser)) {
              
              $response[data]=['flag'=>false,'error'=>"Unable to remove access"];
            
              return json_encode($response);  
                
             }
             
             $response[data]=['flag'=>true,'message'=>"Access Removed !",'target'=> $isuser?"users":'groups'];
              return json_encode($response);
               
           }else{
               
                $response[data]=['flag'=>false,'error'=>"document not found!"];
              return json_encode($response);
           }
           
           
         
       }
    
    
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
$totalRecords =Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$id])->andWhere(['<>', 'groupID',-1])->count();

$modelsGroup=Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$id])->andWhere(['<>', 'groupID',-1])->all();

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
$totalRecords =Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$id])->andWhere(['<>', 'userID',-1])->count();


$modelsUser=Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$id])->andWhere(['<>', 'userID',-1])->all();

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
     * Creates a new Tbldocuments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TbldocumentsDetails();
        
       
        if(Yii::$app->request->isAjax){

        $html = $this->renderAjax('_form', [
            'model' =>$model,'folderid'=>$_GET['folderid'],'isNewRecord'=>true
             
    ]);
     
         return $this->asJson($html); 
    
        }

        return $this->render('_form', [
            'model' => $model,'folderid'=>$_GET['folderid'],'isNewRecord'=>true
        ]);
    }

    /**
     * Updates an existing Tbldocuments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $documentDetails=new TbldocumentsDetails();
        

        if (Yii::$app->request->post()){
            
             if(isset($_POST['TbldocumentsDetails'])){
                
              
                 //--------------------------check file errors------------------------------- 
                   if($_FILES && $_FILES['TbldocumentsDetails']['name']['uploaded_file']) {
                   
                   $documentDetails->attributes=$_POST['TbldocumentsDetails'];
                  
                   $contentFile = UploadedFile::getInstance($documentDetails, 'uploaded_file');
                   
                   
                   $version_comment=$documentDetails->comment;
                    
                   
                   $flag=$model->addContent($contentFile,null,$version_comment);
                  
                 
                  if($flag){
                      
                        $successMsg="Document Updated Successfully!";
                        
                        Yii::$app->session->setFlash('success', $successMsg);
                        
                  }else{
                      
                      $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>';
                      
                      Yii::$app->session->setFlash('error', $errorMsg);
                       
                      
                  } 
                      }
                    else{
                
                $errorMsg = '<ul style="margin:0"><li>' . "Error Uploading Empty Document !" . '</li></ul>'; 
                
                return $this->redirect(['view','id'=>$model->id]); 

                
              }
                 
                  
                    
                 
                   return $this->redirect(['view','id'=>$model->id]);
            }
    //----------------------ENDING FILE ERROR CHECK------------------------------        
           
                 
            
            
    

         
       }//---------END POST------------ 
        
        if(Yii::$app->request->isAjax){
         
        $html = $this->renderAjax('_update',[
        
        'model'=>$documentDetails,'document'=>$model->id,'isNewRecord'=>false]);
        // return $html;
    
        return Json::encode($html);  
         
     }

        return $this->render('_update', [
            'model' => $documentDetails,'document'=>$model->id,'isNewRecord'=>false
        ]);
    }
    
    
    public function actionEdit($id){
        
        
        $model = $this->findModel($id);
        
        

        if (Yii::$app->request->post()){
            
             if(isset($_POST['Tbldocuments'])){
                
             
                   
                   $model->attributes=$_POST['Tbldocuments'];
                   
                 
                   $flag=$model->save(false);
                  
                 
                  if($flag){
                      
                        $successMsg="Document information Updated!";
                        
                        Yii::$app->session->setFlash('success', $successMsg);
                        
                  }else{
                      
                      $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>';
                      
                      Yii::$app->session->setFlash('error', $errorMsg);
                       
                      
                  } 
                     
                  
            }
    //----------------------ENDING FILE ERROR CHECK------------------------------        
           
                 
            
           return $this->redirect(['view','id'=>$model->id]); 
    

         
       }//---------END POST------------ 
        
        if(Yii::$app->request->isAjax){
         
        $html = $this->renderAjax('_form',[
        
        'model'=>$model]);
    
        return $html;  
         
     }

        $html= $this->render('_form', [
            'model' => $model
        ]);   
        
        return $html;
    }

    /**
     * Deletes an existing Tbldocuments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $model= $this->findModel($id);
       $flag= $model->remove();
       $res=array();
       if(!$flag){
           
          $res[]=['out'=>'Unable to delete the document !','status'=>'error'] ;
       }else{
           
           $res[]=['out'=>'document deleted !','status'=>'success'] ;
       }
       
        
       if (Yii::$app->has('session')) {
            
            $session = Yii::$app->session;
            $session->set('w0-nodesel',$model->folder);
        }

      return json_encode($res);
       
    }

    /**
     * Finds the Tbldocuments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tbldocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tbldocuments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
