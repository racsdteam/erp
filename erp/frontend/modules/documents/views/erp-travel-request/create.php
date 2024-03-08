<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelRequest */

$this->title = 'New Travel Request';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-request-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
