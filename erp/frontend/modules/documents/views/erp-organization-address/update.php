<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationAddress */

$this->title = 'Update Erp Organization Address: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Organization Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-organization-address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
