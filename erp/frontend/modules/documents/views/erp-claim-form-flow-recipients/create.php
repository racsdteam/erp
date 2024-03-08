<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormFlowRecipients */

$this->title = 'Create Erp Claim Form Flow Recipients';
$this->params['breadcrumbs'][] = ['label' => 'Erp Claim Form Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-claim-form-flow-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>