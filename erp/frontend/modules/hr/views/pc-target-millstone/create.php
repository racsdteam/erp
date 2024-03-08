<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTargetMillstone */

$this->title = 'Create Pc Target Millstone';
$this->params['breadcrumbs'][] = ['label' => 'Pc Target Millstones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-target-millstone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'id'=>$id
    ]) ?>

</div>
