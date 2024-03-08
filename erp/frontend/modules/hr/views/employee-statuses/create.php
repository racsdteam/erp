<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementType */

$this->title = 'Create Employement Type';
$this->params['breadcrumbs'][] = ['label' => 'Employement Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employement-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
