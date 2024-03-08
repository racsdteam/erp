<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\LeaveApprovalFlowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approval Flows';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-flow-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Leave Approval Flow', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'request',
            'originator',
            'approver',
            'status',
            //'remark:ntext',
            //'is_new',
            //'is_copy',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
