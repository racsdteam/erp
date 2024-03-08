<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\ EmpCategories;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Add New Personnel Type</h3>
                       </div>
               
           <div class="card-body">
               

    <?php $form = ActiveForm::begin([
                               
                                 'id'=>'emp-type-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',
                              
                               ]); ?>
    <div class="row">
        
        <div class="col-sm-12">
            
           <?=
                    $form->field($model, 'category')
                        ->radioList(
                            \yii\helpers\ArrayHelper::map(EmpCategories::find()->all(), 'code', 'name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label(false);
                    ?>   
            
        </div>
        
    </div>
    <div class="row">
       
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'report_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

   <?= $form->field($model, 'description')->textArea(['rows' => '4']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>