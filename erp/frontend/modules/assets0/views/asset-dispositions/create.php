<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetDispositions */

$this->title = 'Create Asset Dispositions';
$this->params['breadcrumbs'][] = ['label' => 'Asset Dispositions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-dispositions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
