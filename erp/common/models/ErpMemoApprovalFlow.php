<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_flow_approvers".
 *
 * @property int $id
 * @property int $memo_id
 * @property int $approver
 * @property int $originator
 * @property int $is_new
 * @property int $is_forwarded
 * @property string $timestamp
 */
class ErpMemoApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_approval_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memo_id', 'approver', 'originator','status'], 'required'],
            [['memo_id', 'approver', 'originator', 'is_new'], 'integer'],
            [['status','remark'],'string'],
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
            'memo_id' => 'Flow ID',
            'approver' => 'approver',
            'originator' => 'originator',
            'is_new' => 'Is New',
            'is_forwarded' => 'Is Forwarded',
            'timestamp' => 'Timestamp',
        ];
    }
}
