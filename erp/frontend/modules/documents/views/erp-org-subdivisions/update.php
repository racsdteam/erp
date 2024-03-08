<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgSubdivisions */

$this->title = 'Update Erp Org Subdivisions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Org Subdivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-org-subdivisions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
