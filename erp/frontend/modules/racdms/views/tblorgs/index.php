<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblorgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblorgs-index">

    

    <p>
        <?= Html::a('Create Organisation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'address:ntext',
            'contact',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
