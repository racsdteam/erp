<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisition */

$this->title = 'New Purchase Requisition';
$this->params['breadcrumbs'][] = ['label' => 'My Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-create">

   

    <?= $this->render('_form', [
        'model'=>$model,'model1'=>$model1,  'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems,'isAjax'=>$isAjax
    ]) ?>

</div>
