<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpEmployementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Employements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-employement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Employement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'unit',
            'position',
            'pay_type',
            //'pay_group',
            //'pay_grade',
            //'hire_date',
            //'termination_date',
            //'employement_type',
            //'supervisor',
            //'work_location:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
