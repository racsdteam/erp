<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tenders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tenders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'name',
            'number',
           // '',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
