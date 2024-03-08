<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTargetAchievedResult */

$this->title = 'Update Pc Target Achieved Result: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pc Target Achieved Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-target-achieved-result-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'report_id'=>$report_id
    ]) ?>

</div>
