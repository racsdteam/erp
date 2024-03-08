<?php

namespace common\models;
use yii\helpers\Url;
use Yii;
use common\models\DmsUtils;

/**
 * This is the model class for table "tbldocumentcontent".
 *
 * @property int $id
 * @property int $document
 * @property int $version
 * @property string $comment
 * @property string $date
 * @property int $createdBy
 * @property string $dir
 * @property string $orgFileName
 * @property string $fileType
 * @property string $mimeType
 * @property int $fileSize
 * @property string $checksum
 *
 * @property Tbldocuments $document0
 * @property Tbldocumentcontentattributes[] $tbldocumentcontentattributes
 * @property Tblattributedefinitions[] $attrdefs
 */
class Tbldocumentcontent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbldocumentcontent';
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
            [['document', 'version', 'createdBy', 'fileSize'], 'integer'],
            [['version'], 'required'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['dir'], 'string', 'max' => 255],
            [['orgFileName'], 'string', 'max' => 150],
            [['fileType'], 'string', 'max' => 10],
            [['mimeType'], 'string', 'max' => 100],
            [['checksum'], 'string', 'max' => 32],
            [['document', 'version'], 'unique', 'targetAttribute' => ['document', 'version']],
            [['document'], 'exist', 'skipOnError' => true, 'targetClass' => Tbldocuments::className(), 'targetAttribute' => ['document' => 'id']],
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
            'version' => 'Version',
            'comment' => 'Comment',
            'date' => 'Date',
            'createdBy' => 'Created By',
            'dir' => 'Dir',
            'orgFileName' => 'Org File Name',
            'fileType' => 'File Type',
            'mimeType' => 'Mime Type',
            'fileSize' => 'File Size',
            'checksum' => 'Checksum',
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
    public function getTbldocumentcontentattributes()
    {
        return $this->hasMany(Tbldocumentcontentattributes::className(), ['content' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrdefs()
    {
        return $this->hasMany(Tblattributedefinitions::className(), ['id' => 'attrdef'])->viaTable('tbldocumentcontentattributes', ['content' => 'id']);
    }
   
    
    public function getContentPath(){
   
    $uploadPath=DmsUtils::getUploadPath(); 
    
    $full_path=$uploadPath.'/'.$this->dir.$this->version.$this->fileType;
 
    return $full_path;
        

    }
    
    public function getContentUrl(){
        
     return   $this->dir.$this->version.$this->fileType;
    }
    
    public function getSize(){
    
     $size=DmsUtils::getContentSize($this->fileSize); 
     
     return $size;

        
    }
}
