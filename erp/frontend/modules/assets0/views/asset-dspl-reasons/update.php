<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetDsplReasons */

$this->title = 'Update Asset Dspl Reasons: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Asset Dspl Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asset-dspl-reasons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
