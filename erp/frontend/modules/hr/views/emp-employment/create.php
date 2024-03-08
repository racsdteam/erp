<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpEmployement */

$this->title = 'Create Emp Employement';
$this->params['breadcrumbs'][] = ['label' => 'Emp Employements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-employement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelOptions'=>$modelOptions
    ]) ?>

</div>
