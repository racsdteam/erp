<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGoods */

$this->title = 'Create Reception Goods';
$this->params['breadcrumbs'][] = ['label' => 'Reception Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reception-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
       'model' => $model,'modelsItem'=>$modelsItem,'ItemsReceptionSupporting'=>$ItemsReceptionSupporting,
    ]) ?>

</div>
