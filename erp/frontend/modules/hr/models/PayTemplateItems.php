<?php

namespace frontend\modules\hr\models;

use Yii;
use NXP\MathExecutor;
/**
 * This is the model class for table "tmpl_items".
 *
 * @property int $id
 * @property int $tmpl
 * @property int $item
 * @property string $calc_type
 * @property int $formula
 * @property string $amount
 * @property int $active
 */
class PayTemplateItems extends \yii\db\ActiveRecord
{
    
     const ENTRY_FIXED='fixed';
     const ENTRY_FORMULA='formula';
     const ENTRY_USER_ENTERED='open';
     public static $inputType=array('fixed'=>'Fixed Amount','formula'=>'Formula','open'=>'User Entered');
     public $parser;
     
     public function init()
{
    parent::init();
    $this->parser= new MathExecutor();
   
}

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_template_items';
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
           
            [['tmpl','item', 'calc_type','code','category','user'], 'required'],
            [['tmpl','item', 'visible','display_order','editable','active','user'], 'integer'],
            [['formula'], 'string'],
            [['calc_type'], 'string', 'max' => 255],
            [['amount','code','category','pay_type'], 'string', 'max' =>11],
            [['amount'], 'number'],
            [['timestamp'], 'safe'],
            
          
     
 ['formula', 'required', 'when' => function ($model) {
    return $model->calc_type ==self::ENTRY_FORMULA;
}, 'whenClient' => "function (attribute, value) {
   return $(attribute.input).closest('tr').find('.calc-en').val() == 'formula';
}"],

 ['amount', 'required', 'when' => function ($model) {
    return $model->calc_type ==self::ENTRY_FIXED;
}, 'whenClient' => "function (attribute, value) {
    var input=$(attribute.input).closest('tr').find('.calc-en');
   return input.val() == 'fixed' ;
}",'message' => 'Please enter amount'],
        ];
    }
    
   
    


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tmpl' => 'Pay Template',
            'item' => 'Item',
            'calc_type' => 'Calc Type',
            'formula' => 'Formula',
            'amount' => 'amount',
            'active' => 'Active',
        ];
    }
//---overriding find methdod for custom queries-------------------------------------------------

public static function find()
    {
        return new PayTemplateItemsQuery(get_called_class());
    }



public function getPayItem()
{
    return $this->hasOne(PayItems::className(), ['id'=>'item']);
}

public function code(){
    
 return empty($this->code) ? $this->payItem->code : $this->code;   
 }
 
public function category(){
    
 return empty($this->category)? $this->payItem->category : $this->category ;   
 } 

public function payType(){
    
 return empty($this->pay_type) ? $this->payItem->pay_type : $this->pay_type ;   
 } 



function payExclusion($pay){
 return EmpPayExclusions::find()->where(['pay_id'=>$pay,'tmpl_line'=>$this->id,'tmpl'=>$this->tmpl,'active'=>1])->one();
  
    
}

function payOverride($pay){

return EmpPayOverrides::find()->where(['pay_id'=>$pay,'tmpl'=>$this->tmpl,'tmpl_line'=>$this->id,'active'=>1])->One();
  
    
}

function payAmount($pay){

 $override=$this->payOverride($pay) ;
 
 if(!empty( $override)){
     
     return $override->amount;
 }
 return $this->amount;   
    
}

  public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
         
         if(empty($this->category))
         $this->category=$this->payItem->category;
         
        
         if(empty($this->pay_type))
         $this->pay_type=$this->payItem->pay_type;
         
         if(empty($this->code))
         $this->code=$this->payItem->code;
         
         if(empty($this->amount))
         $this->amount='0.00';
         
         if(empty($this->user))
         $this->user=Yii::$app->user->identity->user_id; 
        
        
        return true;
    }
    return false;
}

public function computeAmount(&$vars){
 
$formula=strtr($this->formula,$vars); 

    
}

}
