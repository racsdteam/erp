<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_photo".
 *
 * @property int $id
 * @property int $employee
 * @property string $dir
 * @property string $file_name
 * @property string $file_type
 * @property string $mime_type
 * @property string $timestamp
 * @property int $active
 *
 * @property Employees $employee0
 */
class EmpPhoto extends \yii\db\ActiveRecord
{
    
     public $upload_file;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_photo';
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
            [['employee', 'dir', 'file_name'], 'required'],
            [['employee', 'active'], 'integer'],
            [['timestamp'], 'safe'],
            [['dir', 'file_name', 'file_type', 'mime_type'], 'string', 'max' => 255],
            [['employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee' => 'id']],
            [['upload_file'], 'file', 'extensions'=>'jpg,png','skipOnEmpty'=>true],//validating inputfile
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
            'dir' => 'Dir',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'mime_type' => 'Mime Type',
            'timestamp' => 'Timestamp',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
}
