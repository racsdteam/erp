<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\procurement\models\ProcurementPlanApprovalAnnotationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Plan Approval Annotations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-approval-annotations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procurement Plan Approval Annotations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'doc',
            'type',
            'annotation:ntext',
            'annotation_id',
            //'author',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
