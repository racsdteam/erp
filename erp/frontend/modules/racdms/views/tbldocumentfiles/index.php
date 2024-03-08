<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TbldocumentfilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbldocumentfiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocumentfiles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbldocumentfiles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'document',
            'userID',
            'comment:ntext',
            'name',
            //'date',
            //'dir',
            //'orgFileName',
            //'fileType',
            //'mimeType',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
