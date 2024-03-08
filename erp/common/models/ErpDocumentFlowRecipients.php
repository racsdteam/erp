<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_flow_recipients".
 *
 * @property int $id
 * @property int $flow_id
 * @property int $recipient
 *  @property int $status
 */
class ErpDocumentFlowRecipients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_flow_recipients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document', 'recipient','sender'], 'required'],
            [['document', 'recipient','sender'], 'integer'],
            [['is_new'], 'integer'],
            [['remark'], 'string'],
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
            'user' => 'User',
        ];
    }
}
