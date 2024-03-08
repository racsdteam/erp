<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Contact', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'work_phone',
            'mobile_phone',
            'work_email:email',
            //'personal_email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
