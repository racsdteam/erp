<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoSupportingDocAnnotations */

$this->title = 'Update Erp Memo Supporting Doc Annotations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Supporting Doc Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-memo-supporting-doc-annotations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
