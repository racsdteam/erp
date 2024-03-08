<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\PayrollRunTypes;
use frontend\modules\hr\models\PayrollsSearch;
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\PayrollApprovalReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payrolls';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default">
        
                    
               
           <div class="card-body">
             
  <?php 
  $payRunTypes=PayrollRunTypes::find()->orderBy([
  
  'display_order'=>SORT_ASC
])->all();
  $items=[];
  foreach($payRunTypes as $type){
  
     $searchModel = new PayrollsSearch();
     $dataProvider = $searchModel->search([$searchModel->formName()=>['run_type'=>$type->code]]);
   
   
   $item['label']='<i class="fas fa-coins"></i> '.$type->name ;
   $item['content']=Yii::$app->controller->renderPartial('payrolls-list', [
          'dataProvider' => $dataProvider,
          'run_type'=>$type->code
        ]);
        
  
   $items[]=$item;
      
  }
  
  if(!empty($items))
  $items[0]['active']=true;
  
  echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'pluginOptions'=>['enableCache'=>false,'maxTitleLength'=>9],
    'encodeLabels'=>false
]);
  ?>             
  
  
</div>
</div>
</div>
</div>

