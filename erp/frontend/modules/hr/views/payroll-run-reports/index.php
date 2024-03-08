<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\ReportTemplates;
use frontend\modules\hr\models\PayrollRunReportsSearch;
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\PayrollRunReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Run Reports';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default">
        
                    
               
           <div class="card-body">
             
  <?php 
  $rptTypes=ReportTemplates::find()->orderBy([
  
  'display_order'=>SORT_ASC
])->all();
  $items=[];
  foreach($rptTypes as $type){
  
     $searchModel = new PayrollRunReportsSearch();
     $dataProvider = $searchModel->search([$searchModel->formName()=>['rpt_type'=>$type->code]]);
   
   
   $item['label']='<i class="fas fa-chart-pie"></i> '.$type->name ;
   $item['content']=Yii::$app->controller->renderPartial('report-list', [
          'dataProvider' => $dataProvider,
          'rptType'=>$type->code
        ]);
        
  
   $items[]=$item;
      
  }
  
  if(!empty($items))
  $items[0]['active']=true;
  
  echo TabsX::widget([
    'items'=>$items,
      'enableStickyTabs' => true,
    'position'=>TabsX::POS_ABOVE,
    'pluginOptions'=>['enableCache'=>false],
    'encodeLabels'=>false,
    
]);
  ?>             
  
  
</div>
</div>
</div>
</div>

