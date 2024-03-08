<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocument */

$this->title = 'Update Erp Document: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
