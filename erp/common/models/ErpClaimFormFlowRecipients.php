<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_claim_form_flow_recipients".
 *
 * @property int $id
 * @property int $flow_id
 * @property int $recipient
 * @property int $sender
 * @property int $is_new
 * @property string $status
 * @property string $timestamp
 */
class ErpClaimFormFlowRecipients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_claim_form_flow_recipients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flow_id', 'recipient', 'sender'], 'required'],
            [['flow_id', 'recipient', 'sender', 'is_new'], 'integer'],
            [['status'], 'string'],
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
            'sender' => 'Sender',
            'is_new' => 'Is New',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
