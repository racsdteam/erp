<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponentTypes */

$this->title = 'Create Pay Component Types';
$this->params['breadcrumbs'][] = ['label' => 'Pay Component Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-component-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
