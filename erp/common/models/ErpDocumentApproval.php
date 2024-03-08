<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_approval".
 *
 * @property int $id
 * @property int $document
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property int $is_new
 */
class ErpDocumentApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document', 'approved_by', 'approval_status'], 'required'],
            [['document', 'approved_by', 'is_new'], 'integer'],
            [['approved'], 'safe'],
            [['approval_status','remark'], 'string'],
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
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'is_new' => 'Is New',
        ];
    }
}
