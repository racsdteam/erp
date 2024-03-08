<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_documents".
 *
 * @property int $id
 * @property int $employee
 * @property int $document
 * @property string $details
 * @property string $attachment
 * @property string $fileType
 * @property string $mimeType
 * @property string $date_added
 *
 * @property Documents $document0
 * @property Employees $employee0
 */
class EmpDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public $upload_file;
     
    public static function tableName()
    {
        return 'emp_documents';
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
            [['employee','document','category','details','fileType', 'mimeType','file_name'], 'required'],
            [['employee'], 'integer'],
            [['details'], 'string'],
            [['fileType', 'mimeType','document','file_name'], 'string', 'max' => 255],
            [['upload_file'], 'file', 'extensions'=>'pdf, PDF','skipOnEmpty'=>false,'maxFiles' => 1,'minFiles'=>1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'document' => 'Document',
            'details' => 'Details',
            'file_name' => 'File Name',
            'fileType' => 'File Type',
            'mimeType' => 'Mime Type',
            'date_added' => 'Date Added',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument0()
    {
        return $this->hasOne(Documents::className(), ['id' => 'document']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
}
