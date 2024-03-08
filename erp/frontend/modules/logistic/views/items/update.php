<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Itemlist */

$this->title = 'Update Itemlist: ' . $model->it_id;
$this->params['breadcrumbs'][] = ['label' => 'Itemlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->it_id, 'url' => ['view', 'id' => $model->it_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="itemlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
