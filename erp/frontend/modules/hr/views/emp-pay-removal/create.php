<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayRemoval */

$this->title = 'Create Emp Pay Removal';
$this->params['breadcrumbs'][] = ['label' => 'Emp Pay Removals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-removal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
