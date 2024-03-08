<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\EnvelopeSettting */

$this->title = 'Create Envelope Settting';
$this->params['breadcrumbs'][] = ['label' => 'Envelope Setttings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envelope-settting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
