<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ItemsReception */

$this->title = 'Create Items Reception';
$this->params['breadcrumbs'][] = ['label' => 'Items Receptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-reception-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelsItem' => $modelsItem,
    ]) ?>

</div>
