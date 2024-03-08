<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisition */

$this->title = 'Update Erp Requisition: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-requisition-update">

 

    <?= $this->render('_form', [
        'model'=>$model,'model1'=>$model1, 'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems,'isAjax'=>$isAjax
    ]) ?>

</div>
