<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayGradeLevels */

$this->title = 'Create Pay Grade Levels';
$this->params['breadcrumbs'][] = ['label' => 'Pay Grade Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-grade-levels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
