<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTerminations */

$this->title = 'Create Emp Terminations';
$this->params['breadcrumbs'][] = ['label' => 'Emp Terminations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-terminations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
