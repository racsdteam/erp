<?php

namespace common\models;

use Yii;

use yii\helpers\FileHelper ;
use common\models\DmsUtils;

/**
 * This is the model class for table "tbldocuments".
 *
 * @property int $id
 * @property string $name
 * @property string $comment
 * @property string $date
 * @property string $expires
 * @property int $owner
 * @property int $folder
 * @property int $locked
 * @property int $status
 *
 * @property Tbldocumentattributes[] $tbldocumentattributes
 * @property Tblattributedefinitions[] $attrdefs
 * @property Tbldocumentcategory[] $tbldocumentcategories
 * @property Tbldocumentcontent[] $tbldocumentcontents
 * @property Tbldocumentfiles[] $tbldocumentfiles
 * @property Tbldocumentlinks[] $tbldocumentlinks
 * @property Tbldocumentlinks[] $tbldocumentlinks0
 * @property Tbldocumentlocks $tbldocumentlocks
 * @property Tbldocumentreviewers[] $tbldocumentreviewers
 * @property Tblfolders1 $folder0
 * @property Tblusers $owner0
 * @property Tbldocumentstatus[] $tbldocumentstatuses
 */
class Tbldocuments extends \yii\db\ActiveRecord
{
    
     public $uploaded_file;
     public $errors=[];
     
    
     public $groups_access_modes;
    
     public $users_access_modes;
     
