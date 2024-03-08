<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTarget */

$this->title = 'Add a new Target';
$this->params['breadcrumbs'][] = ['label' => 'Pc Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-target-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,"position_level" =>$position_level
    ]) ?>

</div>
