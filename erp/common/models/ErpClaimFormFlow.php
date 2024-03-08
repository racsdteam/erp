<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_claim_form_flow".
 *
 * @property int $id
 * @property int $claim_form
 * @property int $creator
 * @property string $timestamp
 */
class ErpClaimFormFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_claim_form_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claim_form', 'creator'], 'required'],
            [['claim_form', 'creator'], 'integer'],
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
            'claim_form' => 'Claim Form',
            'creator' => 'Creator',
            'timestamp' => 'Timestamp',
        ];
    }
}
