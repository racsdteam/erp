<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTransmissionSlip */

$this->title = 'Create Erp Transmission Slip';
$this->params['breadcrumbs'][] = ['label' => 'Erp Transmission Slips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-transmission-slip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
