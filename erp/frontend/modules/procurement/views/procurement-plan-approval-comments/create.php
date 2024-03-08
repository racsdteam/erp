<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovalComments */

$this->title = 'Create Procurement Plan Approval Comments';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Approval Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-approval-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
