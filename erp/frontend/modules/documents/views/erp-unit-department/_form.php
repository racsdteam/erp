

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ErpDocumentType;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use common\models\ErpOrganizationUnit;

use kartik\select2\Select2;
//use frontend\assets\DatePickerAsset;
//DatePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\GuestRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

 

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Add New Department </h3>
 </div>
 <div class="box-body">




<div class="erp-organization-unit-form">

<?php $form = ActiveForm::begin(); ?>
 
<?= $form->field($model, 'unit')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrganizationUnit::find()->all(), 'id', 'unit_name') ],
    'options' => ['placeholder' => 'Select unit ...'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
   
  
   
])->label(false)?>
<?= $form->field($model, 'depart_name')->textInput(['maxlength' => true]) ?>

    
<?php //$form->field($model, 'org')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>






 </div>

 </div>
 
 
 </div>

</div>

          <?php
            
$script = <<< JS



JS;
$this->registerJs($script);
?>


