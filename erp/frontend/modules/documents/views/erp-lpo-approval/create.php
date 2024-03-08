<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionApproval */

$this->title = 'Create Erp Requisition Approval';
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
