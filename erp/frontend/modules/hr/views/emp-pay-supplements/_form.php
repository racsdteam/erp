<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\Employees;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .custom-checkbox{margin-right:15px;}
    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-money-bill-alt"></i> Supplemental Pay</h3>
                       </div>
               
           <div class="card-body">
      
        
               
    <?php 
    
     if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
    
      $employeeList=ArrayHelper::map(Employees::find()->all(), 'id',function($model){
           return $model->first_name.' '.$model->last_name;  
             
         });
        
    ?>
    
    <?php $form = ActiveForm::begin(); ?>
    
   
    <?=$form->field($model, 'employee')->hiddenInput(['value'=>$model->employee])->label(false);?>
   
     <?= $form->field($model, 'item')->dropDownList(ArrayHelper::map(PayItems::find()->suppl()->all(), 'id', 'name'), 
               ['prompt'=>'Select  Supplement Type','id'=>'suppl-id','class'=>['form-control form-control-sm m-select2 ']])->label("Supplement Type") ?>  

   <?= $form->field($model,'pay_group')->dropDownList(ArrayHelper::map(PayGroups::find()->suppl()->all(), 'code', 'name'), 
                  ['prompt'=>'Select  Supplemental Pay Group','id'=>'group-id','class'=>['form-control form-control-sm m-select2 ']])->label("Pay Group") ?> 
   <?= $form->field($model, 'amount')->textInput(['id'=>'input-ampunt']) ?>  
      
    
       
         

   <?php $model->active=true; ?>      
   <?= $form->field($model, 'active')->checkbox(array('label'=>''))
			->label('Active'); ?>      
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord? 'btn btn-primary':'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php

$script = <<< JS

 $(document).ready(function(){

 //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $('#input-ampunt').number( true);

});

JS;
$this->registerJs($script);

?>

