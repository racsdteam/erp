<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ExcludedFromPay */

$this->title = 'Hold  Salary';
$this->params['breadcrumbs'][] = ['label' => 'Salay On Hold', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excluded-from-pay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
