<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearance */

$this->title = 'Create Erp Travel Clearance';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-clearance-create">


    <?= $this->renderAjax('_form', [
        'model' => $model,'memo'=>$memo,
    ]) ?>

</div>
