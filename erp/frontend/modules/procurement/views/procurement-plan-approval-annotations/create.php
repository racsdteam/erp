<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovalAnnotations */

$this->title = 'Create Procurement Plan Approval Annotations';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Approval Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-approval-annotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
