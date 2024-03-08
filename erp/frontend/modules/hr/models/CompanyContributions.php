<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "company_contributions".
 *
 * @property int $id
 * @property string $description
 * @property string $code
 * @property int $deduction
 * @property string $earnings_basis
 * @property string $formula_base
 * @property string $amount_base
 * @property int $user
 * @property string $timestamp
 */
class CompanyContributions extends \yii\db\ActiveRecord
{
    
     const ENTRY_FIXED_AMOUNT='fixed';
     const ENTRY_FORMULA='formula';
     public $item_categ='Ec';
     public $empGroupArr;
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_contributions';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contribution', 'emp_group', 'deduction', 'earnings_basis','contribution_rate','declaration_type' , 'user'], 'required'],
      /*     ['amount_base', 'required', 'when' => function ($model) {
    return $model->earnings_basis ==self::ENTRY_FIXED_AMOUNT;
}, 'whenClient' => "function (attribute, value) {

    return ($(attribute.input).closest('tr').find('.calc-en').val() == 'fixed') 
           && ($(attribute.input).closest('tr').find('.input-amount').val()=='') ;
}"],
 ['formula', 'required', 'when' => function ($model) {
    return $model->earnings_basis ==self::ENTRY_FORMULA;
}, 'whenClient' => "function (attribute, value) {
   return $(attribute.input).closest('tr').find('.calc-en').val() == 'formula';
}"],*/      [['contribution_rate'], 'number'],
            [['emp_group','deduction', 'user'], 'integer'],
            [['earnings_basis','declaration_type' ], 'string'],
            [['timestamp','empGroupArr'], 'safe'],
            [[ 'formula_base', 'amount_base'], 'string', 'max' => 255],
           
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contribution' => 'Contribution Type',
            'code' => 'Contribution Code',
            'deduction' => 'Deduction',
            'earnings_basis' => 'Earnings Basis',
            'formula_base' => 'Formula Base',
            'amount_base' => 'Amount Base',
            'contribution_rate' => 'Contribution Rate',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
     public function getDeductionItem()
    {
        return $this->hasOne(PayItems::className(), ['id' => 'deduction']);
    }
    
     public function getContributionItem()
    {
        return $this->hasOne(PayItems::className(), ['id' => 'contribution']);
    }
    
     public function getEmpGroup()
    {
        return $this->hasOne(PayGroups::className(), ['id' => 'emp_group']);
    }
}
