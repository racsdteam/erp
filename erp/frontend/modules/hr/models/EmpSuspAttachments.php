<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_susp_attachments".
 *
 * @property int $id
 * @property int $susp
 * @property string $title
 * @property string $category
 * @property string $fileName
 * @property string $dir
 * @property string $fileType
 * @property string $mimeType
 * @property int $user
 * @property string $timestamp
 */
class EmpSuspAttachments extends \yii\db\ActiveRecord
{
     public $upload_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_susp_attachments';
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
            [['susp', 'title', 'category', 'fileName', 'dir', 'fileType', 'mimeType', 'user'], 'required'],
            [['susp', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['title', 'fileName', 'dir', 'fileType', 'mimeType'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 11],
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
            'susp' => 'Susp',
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
}
