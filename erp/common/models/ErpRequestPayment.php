<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_request_payment".
 *
 * @property int $id
 * @property int $invoice
 * @property int $memo
 * @property string $status
 * @property string $timestamp
 */
class ErpRequestPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_request_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice', 'memo'], 'required'],
            [['invoice', 'memo'], 'integer'],
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
            'invoice' => 'Invoice',
            'memo' => 'Memo',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
