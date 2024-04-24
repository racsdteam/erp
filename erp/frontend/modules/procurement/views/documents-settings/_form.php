<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use softark\duallistbox\DualListbox;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\SectionSettings;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\SectionSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-settings-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Document Setting Form</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?=  $form->field($model, 'section_code')->dropDownList(ArrayHelper::map(SectionSettings::find()->all(), 'code', 'name'),['prompt'=>'Select Section','class'=>['form-control select2'],])->label("Select Section");?>
    <?=  $form->field($model, 'required_status')->dropDownList([false=>"No",true=>"Yes"],['prompt'=>'Select ','class'=>['form-control select2'],])->label("is the Document required?");?>
    <?=  $form->field($model, 'more_docs_status')->dropDownList([false=>"No",true=>"Yes"],['prompt'=>'Select ','class'=>['form-control select2'],])->label("Can Bidders Send More Than one Documents?");?>
   <?= $form->field($model, 'min_docs')->textInput(['maxlength' => true,'type' => 'number']) ?>
    <?= $form->field($model, 'max_docs')->textInput(['maxlength' => true,'type' => 'number']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>