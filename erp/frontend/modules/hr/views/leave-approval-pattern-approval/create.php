<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPatternApproval */

$this->title = 'Create Leave Approval Pattern Approval';
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Pattern Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-pattern-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
