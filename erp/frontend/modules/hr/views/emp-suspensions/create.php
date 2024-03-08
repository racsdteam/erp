<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpSuspensions */

$this->title = 'Create Emp Suspensions';
$this->params['breadcrumbs'][] = ['label' => 'Emp Suspensions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-suspensions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
