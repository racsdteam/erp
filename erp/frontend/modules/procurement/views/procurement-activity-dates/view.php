<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivityDates */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activity Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="procurement-activity-dates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'activity',
            'end_user_requirements_submission',
            'tender_preparation',
            'tender_publication',
            'bids_opening',
            'award_notification',
            'contract_signing',
            'contract_start',
            'supervising_firm',
            'created',
            'updated',
            'user',
        ],
    ]) ?>

</div>
