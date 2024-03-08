<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "payroll_approval_reports".
 *
 * @property int $id
 * @property string $rpt_desc
 * @property int $rpt_type
 * @property string $period_month
 * @property string $period_year
 * @property string $pay_group
 * @property string $status
 * @property int $user
 * @property string $timestamp
 */
class PayrollRunReports extends \yii\db\ActiveRecord
{
     
   public  $pay_group0;
   public  $modelParams;
   
   public  $views=[];
   public  $settings=[];
   public  $dbData=[];
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_run_reports';
    }
    public function init(){
         
         parent::init();
          $this->modelParams=new PayrollRunReportParams();
          $this->setViews();
        
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
            [['rpt_desc', 'rpt_type','params', 'user'], 'required'],
            [['rpt_desc','rpt_type', 'status'], 'string'],
            [[ 'user'], 'integer'],
            [['params'],'string'],
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
            'rpt_desc' => 'Description',
            'rpt_type' => 'Report Type',
            'status' => 'Status',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }

   public function getAttachments()
{
    return $this->hasMany(PayrollRunReportAttachments::className(), ['report' => 'id'])->orderBy(['id'=>SORT_ASC]);
}
    /**
     * {@inheritdoc}
     * @return PayrollRunReportsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayrollRunReportsQuery(get_called_class());
    }
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportModel()
    {
        return $this->hasOne(ReportTemplates::className(), ['code' => 'rpt_type']);
    }
    
    
     public function getBase()
    {
        return $this->hasOne(ReportTemplates::className(), ['code' => 'rpt_type']);
    }
    
    
     public function beforeValidate()
{
    if (parent::beforeValidate()) {
    
         if(empty($this->user))
         $this->user=Yii::$app->user->identity->user_id; 
         
        
         
         
        return true;
    }
    return false;
}

/*public function beforeSave($insert) {
     
  if(!empty($this->pay_group0))
   $this->pay_group=json_encode($this->pay_group0,JSON_PRETTY_PRINT);
   return parent::beforeSave($insert);
}*/

 public function afterFind(){

    parent::afterFind();
    if(!empty($this->params))
    $this->modelParams->setAttributes(json_decode($this->params,true));
  
 }
 

public function generate(){
    
 $this->settings=$this->setup();

 $this->dbData= $this->getDbData();
 return $this;

}

public function setup(){
    
  $paramStr='';
  $paramArr=[];
 
  $baseParams=$this->getBaseParams();
  $params=$this->getParams();
  
 
  foreach($baseParams as $param){
   $paramStr.=sprintf(" :%s",$param);
   if(empty(ArrayHelper::getValue($params, $param))){
      $paramArr['params'][$param]="";
      continue;
   }
  $paramArr['params'][$param]=is_array($params[$param]) ? implode(",",$params[$param]) : $params[$param]; 
   
  
    
}

 
 $paramStr=str_replace(" ", ",", trim($paramStr));
 $paramArr['paramStr']=$paramStr;
 $paramArr['type']= $this->rpt_type;
 return $paramArr;
 

}


public function render(){


$content=Yii::$app->controller->renderPartial($this->base->getViewByReport($this),[
            'model' => $this,
            'rows'=>$this->dbData,
            
            
        ]);
return $content;    
    
}

public function getDbData(){
 
  $query=\Yii::$app->db4->createCommand("CALL ".$this->base->dataset."(".$this->settings['paramStr'].")");
  foreach($this->settings['params'] as $param=>$value){
  $query->bindValue(":{$param}" , $value);  

  }
  return $query->queryAll();
 
    
    
}


public function reportData(){
    
    return $this->dbData;
}
 
 public function getParams(){
     
 return  Json::decode($this->params,true);    
     
 }
 
  public function getBaseParams(){
     
 return  Json::decode($this->base->params,true);    
     
 }


public static function findByPeriod($year,$month,$status=null){
 $query=self::find() ;
 $cond=array();
 if(!empty($year))
 $cond['period_year']=$year;
 
  if(!empty($month))
 $cond['period_month']=$month;
 
  if(!empty($status))
 $cond['status']=$status;
 
 return  empty($cond)?$query->all() : $query->where($cond)->all();
    
}

public static function findByStatus($status,$year=null,$month=null){
 $query=self::find() ;
 $cond=array();
 if(!empty($year))
 $cond['period_year']=$year;
 
  if(!empty($month))
 $cond['period_month']=$month;
 
  if(!empty($status))
 $cond['status']=$status;
 
 return  empty($cond)?$query->all() : $query->where($cond)->all();
    
}
protected function setViews(){
  $this->views = [
            'pdf' => '/payroll-run-reports/pdf',
            'html' => '/payroll-run-reports/view',
           
        ];   
   
}
protected function isJson($str) {
   
 /* if(is_string($str))
    return false;*/
   
    $json = json_decode($str,true);
    return $json && $str != $json;
   
}

 public function reference(){
 
 switch($this->rpt_type) {
     case 'BL':
         $payType=ArrayHelper::getValue($this->getParams(), 'pay_type');
         if(!empty($payType) && $payType=='SAL')
         return 'Salary';
         if(!empty($payType) && $payType=='ALW')
         return 'Allowance';
         if(!empty($payType) && $payType=='LPSM')
         return 'LumpSum';
         if(!empty($payType) && $payType=='BON')
         return 'Bonus';
         break;
       
   default:
       return "";
 }
    
    
  }

    

}
