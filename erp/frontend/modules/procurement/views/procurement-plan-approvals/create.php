<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovals */

$this->title = 'Create Procurement Plan Approvals';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-approvals-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
