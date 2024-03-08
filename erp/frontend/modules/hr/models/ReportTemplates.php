<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "report_templates".
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $display_name
 *
 * @property ReportColumns[] $reportColumns
 * @property ReportDatasets[] $reportDatasets
 * @property ReportTypes $type0
 */
class ReportTemplates extends \yii\db\ActiveRecord
{
     public $mparams;
     public $settings;
     public $views;
     //---------------------report instance setup-----------------------
     public $rows;
     public $view;
     public $model;
     public $approval;
     public $wf;
     
     
     const  TYPE_CODE_PAYE='PAYE';
     const  TYPE_CODE_RAMA='RAMA';
     const  TYPE_CODE_MMI='MMI';
     const  TYPE_CODE_PENSION='PENSION';
     const  TYPE_CODE_MATL='MATL';
     const  TYPE_CODE_CBHI='CBHI';
     const  TYPE_CODE_INKU='INKU';
     const  TYPE_CODE_SLOAN='SLOAN';
     const  TYPE_CODE_BL='BL';
     
     public function init(){
         
         parent::init();
         $this->settings=array();
         $this->rows=array();
         $this->setViews();
     }
     
  

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_templates';
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
            [['type', 'name','dataset','params','code'], 'required'],
            [['type','display_order'], 'integer'],
            [['description','params','code'], 'string'],
            [['name', 'display_name','dataset','view'], 'string', 'max' => 255],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => ReportTypes::className(), 'targetAttribute' => ['type' => 'id']],
            [['mparams','model'],'safe'],
        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'description' => 'Description',
             'display_name' => 'Display Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportColumns()
    {
        return $this->hasMany(ReportColumns::className(), ['report' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportDatasets()
    {
        return $this->hasMany(ReportDatasets::className(), ['report' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(ReportTypes::className(), ['id' => 'type']);
    }
       
 public function afterFind(){

    parent::afterFind();
    
    $this->mparams=json_decode($this->params,true);
  

 }
    
         public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
         if(empty($this->user))
         $this->user=Yii::$app->user->identity->user_id;
         $this->params=json_encode($this->mparams);
         return true;
    }
    return false;
}

public function setup($settings=[]){
 
  $this->model=$settings['model'];
  $this->wf=$settings['wf'];
  $this->approval=$settings['approval'];
  
  $paramStr='';
  $params=array();
  $params=json_decode($this->params);
   
  
  $this->settings['type']= $this->model->getAttribute('rpt_type');
  foreach($params as $param){
   $paramStr.=sprintf(" :%s",$param);  
   
   $this->settings['params'][$param]=$this->isJson($this->model->getAttribute($param)) ? implode(",",json_decode($this->model->getAttribute($param),true)) : $this->model->getAttribute($param);
   
   
    
  }

 $paramStr=str_replace(" ", ",", trim($paramStr));
 $this->settings['paramStr']=$paramStr;
 
 return $this;
 

 
  
}

public function loadData(){
 
 $query=\Yii::$app->db4->createCommand("CALL ".$this->dataset."(".$this->settings['paramStr'].")");
  foreach($this->settings['params'] as $param=>$value){
  $query->bindValue(":{$param}" , $value);  

  }
 $this->rows= $query->queryAll();
 return $this;


}
protected function isJson($str) {
   
 /* if(is_string($str))
    return false;*/
   
    $json = json_decode($str,true);
    return $json && $str != $json;
   
}

protected function setViews(){
  $this->views = [
            'view-paye-sal' => '/report-templates/view-paye-salary',
            'view-paye-allow' => '/report-templates/view-paye-allowance',
            'view-paye-suppl' => '/report-templates/view-paye-suppl',
            'view-rama' => '/report-templates/view-rama',
            'view-mmi' => '/report-templates/view-mmi',
            'view-pension' => '/report-templates/view-pension',
            'view-matleave' => '/report-templates/view-matleave',
            'view-cbhi' => '/report-templates/view-cbhi',
            'view-inkunga' => '/report-templates/view-inkunga',
            'view-sloan' => '/report-templates/view-sloan',
            'view-bank-list' => '/report-templates/view-bank-list',
           
        ];   
   
}

public function render(){

 $wfModel=ApprovalWorkflowInstances::findOne($this->wf);   


$content=Yii::$app->controller->renderPartial($this->getView(),[
            'model' => $this->model,
            'rows'=>$this->rows,
            'wf'=>$wfModel,
            'approval'=>$this->approval
        ]);
return $content;
}

protected function getView(){
 
 switch($this->settings['type']){
     
     case self::TYPE_CODE_PAYE :
     $basis=\yii\helpers\ArrayHelper::getValue($this->settings['params'], 'pay_basis');
     
     if(!empty($basis) && $basis=='SAL')
     {
      return $this->views['view-paye-sal'];  
      
     }else if(!empty($basis) && $basis=='ALLOW') 
       
       return $this->views['view-paye-allow'];
    
     else if(!empty($basis) && $basis=='SUP') 
       
       return $this->views['view-paye-suppl']; 
       
         break;
      case self::TYPE_CODE_RAMA :
         
         return $this->views['view-rama'];    
         break;
        case self::TYPE_CODE_MMI :
         
         return $this->views['view-mmi'];    
         break;  
         
       case self::TYPE_CODE_PENSION :
         
         return $this->views['view-pension']; 
         
         break; 
         
       case self::TYPE_CODE_MATL :
         
         return $this->views['view-matleave']; 
         
        break;
        
         case self::TYPE_CODE_CBHI :
         
         return $this->views['view-cbhi']; 
         
        break;
        
         case self::TYPE_CODE_INKU :
         
         return $this->views['view-inkunga']; 
         
        break;
        
         case self::TYPE_CODE_SLOAN :
         
         return $this->views['view-sloan']; 
         
        break;
        
        case self::TYPE_CODE_BL :
         
         return $this->views['view-bank-list']; 
         
        break;
        
      default:
      return '';
 }   
    
}

public  function getViewByReport($report){

$reportParams=Json::decode($report->params,true);

 switch($report->rpt_type){
     
     case self::TYPE_CODE_PAYE :
    
    $basis=\yii\helpers\ArrayHelper::getValue($reportParams, 'paye_basis');
     
     if(!empty($basis) && $basis=='SAL')
     {
      return $this->views['view-paye-sal'];  
      
     }else if(!empty($basis) && $basis=='ALLOW') 
       
       return $this->views['view-paye-allow'];
    
     else if(!empty($basis) && $basis=='SUP') 
       
       return $this->views['view-paye-suppl']; 
       
         break;
      case self::TYPE_CODE_RAMA :
         
         return $this->views['view-rama'];    
         break;
        case self::TYPE_CODE_MMI :
         
         return $this->views['view-mmi'];    
         break;  
         
       case self::TYPE_CODE_PENSION :
         
         return $this->views['view-pension']; 
         
         break; 
         
       case self::TYPE_CODE_MATL :
         
         return $this->views['view-matleave']; 
         
        break;
        
         case self::TYPE_CODE_CBHI :
         
         return $this->views['view-cbhi']; 
         
        break;
        
         case self::TYPE_CODE_INKU :
         
         return $this->views['view-inkunga']; 
         
        break;
        
         case self::TYPE_CODE_SLOAN :
         
         return $this->views['view-sloan']; 
         
        break;
        
        case self::TYPE_CODE_BL :
         
         return $this->views['view-bank-list']; 
         
        break;
        
      default:
      return '';
 }    
}
}
