<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpStatusDetailsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Status Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-status-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Status Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'status',
            'effective_date',
            'comment:ntext',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
