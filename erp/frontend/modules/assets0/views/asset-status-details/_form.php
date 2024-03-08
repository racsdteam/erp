<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use frontend\modules\assets0\models\AssetStatuses;
use frontend\modules\assets0\models\Assets;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpStatusDetails */
/* @var $form yii\widgets\ActiveForm */
?>



<style>
    .invalid-feedback{display:block;}
    
</style>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-bell"></i> Asset Change Status</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   } 
            
   $statuses=ArrayHelper::map(AssetStatuses::find()->where(['not in','code',['DSPL']])->all(), 'code','name');      
               ?>

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
   <?php 
   
   if(!empty($asset) && empty($model->asset))
       $model->asset=$asset;
   if(!empty($model->asset))
   echo  $form->field($model, 'asset')->hiddenInput(['value'=>$model->asset])->label(false); 
   ?>
   

   <?= $form->field($model,  'asset')->dropDownList([ArrayHelper::map(Assets::find()->all(), 'id', function($model){
       
       return $model->name.'-'.$model->serialNo;
   })], ['prompt'=>'Select asset',
               'id'=>'emp-id','class'=>['form-control m-select2 '],'disabled'=>!empty($model->asset)])->label("Asset") ?>  
  <div class="row">
      
      <div class="col-sm-12 col-md-4 col-lg-6">
       
        <?= $form->field($model,  'status')->dropDownList($statuses, ['prompt'=>'Select Status',
               'id'=>'r-id','class'=>['form-control m-select2 ']])->label("Select Status") ?>    
          
      </div>
      
      <div class="col-sm-12 col-md-4 col-lg-6">
          
     <?= $form->field($model, 'status_date')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Status Date...','id'=>'status-date'])->label("Date of Status") ?>     
          
      </div>
      
      
      
      
      
      
  </div>
  
   <?= $form->field($model, 'comment')->textArea(['rows' => '4'])->label("Status Reason")?>
  


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    //format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
   
});

JS;
$this->registerJs($script);

?>



