<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_term_attachments".
 *
 * @property int $id
 * @property int $term
 * @property string $title
 * @property int $category
 * @property string $filetitle
 * @property string $dir
 * @property string $fileType
 * @property string $mimeType
 * @property int $user
 * @property string $timestamp
 */
class EmpTermAttachments extends \yii\db\ActiveRecord
{
     public $upload_file;
     
    /**
     * {@inheritdoc}
     */
    public static function tabletitle()
    {
        return 'emp_term_attachments';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['term', 'title', 'category', 'fileName', 'dir', 'fileType', 'mimeType', 'user'], 'required'],
            [['term',  'user'], 'integer'],
            [['category'], 'string', 'max' => 11],
            [['timestamp'], 'safe'],
            [['title', 'fileName', 'dir', 'fileType', 'mimeType'], 'string', 'max' => 255],
            [['upload_file'], 'file', 'extensions'=>'pdf','skipOnEmpty'=>false],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term' => 'Term',
            'title' => 'Title',
            'category' => 'Category',
            'fileName' => 'File Name',
            'dir' => 'Dir',
            'fileType' => 'File Type',
            'mimeType' => 'Mime Type',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
     public function getCategory0()
    {
        return $this->hasOne(EmployeeDocsCategories::className(), ['code' => 'category']);
    }
  
}
