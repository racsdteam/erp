<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestSupportingDoc */

$this->title = 'Update Erp Lpo Request Supporting Doc: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Erp Lpo Request Supporting Docs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-lpo-request-supporting-doc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
