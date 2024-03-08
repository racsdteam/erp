<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_clearance_flow_recipients".
 *
 * @property int $id
 * @property int $flow_id
 * @property int $recipient
 * @property string $status
 * @property string $remark
 * @property int $sender
 * @property int $is_new
 * @property int $is_forwarded
 * @property string $timestamp
 */
class ErpTravelClearanceFlowRecipients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_clearance_flow_recipients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flow_id', 'recipient', 'remark', 'sender'], 'required'],
            [['flow_id', 'recipient', 'sender', 'is_new', 'is_forwarded'], 'integer'],
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
            'flow_id' => 'Flow ID',
            'recipient' => 'Recipient',
            'status' => 'Status',
            'remark' => 'Remark',
            'sender' => 'Sender',
            'is_new' => 'Is New',
            'is_forwarded' => 'Is Forwarded',
            'timestamp' => 'Timestamp',
        ];
    }
}
