<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */

$this->title = 'Create Emp Pay Details';
$this->params['breadcrumbs'][] = ['label' => 'Emp Pay Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
