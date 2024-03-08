<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PcTarget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTargetMillstone */
/* @var $form yii\widgets\ActiveForm */


$person_targets=ArrayHelper::map(PcTarget::find()->where(["pa_id"=>$id])->All(), 'id','output');
$quarters=["Q1"=> "Q1","Q2"=> "Q2","Q3"=> "Q3","Q4"=> "Q4",]
?>

<div class="pc-target-millstone-form">

    <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                 'method' => 'post',
                               ]); ?>

    <?= $form->field($model, 'target_id')->dropDownList($person_targets,['prompt'=>'Select type...','class'=>['form-control select2'],])->label("Target ")?>
     <?= $form->field($model, 'quarter')->dropDownList($quarters,['prompt'=>'Select type...','class'=>['form-control select2'],])?>

    <?= $form->field($model, 'millstone')->textarea(['rows' => 6]) ?>

 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
