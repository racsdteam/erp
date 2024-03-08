<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\Countries;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-address-form">
      <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'country',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-globe-europe"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(Countries::find()->all(), 'country_code', 'country_name')], 
               ['prompt'=>'Select  country ','id'=>'country-id','class'=>['form-control m-select country-class ']]) ?>   

   <?=$form->field($model, 'province')->widget(DepDrop::classname(), [
    'options'=>['id'=>'province-id'],
    'data'=>[$model->province => $model->province ],
    'pluginOptions'=>[
        'depends'=>['country-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select province...',
        'url'=>Url::to(['country/provinces'])
    ]
])?>    

            <?=$form->field($model, 'district')->widget(DepDrop::classname(), [
    'options'=>['id'=>'district-id'],
    'data'=>[$model->district => $model->district ],
    'pluginOptions'=>[
        'depends'=>['province-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['province/districts'])
    ]
])?>   
         <?=$form->field($model, 'sector')->widget(DepDrop::classname(), [
            
    'options'=>['id'=>'sector-id'],
     'data'=>[$model->sector => $model->sector ],
    'pluginOptions'=>[
        'depends'=>['district-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['district/sectors'])
    ]
])?>    
    <?= $form->field($model, 'cell')->textInput() ?>
    <?= $form->field($model, 'village')->textInput() ?>
    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address_line1')->textInput() ?>
    <?= $form->field($model, 'address_line2')->textInput() ?>
     <?= $form->field($model, 'address_line_3')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
