<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use frontend\modules\procurement\models\DocumentsSettings;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderDocuments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-documents-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Lot Document</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?=  $form->field($model, 'document_code')->dropDownList(ArrayHelper::map(DocumentsSettings::find()->where(["section_code"=>$section_code])->all(),'code','name'),['prompt'=>'Select ','class'=>['form-control select2'],])->label("Select Type");?>

    <?= $form->field($model, 'number') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
</div>
</div>
