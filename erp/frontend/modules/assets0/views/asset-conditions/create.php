<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetStatuses */

$this->title = 'Create Asset Condtion';
$this->params['breadcrumbs'][] = ['label' => 'Asset Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-statuses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
