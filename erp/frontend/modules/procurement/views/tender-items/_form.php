<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tenderItems-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Lot Item And Service</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?=  $form->field($model, 'type')->dropDownList(["service"=>"service","good"=>"good","service"=>"service",],['prompt'=>'Select ','class'=>['form-control select2'],])->label("Select Type");?>
    

    <?= $form->field($model, 'unite') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'description')->widget(TinyMce::class, [
    'options' => ['rows' => 18],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>