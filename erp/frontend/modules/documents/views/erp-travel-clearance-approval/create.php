<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceApproval */

$this->title = 'Create Erp Travel Clearance Approval';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearance Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-clearance-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
