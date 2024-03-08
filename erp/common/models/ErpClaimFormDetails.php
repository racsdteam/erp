<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_claim_form_details".
 *
 * @property int $id
 * @property int $claim_form
 * @property string $pariculars
 * @property string $country
 * @property string $from
 * @property string $to
 * @property string $timestamp
 */
class ErpClaimFormDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_claim_form_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pariculars', 'country', 'from', 'to'], 'required'],
            [['from', 'to'], 'safe'],
            [['pariculars', 'country'], 'string', 'max' => 256],
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
            'pariculars' => 'Particulars',
            'country' => 'Country',
            'from' => 'From',
            'to' => 'To',
            'timestamp' => 'Timestamp',
        ];
    }
}
