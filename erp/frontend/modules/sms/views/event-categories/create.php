<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sms\models\EventCategories */

$this->title = 'Create Event Categories';
$this->params['breadcrumbs'][] = ['label' => 'Event Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
