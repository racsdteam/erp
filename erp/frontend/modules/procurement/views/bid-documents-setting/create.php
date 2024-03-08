<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\BidDocumentsSetting */

$this->title = 'Create Bid Documents Setting';
$this->params['breadcrumbs'][] = ['label' => 'Bid Documents Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bid-documents-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
