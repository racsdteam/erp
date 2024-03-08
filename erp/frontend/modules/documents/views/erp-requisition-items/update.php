<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionItems */

$this->title = 'Update Erp Requisition Items: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-requisition-items-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
