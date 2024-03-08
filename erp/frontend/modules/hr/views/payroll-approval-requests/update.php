<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollApprovalRequests */

$this->title = 'Update Payroll Approval Requests: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Approval Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-approval-requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
