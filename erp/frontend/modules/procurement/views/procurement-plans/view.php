<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider; 
use yii\grid\GridView;
use frontend\modules\procurement\models\ProcurementCategories;
use frontend\modules\procurement\models\ProcurementActivities;
use frontend\modules\procurement\models\ProcurementActivitiesSearch;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlans */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php

           
         $attributes = [
   
    [
        'columns' => [
            [
                'attribute'=>'name', 
                'label'=>'Procurement Plan Name',
                'value'=>$model->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
             [
                'attribute'=>'fiscal_year', 
                'label'=>'Fiscal Year',
                'value'=>$model->fiscal_year,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],
    ],
    [
        
     'columns' => [
            [
                'attribute'=>'status', 
                'label'=>'Status',
                 'format' => 'html',
                 'value'=>'<b><small  class="'.get_class($model)::badgeStyle($model->status).'">'.$model->status.'</small></b>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'created_at', 
                 'label'=>'Date Created',
                'value'=>$model->created_at,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
            
           
        ],   
        
        
        
        ],
    
    
  
    [
       'columns'=>[
           
            [
                'attribute'=>'created_by', 
                'label'=>'Created By',
                'value'=>$model->user0->first_name.''.$model->user0->last_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
          
           [
                'attribute'=>'updated_at', 
                 'label'=>'Date Updated',
                'value'=>$model->updated_at,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
           
           
           ] 
        
        
        ] 
 
];

?>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
   <div class="card-body">
       
   <?php
   
// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' =>true,
    'striped' => true,
    'condensed' =>true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'right',
    'vAlign'=>'middle',
   
   
   
]);

   
   ?>
    
 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-boxes"></i> Procurement Plan  Activities</h3>
                       </div>
               
           <div class="card-body">
               
               
              <?php 
 
  $items=[];
  foreach(ProcurementCategories::find()->orderBy(['display_order'=>SORT_ASC])->all() as $category){
  
     $searchModel = new ProcurementActivitiesSearch();
     $dataProvider = $searchModel->search([$searchModel->formName()=>['procurement_category'=>$category->code]]);
   
   
   $item['label']='<i class="fas fa-layer-group"></i> '.$category->name ;
   $item['content']=Yii::$app->controller->renderPartial('activity-list', [
          'dataProvider' => $dataProvider,
          'plan'=>$model,
          'category'=>$category
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
</div>
</div>

<?php
$script = <<< JS

$(document).ready(function()
                            {
         $('.action-launch').on('click',function (e) {
         
 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This auction will be launched !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, launch it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
    if(data.flag==true){
        
        Swal.fire(
  'Success!',
  data.msg,
  'success'
)
    }else{
        
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: data.msg,

})  
    }
});
  }
})
    
    return false;

});   


  
             
var oTable= $('.tbl').DataTable({
              
              'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }]
          });          
          
   


                                
                                
                                
                            });
                          


JS;
$this->registerJs($script);

?>

