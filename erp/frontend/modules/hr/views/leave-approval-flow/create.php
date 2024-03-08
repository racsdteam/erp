<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalFlow */

$this->title = 'Create Leave Approval Flow';
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-flow-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
