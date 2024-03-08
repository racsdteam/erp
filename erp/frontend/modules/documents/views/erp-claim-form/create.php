<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimForm */

$this->title = 'Create Claim Form';
$this->params['breadcrumbs'][] = ['label' => 'Claim Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-claim-form-create">
    <?= $this->render('_form', [
        'model' => $model,'model2' => $model2,
    ]) ?>

</div>
