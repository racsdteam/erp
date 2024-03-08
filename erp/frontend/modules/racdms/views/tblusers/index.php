<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblusers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tblusers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'first_name',
            'last_name',
            'phone',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'approved',
            //'user_level',
            //'created_at',
            //'updated_at',
            //'user_image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
