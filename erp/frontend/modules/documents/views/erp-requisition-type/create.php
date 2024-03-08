<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionType */

$this->title = 'Create Erp Requisition Type';
$this->params['breadcrumbs'][] = ['label' => 'Erp Requisition Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
