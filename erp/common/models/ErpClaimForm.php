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
class ErpClaimForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
      public $position;
      public $action;
      public $recipients;
      public $recipients_names;
      public $remark;
    public static function tableName()
    {
        return 'erp_claim_form';
    }

    /**
     * {@inheritdoc}
     */
     
    public function rules()
    {
        return [
           
            [['employee','purpose', 'title', 'day','total_amount','total_amount_in_words','currancy_type', 'rate','created_by'], 'required'],
            [['employee','tr_id','is_new'], 'integer'],
            [['currancy_type'], 'string'],
            [['recipients','position'],'safe'],
            [['purpose', 'title','total_amount_in_words'], 'string', 'max' => 1000],
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
            'total_amount_in_words' => 'Total Amount In Words',
        ];
    }
}
