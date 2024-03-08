<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request_approval_flow".
 *
 * @property int $id
 * @property int $originator
 * @property int $approver
 * @property string $status
 * @property string $remark
 * @property int $is_new
 * @property string $timestamp
 */
class ErpTravelRequestApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_request_approval_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_id','originator', 'approver', 'remark'], 'required'],
            [['tr_id','originator', 'approver', 'is_new'], 'integer'],
            [['status', 'remark'], 'string'],
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
            'originator' => 'Originator',
            'approver' => 'Approver',
            'status' => 'Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
            'timestamp' => 'Timestamp',
        ];
    }
}
