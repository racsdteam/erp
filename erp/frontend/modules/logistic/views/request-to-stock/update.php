<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RequestToStock */

$this->title = 'Update Request To Stock: ' . $model->reqtostock_id;
$this->params['breadcrumbs'][] = ['label' => 'Request To Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reqtostock_id, 'url' => ['view', 'id' => $model->reqtostock_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-to-stock-update">
    <?= $this->render('_form', [
        'model' => $model,'modelsItem' => $modelsItem,
    ]) ?>

</div>