     const T_DOCUMENT=1;
    
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbldocuments';
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
            [['comment'], 'string'],
            [['date', 'expires'], 'safe'],
            [['owner', 'folder', 'locked', 'status'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['folder'], 'exist', 'skipOnError' => true, 'targetClass' => Tblfolders::className(), 'targetAttribute' => ['folder' => 'id']],
            [['owner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner' => 'id']],
            [['uploaded_file'], 'file', 'skipOnEmpty'=>true],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'comment' => 'Comment',
            'date' => 'Date',
            'expires' => 'Expires',
            'owner' => 'Owner',
            'folder' => 'Folder',
            'locked' => 'Locked',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentattributes()
    {
        return $this->hasMany(Tbldocumentattributes::className(), ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrdefs()
    {
        return $this->hasMany(Tblattributedefinitions::className(), ['id' => 'attrdef'])->viaTable('tbldocumentattributes', ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentcategories()
    {
        return $this->hasMany(Tbldocumentcategory::className(), ['documentID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentcontents()
    {
        return $this->hasMany(Tbldocumentcontent::className(), ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentfiles()
    {
        return $this->hasMany(Tbldocumentfiles::className(), ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentlinks()
    {
        return $this->hasMany(Tbldocumentlinks::className(), ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentlinks0()
    {
        return $this->hasMany(Tbldocumentlinks::className(), ['target' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentlocks()
    {
        return $this->hasOne(Tbldocumentlocks::className(), ['document' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentreviewers()
    {
        return $this->hasMany(Tbldocumentreviewers::className(), ['documentID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder0()
    {
        return $this->hasOne(Tblfolders1::className(), ['id' => 'folder']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(Tblusers::className(), ['id' => 'owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbldocumentstatuses()
    {
        return $this->hasMany(Tbldocumentstatus::className(), ['documentID' => 'id']);
    }
    
    /**
     * Add contentFile
     */
   
     public function addContent($contentFile,$version,$version_comment){
    
    
      if($version==null){
      
      $latestContent=$this->getLatestContent(); 
      
      $currentversion=$latestContent->version + 1; 

       }else{
           
           $currentversion=$version;
       }
      
       
     $checksum=md5_file($contentFile->tempName);  
     $content=new Tbldocumentcontent();
     $content->document=$this->id;
     $content->version=$currentversion;
     $content->orgFileName=$contentFile->name;
     $content->fileType=$contentFile->extension;
     $content->mimeType=$contentFile->type;
     $content->fileSize=$contentFile->size;
     $content->checksum=$checksum;
     $content->comment=$version_comment;
     $content->createdBy=Yii::$app->user->identity->user_id;
     $content->dir=$this->getDir();
     
     if(!$content->save()){
      
        $this->addErrors($content->getFirstErrors());
    
         return false;
     }
         
           $uploadDir=DmsUtils::getUploadDir();
          
          if(!FileHelper::createDirectory($uploadDir.'/'.$this->getDir())){
              
            return false;
          }
      
          if(!$contentFile->saveAs($uploadDir.'/'.$this->getDir().$content->version.$content->fileType)){
             
            return false;
          }
          
        
        
    
      return true;  
    
     }
    
   
   
    public function getDir(){
        
        
   return $this->id.DIRECTORY_SEPARATOR;
    
      }
      
      public function getVersion(){
          
          
          
      }
    
     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                
                $this->owner=Yii::$app->user->identity->user_id;
               
            }
            return true;
        } else {
            return false;
        }
    }
   
   public function getContent(){
       
 $content=Tbldocumentcontent::find()->where(['document'=>$this->id])->orderBy(['version' => SORT_DESC])
      ->all();
      
      return $content;
   } 
   
   
   public function getLatestContent(){
       
     $content=Tbldocumentcontent::find()->where(['document'=>$this->id])->orderBy(['version' => SORT_DESC])
      ->one();
      
      return $content;
   } 
   
 //=========================================get  document content by version===============================================  
  
  public function getContentByVersion($v){
      
      $content=Tbldocumentcontent::find()->where(['document'=>$this->id,'version'=>$v])
      ->one();
     
      return $content;
  }
  
  //=========================================add document attachemnts===============================================
  
  public function addDocumentFile($modelForm){
     
     if(!$name=$modelForm->name){
          
          $name=$modelForm->uploaded_file->name;
         }
         
      $documentfile=new Tbldocumentfiles();
      $documentfile->name=$name;
      $documentfile->document=$this->id;
      $documentfile->orgFileName=$modelForm->uploaded_file->name;
      $documentfile->fileType=$modelForm->uploaded_file->extension;
      $documentfile->mimeType=$modelForm->uploaded_file->type;
      $documentfile->comment=$modelForm->comment;
      $documentfile->dir=$this->getDir(); 
      $documentfile->userID=Yii::$app->user->identity->user_id;
     

     $transaction = \Yii::$app->db3->beginTransaction();
     
      if(!$flag=$documentfile->save()){
      
        $this->addErrors($documentfile->getFirstErrors());
        
    
        }else{
           
        $dataDir=Yii::getAlias('@dataDir');
        
        $path=$dataDir.'/'.$this->getDir();  
         
         if(!is_dir($path))
           
           FileHelper::createDirectory($path);
              
     
     if(!$modelForm->uploaded_file->saveAs($path.'f'.$documentfile->id.$documentfile->fileType)){
             
              $flag=false;
            } 
                 
           
        }
       
              
                 if ($flag) {
                       
                       
                        $transaction->commit();
                 
                      
                      } else{
                          
                         
                           $transaction->rollBack();
                        }
                      
      return $flag;
   }
   
 //=========================================get document attachemnts==============================================  
   public function getDocumentFiles(){
       
     $files=Tbldocumentfiles::find()->where(['document'=>$this->id])->orderBy(['date' => SORT_DESC])
      ->all();
      
      return $files;   
       
   }
   
   //=========================================add access===============================================
     public function addAccess($mode, $userOrGroupID, $isUser){
       
            $userOrGroup = ($isUser) ? "userID" : "groupID";
            
            $model=new Tblacls();   
            $model->$userOrGroup=$userOrGroupID;
            $model->mode=$mode;
            $model->target=$this->id;
            $model->targetType=self::T_DOCUMENT;
            
            if(!$model->save()){
                
             $this->addErrors($model->getFirstErrors()); 
             
             return false;
            }
       
       return true;
   }
   
   //=========================================remove access==============================================
   
    public function removeAccess($userOrGroupID, $isUser){
  
  $userOrGroup = ($isUser) ? "userID" : "groupID";
  
  $model=Tblacls::find()->where(['targetType'=>self::T_DOCUMENT,'target'=>$this->id,$userOrGroup=>$userOrGroupID])->one();
  
  return $model->delete();

 }
 
 //=========================================set default access===============================================
 public function setDefaultAccess($access){
     
     $this->defaultAccess=$access;
     
      if(!$this->save(false)){
          
        return false;  
      }
      
      return true;
     
 }
 
//=========================================set owner=============================================== 
  public function setOwner($owner){
     
     $this->owner=$owner;
     
      if(!$this->save(false)){
          
        return false;  
      }
      
      return true;
     
 }
 
//========================================clear access list=============================================== 
 
 public function clearAccessList(){
  
  if(empty($this->getAccessList()))
  
  return true;
     
 return  Tblacls::deleteAll(['targetType' =>self::T_DOCUMENT,'target'=>$this->id]);   
     
 }


//=========================================get user access mode===============================================


 public	function getAccessMode($user) { 
 
 
		if(!$user)
			return Tblacls::M_NONE;

		/* Admins have full access */
		if ($user->isAdmin()) return Tblacls::M_ALL;

		/* User has full access if he/she is the owner of the document */
		if ($user->user_id == $this->owner) return Tblacls::M_ALL;

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
 
 //=========================================get access list===============================================
 
 public function getAccessList(){

$accesslist=array();

$modelsGroup=Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$this->id])->andWhere(['<>', 'groupID',-1])->all();

if(!empty($modelsGroup))

$accesslist['groups']=$modelsGroup;
 
$modelsUser=Tblacls::find()->where(['targetType'=>1])->andWhere(['target'=>$this->id])->andWhere(['<>', 'userID',-1])->all();    

if(!empty($modelsUser))

$accesslist['users']=$modelsUser;     

return  $accesslist; 
     
 }
 
 
 //=========================================get default access===============================================
 
 public function getDefaultAccess() { 
	
		if ($this->inheritAccess) {
			
			$parent=Tblfolders::find()->where(['id'=>$this->folder])->one();
			
			if (!$parent) return false;
			
			return $parent->getDefaultAccess();
		}

		return $this->defaultAccess;
	}
	

//=========================================remove document===============================================

	public function remove(){
	 
	$content = $this->getContent();

	$files=$this->getDocumentFiles();
	
    $transaction = \Yii::$app->db3->beginTransaction();
                 
                try {
                    
                    
               if(!empty($content)){
                   
                         foreach ($content as $version) {
			 
			if (!$flag=$this->removeContent($version)) {
			    
			    $transaction->rollBack();
				return false;
			}
		} 
		
               }
             
             
              if(!empty($files)){
                   
                         foreach ($files as $f) {
			
			if (!$flag=$this->removeFile($f)) {
			    
			    $transaction->rollBack();
			
				return false;
			}
		} 
               }
                     
                }
      //-------------------ENDINF TRY-----------------------------------           
              catch (Exception $e) {
                    $transaction->rollBack();
                }
	  
	       
	       if (file_exists(DmsUtils::getUploadDir().'/'.$this->getDir())){
	           if (!$flag=rmdir(DmsUtils::getUploadDir().'/'.$this->getDir()))
				
				 $transaction->rollBack();
	           }
		
			
		     if(!$flag=$this->delete()){
		          
		          $transaction->rollBack();
		          return false;
		         
		     }
		      
		      $transaction->commit(); 
	          return true;
	    
	}
 
 //=========================================remove document content===============================================  
  public function removeContent($version) { 

   $uploadDir=DmsUtils::getUploadDir();
   
   $contentURL=$uploadDir.'/'.$version->getContentUrl();

		if (file_exists($contentURL))
		
			if (!unlink($contentURL))
				return false;

		    return $version->delete();
	}
	
	
	  public function removeFile($file) { 
	
	  $uploadDir=DmsUtils::getUploadDir();
     
      $fileURL=$uploadDir.'/'.$file->getUrl();
	
		if (file_exists($fileURL))
		
	if (!unlink($fileURL))
				return false;

		     return $file->delete();
	}
   
}
