<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganization */

$this->title = 'Update Erp Organization: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Erp Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-organization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
