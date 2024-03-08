<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payroll_run_report_attachments".
 *
 * @property int $id
 * @property int $report
 * @property string $title
 * @property string $category
 * @property string $fileName
 * @property string $dir
 * @property string $fileType
 * @property string $mimeType
 * @property int $user
 * @property string $timestamp
 */
class PayrollRunReportAttachments extends \yii\db\ActiveRecord
{
    
       public $upload_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_run_report_attachments';
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
            [['report', 'title',  'fileName', 'dir', 'fileType', 'mimeType', 'user'], 'required'],
            [['report', 'user'], 'integer'],
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
            'report' => 'report',
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
