<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlowRecipients */

$this->title = 'Create Erp Travel Clearance Flow Recipients';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearance Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-clearance-flow-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
