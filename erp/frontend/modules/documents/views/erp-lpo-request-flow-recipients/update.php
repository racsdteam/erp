<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestFlowRecipients */

$this->title = 'Update Erp Lpo Request Flow Recipients: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Lpo Request Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-lpo-request-flow-recipients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
