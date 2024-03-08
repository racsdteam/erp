<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPatternApproval */

$this->title = 'Update Leave Approval Pattern Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Pattern Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leave-approval-pattern-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
