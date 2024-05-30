<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use softark\duallistbox\DualListbox;
use frontend\modules\procurement\models\DocumentsSettings;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStaffs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-staffs-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Lot Document</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'description') ?>
    <?php
    $options = [
        'multiple' => true,
        'size' => 10,
    ];
    
    echo $form->field($model, 'documents')->widget(DualListbox::class,[
        'items' => ArrayHelper::map(DocumentsSettings::find()->all(), 'code', 'name'),
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