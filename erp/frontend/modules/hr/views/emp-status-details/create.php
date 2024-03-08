<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpStatusDetails */

$this->title = 'Create Emp Status Details';
$this->params['breadcrumbs'][] = ['label' => 'Emp Status Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-status-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
