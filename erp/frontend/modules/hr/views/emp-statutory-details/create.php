<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpStatutoryDetails */

$this->title = 'Create Emp Statutory Details';
$this->params['breadcrumbs'][] = ['label' => 'Emp Statutory Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-statutory-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
