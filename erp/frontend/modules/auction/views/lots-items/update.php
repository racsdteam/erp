<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\LotsItems */

$this->title = 'Update Lots Items: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lots Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lots-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
