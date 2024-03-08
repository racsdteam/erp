<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelRequestAttachAnnotations */

$this->title = 'Update Erp Travel Request Attach Annotations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Request Attach Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-travel-request-attach-annotations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
