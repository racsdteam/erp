<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\IncotermsSetting */

$this->title = 'Update Incoterms Setting: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Incoterms Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="incoterms-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
