<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgs */

$this->title = 'Update Tblorgs: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tblorgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblorgs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
