<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpPersonsInPosition */

$this->title = 'Create Erp Persons In Position';
$this->params['breadcrumbs'][] = ['label' => 'Erp Persons In Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-persons-in-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
