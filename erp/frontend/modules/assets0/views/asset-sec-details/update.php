<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\assets0\models\AssetSecDetails */

$this->title = 'Update Asset Sec Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asset Sec Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asset-sec-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
