<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\PayStructures;
use frontend\modules\hr\models\PayStructureItems;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\Employees;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureItems */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-pencil-alt"></i> Pay Template Item Override</h3>
                       </div>
               
           <div class="card-body">
               
        <?php 
       
        extract($params);
       
        ?>       
               <?php $form = ActiveForm::begin(['id'=>'item-form']); ?>
    
        <?= Html::dropDownList('pay_item', $tmpl_line->payItem->id, [ArrayHelper::map(PayItems::find()->all(), 'id','name')], ['id'=>'pay-item-id','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>
      
      <?= $form->field($model, 'pay_id')->hiddenInput(['value'=>$emp_pay])->label(false); ?>
     <?= $form->field($model, 'tmpl')->hiddenInput(['value'=> $tmpl])->label(false); ?>
     <?= $form->field($model, 'tmpl_line')->hiddenInput(['value'=> $tmpl_line->id])->label(false); ?>
     <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'class'=>['form-control input-amount'],'placeholder'=>'amount..'])?>
     <?php 
     if(!$model->isNewRecord){
         
      echo  Html::checkbox('disable_override', false, ['label' => 'Calculate Amount as defined at Pay Template level']) ;    
     }
     
     ?>
    
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord? 'btn btn-success':'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
      
     

               </div>
               </div>
               
  
      
      <?php

$script = <<< JS

$(document).ready(function(){



     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
      $('.input-amount').number( true);
  


});


JS;
$this->registerJs($script);


?>

