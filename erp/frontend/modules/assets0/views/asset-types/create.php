<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetTypes */

$this->title = 'Create Asset Types';
$this->params['breadcrumbs'][] = ['label' => 'Asset Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
