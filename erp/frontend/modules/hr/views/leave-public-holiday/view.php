<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeavePublicHoliday */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leave Public Holidays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leave-public-holiday-view">
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
            'id',
            'holiday_date',
            'holiday_name',
            'yearly_repeat_status',
            'holiday_type',
            'timestamp',
        ],
    ]) ?>

</div>
</div>
</div>
</div>
