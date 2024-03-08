<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetAllocations */

$this->title = 'Create Asset Allocations';
$this->params['breadcrumbs'][] = ['label' => 'Asset Allocations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-allocations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
