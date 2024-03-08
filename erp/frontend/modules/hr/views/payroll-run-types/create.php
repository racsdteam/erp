<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementType */

$this->title = 'Create Payroll Types';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
