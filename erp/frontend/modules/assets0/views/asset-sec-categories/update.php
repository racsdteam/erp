<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\assets0\models\AssetSecCategories */

$this->title = 'Update Asset Sec Categories: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Asset Sec Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asset-sec-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
