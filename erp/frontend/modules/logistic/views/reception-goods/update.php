<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGoods */

$this->title = 'Update Reception Goods: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reception Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reception-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelsItem'=>$modelsItem,'ItemsReceptionSupporting'=>$ItemsReceptionSupporting,
    ]) ?>

</div>
