<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPattern */

$this->title = 'Create Leave Approval Template';
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Patterns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-pattern-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
