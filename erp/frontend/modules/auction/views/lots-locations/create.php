<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\ItemsLocations */

$this->title = 'Create Items Locations';
$this->params['breadcrumbs'][] = ['label' => 'Items Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-locations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
