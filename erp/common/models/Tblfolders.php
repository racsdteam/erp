<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tblfolders".
 *
 * @property int $id Unique tree node identifier
 * @property int $root Tree root identifier
 * @property int $lft Nested set left property
 * @property int $rgt Nested set right property
 * @property int $lvl Nested set level / depth
 * @property string $name The tree node name / label
 * @property string $icon The icon to use for the node
 * @property int $icon_type Icon Type: 1 = CSS Class, 2 = Raw Markup
 * @property int $active Whether the node is active (will be set to false on deletion)
 * @property int $selected Whether the node is selected/checked by default
 * @property int $disabled Whether the node is enabled
 * @property int $readonly Whether the node is read only (unlike disabled - will allow toolbar actions)
 * @property int $visible Whether the node is visible
 * @property int $collapsed Whether the node is collapsed by default
 * @property int $movable_u Whether the node is movable one position up
 * @property int $movable_d Whether the node is movable one position down
 * @property int $movable_l Whether the node is movable to the left (from sibling to parent)
 * @property int $movable_r Whether the node is movable to the right (from sibling to child)
 * @property int $removable Whether the node is removable (any children below will be moved as siblings before deletion)
 * @property int $removable_all Whether the node is removable along with descendants
 * @property int $child_allowed Whether to allow adding children to the node
 */
class Tblfolders  extends \kartik\tree\models\Tree
{
     const T_FOLDER=2;
     public $access_mode_type;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblfolders';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['comment'], 'string'],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'name' => 'Name',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'child_allowed' => 'Child Allowed',
        ];
    }
    
    public function addDocument($docDetails){
        
        
         $transaction = \Yii::$app->db3->beginTransaction();
                 
                try {
                    
                  $model=new Tbldocuments(); 
                  
                  $model->name=$docDetails->name; 
                  
                  if($docDetails->comment)
                 
                  $model->comment=$docDetails->comment;
                  
                  if($docDetails->expires)
                  
                  $model->expires=$docDetails->expires;
                  
                  $model->folder=$this->id;
                  
                  $contentFile =$docDetails->uploaded_file;
                 
                     if($model->name==null)
                     
                     $model->name =$contentFile->name;
                     
                    $version= $model->isNewRecord ? 1:null;
                    $version_comment='';         
                       
            if (!$flag=$model->save() && $model->addContent($contentFile ,$version,$version_comment)) {  
                
                 $this->addErrors($model->getFirstErrors());
                 
                //$errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>';
                
                 }
            //--------------------END ELSE MODEL SAVE----------------------------      
                  
                 
                       
                 if ($flag) {
                       // $successMsg="Document Saved Successfully!";
                       // Yii::$app->session->setFlash('success', $successMsg); 
                        $transaction->commit();
                 
                      
                      } else{
                          
                           //Yii::$app->session->setFlash('error', $errorMsg);
                           $transaction->rollBack();
                        }
                      
                     
                }
      //-------------------ENDINF TRY-----------------------------------           
              catch (Exception $e) {
                    $transaction->rollBack();
                }
                   
       return $flag; 
        
    }
    
    public function uploadFiles($Files){
      
      $files="";
    $allwoedFiles=['jpg', 'gif', 'png', 'doc', 'docx', 'pdf', 'xlsx', 'rar', 'zip', 'xlsx', 'xls', 'txt', 'csv', 'rtf', 'one', 'pptx', 'ppsx', 'pot'];

    if (!empty($Files)) {
      
        if (count($Files['files']['name']) > 0) {
           
            //Loop through each file
            for ($i = 0; $i < count($Files['files']['name']); $i++) {
                //Get the temp file path
                $tmpFilePath = $Files['files']['tmp_name'][$i];
                
                //Make sure we have a filepath
                if ($tmpFilePath != "") {
                    //save the filename
                   
                    $shortname = $uploadedFiles['files']['name'][$i];
                    $size = $uploadedFiles['files']['size'][$i];
                    $ext = substr(strrchr($shortname, '.'), 1);
                    
                    $document=new Tbldocument();
                    $document->name= $shortname;
                    $document->folder=$this->id;
                    $document->save();
                    
                    if(in_array($ext,$allwoedFiles)){
                        //save the url and the file
                        $newFileName = Yii::$app->security->generateRandomString(40) . "." . $ext;
                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, Helper::UPLOAD_FOLDER . '/' . Helper::TEMP_FOLDER . '/' . $newFileName)) {
                            $files[] =['fileName'=>$newFileName,'type'=>$ext,'size'=>(($size/1000)),'originalName'=>$shortname];
                        }

                    }
                }
            }
        }

    }
    return $files;  
        
    }
    
      public function addAccess($mode, $userOrGroupID, $isUser){
       
            $userOrGroup = ($isUser) ? "userID" : "groupID";
            
            $model=new Tblacls();   
            $model->$userOrGroup=$userOrGroupID;
            $model->mode=$mode;
            $model->target=$this->id;
            $model->targetType=self::T_FOLDER;
            
            if(!$model->save()){
                
             $this->addErrors($model->getFirstErrors()); 
             
             return false;
            }
       
       return true;
   }
    public function removeAccess($userOrGroupID, $isUser){
  
  $userOrGroup = ($isUser) ? "userID" : "groupID";
  
  $model=Tblacls::find()->where(['targetType'=>self::T_FOLDER,'target'=>$this->id,$userOrGroup=>$userOrGroupID])->one();
  
  return $model->delete();

 }
 
 public function setDefaultAccess($access){
     
     $this->defaultAccess=$access;
     
      if(!$this->save(false)){
          
        return false;  
      }
      
      return true;
     
 }
 
 
  public function setOwner($owner){
     
     $this->user=$owner;
     
      if(!$this->save(false)){
          
        return false;  
      }
      
      return true;
     
 }
 
 
 
 public function clearAccessList(){
     
 return  Tblacls::deleteAll(['targetType' =>self::T_FOLDER,'target'=>$this->id]);   
     
 }
 
 public	function getAccessMode($user) { 
 
 
		if(!$user)
			return Tblacls::M_NONE;

		/* Admins have full access */
		if ($user->isAdmin()) return Tblacls::M_ALL;

		/* User has full access if he/she is the owner of the document */
		if ($user->user_id == $this->user) return Tblacls::M_ALL;

		/* Guest has read access by default, if guest login is allowed at all */
	/*	if ($user->isGuest()) {
			$mode = $this->getDefaultAccess();
			if ($mode >= M_READ) return Tblacls::M_READ;
			else return Tblacls::M_NONE;
		}*/

		/* check ACLs */
		$accessList = $this->getAccessList();
		
		if (!$accessList) return false;

		foreach ($accessList["users"] as $userAccess) {
			if ($userAccess->userID== $user->user_id) {
				
				return $userAccess->mode;
			}
		}
		/* Get the highest right defined by a group */
		$result = 0;
		foreach ($accessList["groups"] as $groupAccess) {
		
		$group=Tblgroups::find()->where(['id'=>$groupAccess->groupID])->one();
		
		if($group->type==1){
		    
		   if ($user->isMemberOfGroup($group->name,true)) {
				if ($groupAccess->mode > $result)
					$result = $groupAccess->mode;

			} 
		}else if($group->type==2){
		   
		   //------------find local 
		    
	     	}
		
			
			
		}
		if($result)
			return $result;
		$result = $this->getDefaultAccess();
		return $result;
	}
 
 public function getAccessList(){

$accesslist=array();

$modelsGroup=Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$this->id])->andWhere(['<>', 'groupID',-1])->all();

