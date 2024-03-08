<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_claim_form".
 *
 * @property int $id
 * @property int $request_id
 * @property int $person
 * @property string $purpose
 * @property string $title
 * @property string $currancy_type
 * @property int $rate
 * @property int $total_amount
 * @property string $total_amount_in_word
 * @property string $timestamp
 */
class ErpEmployeeClaims extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'erp_employee_claims';
    }

    /**
     * {@inheritdoc}
     */
     
    public function rules()
    {
        return [
           
            [['employee', 'total_amount', 'total_amount_in_word','created_by'], 'required'],
            [['total_amount'], 'integer'],
           
          
            [[ 'total_amount_in_word'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'request_id',
            'person' => 'Employee',
            'purpose' => 'Claim For',
            'title' => 'Title of Mission/Training',
            'day' => 'Days in Mission/training',
            'currancy_type' => 'Currancy Type',
            'rate' => 'Rate',
            'total_amount' => 'Total Amount',
            'total_amount_in_word' => 'Total Amount In Word',
        ];
    }
}
