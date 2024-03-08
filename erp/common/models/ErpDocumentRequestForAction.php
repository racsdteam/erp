<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_request_for_action".
 *
 * @property int $id
 * @property int $document
 * @property string $action
 * @property int $requested_by
 * @property string $timestamp
 */
class ErpDocumentRequestForAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_request_for_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document', 'action_description', 'requested_by','action_handler'], 'required'],
            [['document', 'requested_by','is_new','action_handler'], 'integer'],
            [['action_description'], 'string'],
            [['timestamp'], 'safe'],
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
            'action_description' => 'Action',
            'requested_by' => 'Requested By',
            'timestamp' => 'Timestamp',
        ];
    }
}
