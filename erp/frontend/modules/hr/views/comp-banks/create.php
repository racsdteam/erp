<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompBanks */

$this->title = 'Create Comp Banks';
$this->params['breadcrumbs'][] = ['label' => 'Comp Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comp-banks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
