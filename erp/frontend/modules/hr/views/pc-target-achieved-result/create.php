<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTargetAchievedResult */

$this->title = 'Create Pc Target Achieved Result';
$this->params['breadcrumbs'][] = ['label' => 'Pc Target Achieved Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pc-target-achieved-result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'evaluation_id'=>$evaluation_id
    ]) ?>

</div>
