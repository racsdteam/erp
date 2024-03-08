<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategories */
/* @var $form yii\widgets\ActiveForm */
use common\models\Categories;

//--------------------all categories------------------------------------------------
$categories=ArrayHelper::map(Categories::find()->all(), 'id', 'name') ;

?>

<div class="sub-categories-form">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, "category")
        ->dropDownList($categories,['prompt'=>'Select Cat...','class'=>['form-control Select2']])?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>