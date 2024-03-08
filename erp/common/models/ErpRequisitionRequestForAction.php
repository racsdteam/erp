<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_requisition_request_for_action".
 *
 * @property int $id
 * @property int $requisition
 * @property string $action_description
 * @property int $requested_by
 * @property int $action_handler
 * @property int $is_new
 * @property string $status
 * @property string $timestamp
 */
class ErpRequisitionRequestForAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition_request_for_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requisition', 'action_description', 'requested_by', 'action_handler'], 'required'],
            [['requisition', 'requested_by', 'action_handler', 'is_new'], 'integer'],
            [['action_description', 'status'], 'string'],
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
            'requisition' => 'Requisition',
            'action_description' => 'Action Description',
            'requested_by' => 'Requested By',
            'action_handler' => 'Action Handler',
            'is_new' => 'Is New',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
