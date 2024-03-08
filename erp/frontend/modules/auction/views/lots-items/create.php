<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\LotsItems */

$this->title = 'Create Lots Items';
$this->params['breadcrumbs'][] = ['label' => 'Lots Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lots-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
