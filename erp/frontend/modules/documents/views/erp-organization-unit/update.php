<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationUnit */

$this->title = 'Update Erp Organization Unit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Organization Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-organization-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
