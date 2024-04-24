<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use softark\duallistbox\DualListbox;
use dosamigos\tinymce\TinyMce;
use frontend\modules\procurement\models\EnvelopeSetting;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderLots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-lots-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Lot Form</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'number') ?>

       <?php
    $options = [
        'multiple' => true,
        'size' => 10,
    ];
    
    echo $form->field($model, 'envelope_code')->widget(DualListbox::className(),[
        'items' => ArrayHelper::map(EnvelopeSetting::find()->all(), 'code', 'name'),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Tender Methodes',
            'nonSelectedListLabel' => 'Available Tender Methodes',
        ],
    ])->label("Select Envelope");
?>
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
</div>
