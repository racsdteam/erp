<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPatternUnit */

$this->title = 'Create Leave Approval Pattern Unit';
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Pattern Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-pattern-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
