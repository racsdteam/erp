<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\FundingSources */

$this->title = 'Create Funding Sources';
$this->params['breadcrumbs'][] = ['label' => 'Funding Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funding-sources-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
