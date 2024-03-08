<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_request_supporting_doc".
 *
 * @property int $id
 * @property string $title
 * @property string $doc_upload
 * @property int $lpo_request
 */
class ErpLpoRequestSupportingDoc extends \yii\db\ActiveRecord
{
    public $doc_uploaded_files;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request_supporting_doc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uploaded_by', 'doc_upload','doc_name', 'lpo_request'], 'required'],
            [['id', 'lpo_request','uploaded_by'], 'integer'],
            [['doc_upload','doc_name'], 'string', 'max' => 255],
             [['doc_uploaded_files'], 'file', 'extensions'=>'pdf','skipOnEmpty'=>true,'maxFiles' => 10,'minFiles'=>1],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Document Type',
            'doc_upload' => 'Doc Upload',
            'lpo_request' => 'Lpo Request',
            'doc_uploaded_files'=>'Upload File(s)'
        ];
    }
}
