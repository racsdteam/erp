<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTarget */

$this->title = 'Update Pc Target: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pc Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-target-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
         'model' => $model,"position_level" =>$position_level
    ]) ?>

</div>
