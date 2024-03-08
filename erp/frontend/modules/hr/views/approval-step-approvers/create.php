<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ApprovalStepApprovers */

$this->title = 'Create Approval Step Approvers';
$this->params['breadcrumbs'][] = ['label' => 'Approval Step Approvers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-step-approvers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
