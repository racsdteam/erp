<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Payslips */

$this->title = 'Create Payslips';
$this->params['breadcrumbs'][] = ['label' => 'Payslips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payslips-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
