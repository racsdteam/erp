<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderLots */

$this->title = 'Create Tender Lots';
$this->params['breadcrumbs'][] = ['label' => 'Tender Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-lots-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
