<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcEvaluation */

$this->title = 'Create Pc Evaluation';
$this->params['breadcrumbs'][] = ['label' => 'Pc Evaluations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-evaluation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,"performance_contracts"=>$performance_contracts,
    ]) ?>

</div>
