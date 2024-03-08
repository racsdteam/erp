<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionType */

$this->title = 'Update Erp Requisition Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-requisition-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
