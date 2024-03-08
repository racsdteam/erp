
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpPositionStatus;
use common\models\ErpOrgLevels;
use common\models\ErpOrgUnits;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<style>

.p{float:left;width:80%;}
.s{float:left;padding-top:4px;margin-left:10px;


}

</style>



<div class="well row clearfix">

<div class="col-xs-12 ol-sm-12 col-md-8 col-lg-8  col-md-offset-2">

 <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tag"></i> Add New Position</h3>
                </div>
           <div class="box-body">
           <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('failure')  ?>
               </div>
 
 
         <?php endif; ?>  


<?php $form = ActiveForm::begin(); ?>


<div class="row">

<div class="col-sm-6">

<?php
                          
                          $lvs=ErpOrgLevels::find()->all();
                          $options=array();
                          
                          
                          foreach($lvs as $l){
                              $data=array();
                              $q1="SELECT * from erp_org_units as s  
                              where unit_level={$l->id} ";
                              $com1 = Yii::$app->db->createCommand($q1);
                               $rows = $com1->queryAll();
                          
                               foreach($rows as $row){
                                   
                                 
                                  $data[$row['id']]=$row['unit_name'];
                                   
                                  
                               }
                               
                              $options[strtoupper($l->level_name."s")]=$data;
                              
                             
                             
                             // $sbs=ErpOrgSubdivisions::find()->where(['subdiv_level'=>$l->id])->all();
                             
                          
                          }

                          ?>
                          
<?= $form->field($model, 'unit')->widget(Select2::classname(), [
   'data' => $options,
   'options' => ['placeholder' => 'Select Unit ...'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label(false)?>

</div>

<div class="col-sm-6">

<?= $form->field($model, 'report_to')->widget(Select2::classname(), [
   'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
   'options' => ['placeholder' => 'Select position reporting to ...'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label(false)?>


</div>



<div class="col-sm-8">   

<?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

</div>

<div class="col-sm-4">
    
  <div class="input-group spinner">

    <input type="text" name="count" class="form-control" id="p-count" value="1" >
    <div class="input-group-btn-vertical">
      <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
      <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
    </div>
  </div>  
    
</div>


<div class="col-sm-6"> 
<?= $form->field($model, 'status')->widget(Select2::classname(), [
   'data' => [ ArrayHelper::map(ErpPositionStatus::find()->all(), 'status', 'status') ],
   'options' => ['placeholder' => 'Select position status ...'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label(false)?>
</div>

<div class="col-sm-6">

<?= $form->field($model, 'level')->widget(Select2::classname(), [
   'data' => ["manager"=>"manager","director"=>"director","officer"=>"officer","pa"=>"pa" ],
   'options' => ['placeholder' => 'Select position level ...'
  ],
   'pluginOptions' => [
       'allowClear' => true,
      
      
   ],//'addon'=>$addon,
   'size' => Select2::MEDIUM,
 
  
])->label(false)?>

 </div>









</div>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

             </div><!-- end row wraper  -->
          
          </div>


<?php


$script = <<< JS

(function ($) {
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
           
           
           
        
           