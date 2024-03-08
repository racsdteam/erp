<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoAnnotations */

$this->title = 'Update Erp Memo Annotations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-memo-annotations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
