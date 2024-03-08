<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitsPositions */

$this->title = 'Create Erp Units Positions';
$this->params['breadcrumbs'][] = ['label' => 'Erp Units Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-units-positions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
