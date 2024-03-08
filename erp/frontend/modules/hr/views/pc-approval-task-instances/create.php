<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalTasks */

$this->title = "Payrolls Approval for ".date('F', mktime(0, 0, 0, $model->pay_period_month, 1))." Of ".$model->pay_period_year ;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Approval Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
