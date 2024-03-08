<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\assets0\models\AssetSecCategories */

$this->title = 'Create Asset Sec Categories';
$this->params['breadcrumbs'][] = ['label' => 'Asset Sec Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-sec-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
