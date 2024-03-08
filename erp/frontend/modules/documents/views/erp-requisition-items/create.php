<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionItems */

$this->title = 'Create Erp Requisition Items';
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
