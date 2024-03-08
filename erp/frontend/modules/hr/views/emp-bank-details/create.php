<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpBanks */

$this->title = 'Create Emp Banks';
$this->params['breadcrumbs'][] = ['label' => 'Emp Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-banks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
