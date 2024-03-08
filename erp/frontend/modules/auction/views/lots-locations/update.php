<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\ItemsLocations */

$this->title = 'Update Items Locations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Items Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-locations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
