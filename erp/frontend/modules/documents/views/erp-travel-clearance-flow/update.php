<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlow */

$this->title = 'Update Erp Travel Clearance Flow: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearance Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-travel-clearance-flow-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
