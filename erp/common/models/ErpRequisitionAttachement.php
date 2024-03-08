<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_requisition_attachement".
 *
 * @property int $id
 * @property int $request_id
 * @property string $attach_title
 * @property string $attach_upload
 * @property string $created
 * @property int $created_by
 */
class ErpRequisitionAttachement extends \yii\db\ActiveRecord
{
    
     public $attach_files;
     //public $attach1_uploaded_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition_attachement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pr_id', 'attach_name', 'attach_upload', 'created_by'], 'required'],
            [['pr_id', 'created_by'], 'integer'],
            [['created'], 'safe'],
            [['attach_name', 'attach_upload'], 'string', 'max' => 255],
            [['attach_files'], 'file', 'extensions'=>'pdf,jpg','skipOnEmpty'=>true,'maxFiles' => 10,'minFiles'=>1]//validating inputfile
            //[['attach1_uploaded_file'], 'file', 'extensions'=>'pdf,jpg','skipOnEmpty'=>false],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'attach_name' => 'Attach Name',
            'attach_upload' => 'Attach Upload',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }
}
