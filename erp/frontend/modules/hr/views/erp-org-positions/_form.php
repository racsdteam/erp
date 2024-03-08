
<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpPositionStatus;
use common\models\ErpOrgLevels;
use common\models\ErpOrgUnits;
use common\models\ErpOrgJobs;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<style>


</style>


 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Add Position</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
               if (Yii::$app->session->hasFlash('success')){
    
    echo $alert(Yii::$app->session->getFlash('success'),'success');  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo $alert(Yii::$app->session->getFlash('error'),'error');     
}

               
               $lvs=ErpOrgLevels::find()->all();
             $orgUnits=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $orgUnits[strtoupper($l->level_name."s")]=$data;
}         
              
               ?>

         
         


<?php $form = ActiveForm::begin(); ?>


<div class="row">

<div class="col-sm-8">
    
<?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>    
</div>

<div class="col-sm-4">


<?= $form->field($model, 'position_code')->textInput(['maxlength' => true]) ?>  

</div>

</div>

<div class="row">

<div class="col-sm-6">

<?= $form->field($model, 'report_to')->widget(Select2::classname(), [
   'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
   'options' => ['placeholder' => 'Select position reporting to ...','class'=>'m-select2'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label("Reporting To")?>


</div>
<div class="col-sm-6">

<?= $form->field($model, 'org_unit')->widget(Select2::classname(), [
   'data' =>$orgUnits,
   'options' => ['placeholder' => 'Select Org Unit ...','class'=>'m-select2'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label("Org Unit")?>

 </div>


</div>


<div class="row">
    
 <div class="col-sm-12"> 
<?= $form->field($model, 'job_role')->widget(Select2::classname(), [
   'data' => [ ArrayHelper::map(ErpOrgJobs::find()->all(), 'code', 'name') ],
   'options' => ['placeholder' => 'Select Position Job Role ...','class'=>'m-select2'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label(false)?>
</div> 

</div>

  <?= $form->field($model, 'active_status')->checkbox(array('label'=>''))
			->label('Active'); ?> 
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
         


<?php


$script = <<< JS

(function ($) {
    
$(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
  $('.spinner .btn:first-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
  });
  $('.spinner .btn:last-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
  });
})(jQuery);


JS;

$this->registerJs($script);
           
?>
           
           
           
        
           