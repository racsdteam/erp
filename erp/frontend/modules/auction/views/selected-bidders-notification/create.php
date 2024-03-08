<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\SelectedBiddersNotification */

$this->title = 'Create Selected Bidders Notification';
$this->params['breadcrumbs'][] = ['label' => 'Selected Bidders Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selected-bidders-notification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
