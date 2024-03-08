<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcEvaluation */

$this->title = 'Update Pc Evaluation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pc Evaluations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-evaluation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,"performance_contracts"=>$performance_contracts,
    ]) ?>

</div>
