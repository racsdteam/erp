<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayGroups */

$this->title = 'Create Pay Groups';
$this->params['breadcrumbs'][] = ['label' => 'Pay Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
