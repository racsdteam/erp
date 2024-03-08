<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\CompBanksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comp Banks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comp-banks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comp Banks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'acc_no',
            'branch',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
