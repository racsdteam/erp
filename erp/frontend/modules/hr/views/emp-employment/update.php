<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpEmployement */

$this->title = 'Update Employement Details For : '.$model->employee0->first_name." ".$model->employee0->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Employee', 'url' => ['employees/view', 'id' => $model->employee0->id]];
/*$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];*/
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-employement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelOptions'=>$modelOptions
    ]) ?>

</div>
