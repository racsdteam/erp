<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructures */

$this->title = 'Create Pay Structures';
$this->params['breadcrumbs'][] = ['label' => 'Pay Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-structures-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
