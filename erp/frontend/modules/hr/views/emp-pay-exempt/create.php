<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayExempt */

$this->title = 'Create Emp Pay Exempt';
$this->params['breadcrumbs'][] = ['label' => 'Emp Pay Exempts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-exempt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
