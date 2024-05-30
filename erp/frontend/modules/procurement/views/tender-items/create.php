<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderItems */

$this->title = 'Create Tender Items';
$this->params['breadcrumbs'][] = ['label' => 'Tender Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
