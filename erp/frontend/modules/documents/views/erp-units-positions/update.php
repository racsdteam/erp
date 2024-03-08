<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitsPositions */

$this->title = 'Update Erp Units Positions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Units Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-units-positions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