$accesslist['groups']=$modelsGroup;
 
$modelsUser=Tblacls::find()->where(['targetType'=>2])->andWhere(['target'=>$this->id])->andWhere(['<>', 'userID',-1])->all();    

$accesslist['users']=$modelsUser;     

return  $accesslist; 
     
 }
 
 public function getDefaultAccess() { 
	
		if ($this->inheritAccess) {
			
			$parent=$this->parents(1)->one();
			
			if (!$parent) return false;
			
			return $parent->getDefaultAccess();
		}

		return $this->defaultAccess;
	}
	
    
    public function remove($softDelete = true, $currNode = true){


 // Do not delete the root folder.
		if ($this->isRoot()  || ($this->parents(1)->one() == null) ) {
			return false;
		}   
       $transaction = \Yii::$app->db3->beginTransaction();
                 
                try {
            $subfolders= $this->getSubFolders();
		
	     	$docs = $this->getDocuments();
	
        
	     if(!empty($docs)){
	         
	         	foreach ($docs as $document) {
			$res = $document->remove();
			if (!$res) {
			    $transaction->rollBack();
				return false;
			}
		}
	     }
	     
	      if(!empty($subfolders)){
             
             	foreach ($subfolders as $subFolder) {
			$res = $subFolder->remove();
			if (!$res) {
			    $transaction->rollBack();
				return false;
			}
		}
             
         }
          
          if(!$this->removeNode($softDelete)){
            
            $transaction->rollBack();
            return false;
              
          }
       

       $transaction->commit(); 
	   return true;	
                      
                     
                }
      //-------------------ENDINF TRY-----------------------------------           
              catch (Exception $e) {
                    $transaction->rollBack();
                }
                
              
    
}

public function getSubFolders(){
    
  return $this->children(1)->all();  
    
}

public function getDocuments(){
    
$documents=Tbldocuments::find()->where(['folder'=>$this->id])->all();

return $documents;
    
}
 
}
