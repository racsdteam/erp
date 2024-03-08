<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompStatutoryDeductions */

$this->title = 'Create Comp Statutory Deductions';
$this->params['breadcrumbs'][] = ['label' => 'Comp Statutory Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comp-statutory-Deductions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
