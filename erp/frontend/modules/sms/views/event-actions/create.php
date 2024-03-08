<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sms\models\EventActions */

$this->title = 'Create Event Actions';
$this->params['breadcrumbs'][] = ['label' => 'Event Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-actions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
