<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlans */

$this->title = 'Create Procurement Plans';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
