<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormApproval */

$this->title = 'Create Erp Claim Form Approval';
$this->params['breadcrumbs'][] = ['label' => 'Erp Claim Form Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-claim-form-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
