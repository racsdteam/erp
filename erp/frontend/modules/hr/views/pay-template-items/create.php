<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureItems */

$this->title = 'Create Pay Structure Items';
$this->params['breadcrumbs'][] = ['label' => 'Pay Structure Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-structure-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
