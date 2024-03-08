<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpSubdivisionPositions */

$this->title = 'Create Erp Subdivision Positions';
$this->params['breadcrumbs'][] = ['label' => 'Erp Subdivision Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-subdivision-positions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
