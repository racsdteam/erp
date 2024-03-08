<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpTravelRequestApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Travel Request Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-request-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Travel Request Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tr_id',
            'approval_status',
            'approved_by',
            'approved',
            //'remark:ntext',
            //'is_new',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
