<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpAdditionalPay */

$this->title = 'Create Emp Additional Pay';
$this->params['breadcrumbs'][] = ['label' => 'Emp Additional Pays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-additional-pay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
