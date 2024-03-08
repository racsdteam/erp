<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payItems".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $report_name
 * @property string $category
 * @property string $pay_type
 * @property string $statutory_type
 * @property int $subj_to_paye
 * @property int $pensionable
 * @property int $visible_on_payslip
 * @property int $active
 *
 * @property StatutoryDeductions $statutoryType
 * @property PayItemCategories $category0
 */
class PayItems extends \yii\db\ActiveRecord
{
    const PAY_TYPE_REG='REG';
    const PAY_TYPE_SUP='SUP';
   
   //default active set to 1 
   public $active=1;
   
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payItems';
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
            [['name', 'code', 'report_name', 'category'], 'required'],
            [['pay_type','proc_type'], 'string'],
            ['code', 'unique','message'=>'{attribute} must be unique.'],
            [['subj_to_paye','pre_tax','rama_payable','mmi_payable', 'pensionable','cbhi_payable','inkunga_payable', 'visible_on_payslip', 'active'], 'integer'],
            [['name', 'report_name'], 'string', 'max' => 255],
            [['code', 'category', 'statutory_type'], 'string', 'max' => 11],
            [['statutory_type'], 'exist', 'skipOnError' => true, 'targetClass' => StatutoryDeductions::className(), 'targetAttribute' => ['statutory_type' => 'abbr']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => PayItemCategories::className(), 'targetAttribute' => ['category' => 'code']],
           ['pay_type', 'required', 'when' => function ($model) {
    return  in_array($model->category,array(PayItemCategories::CAT_E,PayItemCategories::CAT_D,PayItemCategories::CAT_SD,PayItemCategories::CAT_SC)) ;
}, 'whenClient' => "function (attribute, value) {
    return $('#pay-categ').val() == 'E' || $('#pay-categ').val() == 'D' || $('#pay-categ').val() == 'SD' || $('#pay-categ').val() == 'SC';
}"],

      ['statutory_type', 'required', 'when' => function ($model) {
    return in_array($model->category,array(PayItemCategories::CAT_SD,PayItemCategories::CAT_SC)) ;
}, 'whenClient' => "function (attribute, value) {
    return $('#pay-categ').val() == 'SD' || $('#pay-categ').val() == 'SC';
}"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'report_name' => 'Report Name',
            'category' => 'Category',
            'pay_type' => 'Pay Type',
            'statutory_type' => 'Statutory Type',
            'subj_to_paye' => 'subj_to_paye',
            'pensionable' => 'Pensionable',
            'visible_on_payslip' => 'Visible On Payslip',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatutoryType()
    {
        return $this->hasOne(StatutoryDeductions::className(), ['abbr' => 'statutory_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(PayItemCategories::className(), ['code' => 'category']);
    }

    /**
     * {@inheritdoc}
     * @return PayItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayItemsQuery(get_called_class());
    }
    public function isRegular(){
       
        return $this->pay_type==self::PAY_TYPE_REG;
    }
    
     
     public function isSupplemental(){
       
        return $this->pay_type==self::PAY_TYPE_SUP;
    }
    
     public function isFixed(){
       
        return $this->proc_type=='fixed';
    }
    
      public function isVariable(){
       
        return $this->proc_type=='variable';
    }
    
    
    public function isBase(){
       
        return $this->category==PayItemCategories::CAT_B;
    }
    
     public function isEarning(){
       
        return $this->category==PayItemCategories::CAT_E;
    }
    
     public function isDeduction(){
       
        return $this->category==PayItemCategories::CAT_D;
    }
    
    public function isStatutoryDeduction(){
       
        return $this->category==PayItemCategories::CAT_SD;
    }
    
    public function isStatutoryContribution(){
       
        return $this->category==PayItemCategories::CAT_SC;
    }
    
    
    public static  function findAllByCateg($options=array()){
  
    $query= self::find()->alias('p_it')
            ->innerJoinWith('category0');
    if(!empty($options)){
    $query->where($options);    
      }
    return  $query->all()  ;  
    }
 public static  function findAllByCode($code){
    
    $query= self::find();
    is_array($code)? $query->where(['in', 'code',$code]):  $query->where(['code'=>$code]);
    return  is_array($code) ? $query->all() : $query->One() ;  
    }
}
