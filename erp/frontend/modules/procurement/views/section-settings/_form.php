<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use softark\duallistbox\DualListbox;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\EnvelopeSetting;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\SectionSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-settings-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Section Setting Form</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
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