<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tbldocumentfiles".
 *
 * @property int $id
 * @property int $document
 * @property int $userID
 * @property string $comment
 * @property string $name
 * @property int $date
 * @property string $dir
 * @property string $orgFileName
 * @property string $fileType
 * @property string $mimeType
 *
 * @property Tbldocuments $document0
 * @property Tblusers $user
 */
class Tbldocumentfiles extends \yii\db\ActiveRecord
{
    
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbldocumentfiles';
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
            [['document', 'userID'], 'integer'],
            [['comment'], 'string'],
            [['date'],'safe'],
            [['name', 'orgFileName'], 'string', 'max' => 150],
            [['dir'], 'string', 'max' => 255],
            [['fileType'], 'string', 'max' => 10],
            [['mimeType'], 'string', 'max' => 100],
            [['document'], 'exist', 'skipOnError' => true, 'targetClass' => Tbldocuments::className(), 'targetAttribute' => ['document' => 'id']],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'user_id']],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document' => 'Document',
            'userID' => 'User ID',
            'comment' => 'Comment',
            'name' => 'Name',
            'date' => 'Date',
            'dir' => 'Dir',
            'orgFileName' => 'Org File Name',
            'fileType' => 'File Type',
            'mimeType' => 'Mime Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument0()
    {
        return $this->hasOne(Tbldocuments::className(), ['id' => 'document']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'userID']);
    }
    
    public function getPath(){
        
       
      $uploadPath=DmsUtils::getUploadPath();
       
      $data=$this->dir.'f'.$this->id.$this->fileType;
      
      $full_path= $uploadPath.'/'.$data;

      return $full_path; 
        
    }
     public function getUrl(){
        
      return $this->dir.'f'.$this->id.$this->fileType;
        
    }
}
