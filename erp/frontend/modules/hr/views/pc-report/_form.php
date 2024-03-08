<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcReport */
/* @var $form yii\widgets\ActiveForm */
$types=[ 'weekly report' => 'Weekly report', 'progress report' => 'Progress report', 'quarter report' => 'Quarter report', 'mid-year report' => 'Mid-year report', 'status report' => 'Status report', 'final-year report' => 'Final-year report', ];
$this_year=date("Y");
$this_month=date("m");

if($this_month >= 7 ):
$one_year_ago=$this_year-1;
$neXt_year=$this_year+1;
$this_fin_year=$this_year."-".$neXt_year;
$previous_fin_year=$one_year_ago."-".$this_year;
else:
 $one_year_ago=$this_year-1;
$two_year_ago=$this_year-2;
$this_fin_year=$one_year_ago."-".$this_year;
$previous_fin_year=$two_year_ago."-".$one_year_ago;   
endif;
$fin_year=array($this_fin_year=>$this_fin_year,$previous_fin_year=>$previous_fin_year);


?>

<div class="pc-report-form">
      <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList($types, ['prompt'=>'Select type...','class'=>['form-control select2']]) ?>
  
  <?= $form->field($model, 'financial_year')
        ->dropDownList($fin_year,['prompt'=>'Select type...','class'=>['form-control select2']])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>