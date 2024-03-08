<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitDepartment */

$this->title = 'Update Erp Unit Department: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Unit Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-unit-department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
