<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormFlowRecipients */

$this->title = 'Update Erp Claim Form Flow Recipients: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Claim Form Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-claim-form-flow-recipients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
