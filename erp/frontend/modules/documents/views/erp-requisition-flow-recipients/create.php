<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionFlowRecipients */

$this->title = 'Create Erp Requisition Flow Recipients';
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-flow-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
