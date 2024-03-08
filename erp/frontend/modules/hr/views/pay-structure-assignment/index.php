<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\PayStructureAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Structure Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-structure-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pay Structure Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pay_structure',
            'pay_level',
            'employee',
            'active',
            //'timestamp',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
