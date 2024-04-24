<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\IncotermsSetting */

$this->title = 'Create Incoterms Setting';
$this->params['breadcrumbs'][] = ['label' => 'Incoterms Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoterms-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
