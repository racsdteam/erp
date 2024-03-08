<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tbldocuments */

$this->title = 'Create Tbldocuments';
$this->params['breadcrumbs'][] = ['label' => 'Tbldocuments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocuments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
