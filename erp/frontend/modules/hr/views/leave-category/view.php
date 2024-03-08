<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveCategory */

$this->title = $model->leave_category;
$this->params['breadcrumbs'][] = ['label' => 'Leave Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leave-category-view">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 ">

                 <div class="box box-default color-palette-box">
        
                       <div class="box-header with-border">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
 <div class="box-body">
    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'leave_category',
            'leave_number_days',
            'leave_annual_request_frequency',
            'comment:ntext',
            'timestamp',
        ],
    ]) ?>
    </div>
</div>
</div>
</div>
</div>