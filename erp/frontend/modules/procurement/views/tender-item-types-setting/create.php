<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderItemTypesSetting */

$this->title = 'Create Tender Item Types Setting';
$this->params['breadcrumbs'][] = ['label' => 'Tender Item Types Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-item-types-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
