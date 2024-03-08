<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\PayrollRunTypes;
use frontend\modules\hr\models\Payfrequency;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayGroups */
/* @var $form yii\widgets\ActiveForm */
?>


<style>
    
 
/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}
</style>


<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-users-cog"></i> New Payroll Group</h3>
                       </div>
               
           <div class="card-body">
               
           <?php
           
              if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
           ?>
                <?php $form = ActiveForm::begin(); ?>
                
              

           
                 <?=
                    $form->field($model, 'run_type')
                        ->radioList(
                            \yii\helpers\ArrayHelper::map(PayrollRunTypes::find()->all(), 'code', 'name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-run-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-run-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label("Payroll Run Type");
                    ?> 
              
                  <?=
                    $form->field($model, 'run_frequency')
                        ->radioList(
                            \yii\helpers\ArrayHelper::map(Payfrequency::find()->all(), 'code', 'name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-freq-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-freq-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label("Frequency of pay");
                    ?>    
               
  
   
               
                    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
               </div>
               </div>
                  </div>
                     </div>
