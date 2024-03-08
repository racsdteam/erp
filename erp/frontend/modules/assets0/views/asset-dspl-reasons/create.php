<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetDsplReasons */

$this->title = 'Create Asset Dspl Reasons';
$this->params['breadcrumbs'][] = ['label' => 'Asset Dspl Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-dspl-reasons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
