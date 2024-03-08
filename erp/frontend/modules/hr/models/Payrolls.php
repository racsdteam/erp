<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "payrolls".
 *
 * @property int $id
 * @property string $name
 * @property int $pay_group
 * @property string $pay_month
 * @property string $pay_year
 * @property string $status
 * @property int $user
 * @property string $timestamp
 */
class Payrolls extends \yii\db\ActiveRecord
{
   const PAY_STATUS_DRAFT='draft';
   const PAY_STATUS_COMPL='completed';
   const PAY_STATUS_APPROVED='approved';
   const PAY_STATUS_SUBM='processing';
   
   const VIEW_TYPE_PDF='pdf';
   const VIEW_TYPE_HTML='html';
   public  $views=[];
   
    public function init(){
         
         parent::init();
         $this->setViews();
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payrolls';
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
            [['name','pay_group','run_type', 'pay_period_month', 'pay_period_year','pay_period_start','pay_period_end', 'user'], 'required'],
            [[ 'user'], 'integer'],
            [['status'], 'string'],
            [['timestamp','pay_period_start','pay_period_end'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['run_type','suppl_type','pay_group'], 'string', 'max' => 11],
            [['pay_period_month', 'pay_period_year'], 'string', 'max' => 255],
           [['suppl_type'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->run_type =='SUP';
        }, 
        'whenClient' => 'isSupplOptionChecked' //-----------valiadtion function on client side
    
    ]

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
            'pay_group' => 'Pay Group',
            'pay_period_month' => 'Payroll Period Month',
            'pay_period_year' => 'Payroll Period Year',
            'pay_period_start'=>'Payroll Period Start',
            'pay_period_end'=>'Payroll Period End',
            'status' => 'Status',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
 
  
   public function getPayGroup0()
{
    return $this->hasOne(PayGroups::className(), ['code' => 'pay_group']);
}

  public function getPayRunType()
{
    return $this->hasOne(PayrollRunTypes::className(), ['code' => 'run_type']);
}

public  function getSupplType(){

     return $this->hasOne(PayItems::className(), ['code' => 'suppl_type']) ;

}



function getPaySlips(){

return $this->hasMany(Payslips::className(), ['pay_period' => 'id'])->orderBy(['base_pay'=>SORT_DESC]);


}


function getItemWiseTot($item){
    
    $query=new \yii\db\Query(); 
        $tot=$query->select(['SUM(amount) as tot']) 
          ->from('payrolldata')
          ->where(['payroll'=>$this->id,'item'=>$item])
          ->all(\Yii::$app->db4);  
         return  $tot[0]['tot']; 
    
}

function getCategWiseTot($categ){
 
    $items = ArrayHelper::getColumn($this->empGroup->payTemplate->lineItems, 'item');
      $categItems=PayItems::find()->alias('tbl_items')->select('tbl_items.id,cat.code as category')
      ->innerJoin('pay_item_categories as cat', 'cat.id = tbl_items.edCategory')
      ->andWhere(['in', 'tbl_items.id', $items])
      ->andWhere(['cat.code'=>$categ])
      ->asArray()->all();
     $ids=ArrayHelper::getColumn($categItems,'id');
  
   $query=new \yii\db\Query(); 
        $tot=$query->select(['SUM(amount) as tot']) 
          ->from('payrolldata')
          ->where(['payroll'=>$this->id])
          ->andWhere(['in', 'item', $ids])
          ->all(\Yii::$app->db4);  
         return  $tot[0]['tot']; 
        
    
}

static function getCompletedOnMonth($year,$momth){
 
    $payrolls = self::find()->where(["pay_period_month"=>$momth,"pay_period_year"=>$year,"status"=>"completed"])->all();
         return  $payrolls; 
        
    
}

static function getByStatus($status){
 
    $payrolls = self::find()->where(["status"=>$status])->all();
         return  $payrolls; 
        
    
}

function  totalDays(){
    
 return intVal(date('t', mktime(0, 0, 0, $this->pay_period_month, 1, $this->pay_period_year))); 
 
 
}

public function payrollData(){
    $payslips = Payslips::find()->with('payslipItems')->where(['pay_period'=>$this->id])->orderBy(['base_pay'=>SORT_DESC])->all();
    $res=[];
    $rows=[];
   
    /*$ids=empty($payslips)? ArrayHelper::getColumn($this->payGroup0->payTemplate->lineItems, 'item'): ArrayHelper::getColumn($payslips[0]->payslipItems, 'item'); */
    $ids=ArrayHelper::getColumn($this->payGroup0->payTemplate->lineItems, 'item');
    $items=PayItems::findAll($ids);
    
    foreach($payslips as $slip){
     
    $row=[];
    $values=[];
    $costs=[];
    
    $fixed['id']=$slip->id;
    $fixed['employee_no']=$slip->employee0->employmentDetails->employee_no;
    $fixed['full_name']=$slip->employee0->first_name.' '.$slip->employee0->last_name;
    $fixed['position']=$slip->employee0->employmentDetails->positionDetails->position;
  
      foreach($slip->payslipItems as $val){
        
        $costs[$val->item]=$val;
    }   
   
   foreach( $items as $item){
       
       if(!isset($costs[$item->id])){
       $values[$item->code]=0; 
       continue;    
           
       }
        
     
     $values[$item->code]=$costs[$item->id]->amount;   
   
     }
      
    $row=ArrayHelper::merge($fixed,$values); 
    $rows[]=$row; 
    
 }
 return $rows;
}
public function payrollFields(){
    
    
}
protected function setViews(){
  $this->views = [
            'pdf' => '/payrolls/pdf',
            'html' => '/payrolls/view',
           
        ];   
   
}




public function isEditable(){
    
    return $this->status==self::PAY_STATUS_DRAFT;
}

public function isRegular(){
    
    return $this->run_type=='REG'; 
    
}

public function isSuppl(){
    
    return $this->run_type=='SUP'; 
    
}

}
