<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentType */

$this->title = 'Update Erp Document Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-document-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
