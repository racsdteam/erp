<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ItemsReception */

$this->title = 'Update Items Reception: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Items Receptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-reception-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
