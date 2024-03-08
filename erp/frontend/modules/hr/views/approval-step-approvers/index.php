<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\ApprovalStepApproversSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approval Step Approvers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-step-approvers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Approval Step Approvers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'approver',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
