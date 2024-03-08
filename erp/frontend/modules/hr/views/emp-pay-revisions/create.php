<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayIncrements */

$this->title = 'Create  Pay Revision';
$this->params['breadcrumbs'][] = ['label' => 'Pay Revisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-increments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'newPay'=>$newPay,'employee'=>$employee
    ]) ?>

</div>
