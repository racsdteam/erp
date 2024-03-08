<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RequestToStock */

$this->title = 'Create Stock voucher';
$this->params['breadcrumbs'][] = ['label' => 'Request To Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-to-stock-create">

    <?= $this->render('_form', [
        'model' => $model,'modelsItem' => $modelsItem,
    ]) ?>

</div>
