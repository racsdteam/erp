<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponentTypes */

$this->title = 'Update Pay Component Types: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pay Component Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pay-component-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
