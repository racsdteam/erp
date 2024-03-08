<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\procurement\models\ProcurementActivityDatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Activity Dates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-activity-dates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procurement Activity Dates', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'activity',
            'end_user_requirements_submission',
            'tender_preparation',
            'tender_publication',
            //'bids_opening',
            //'award_notification',
            //'contract_signing',
            //'contract_start',
            //'supervising_firm',
            //'created',
            //'updated',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
