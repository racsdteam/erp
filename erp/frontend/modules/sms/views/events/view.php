<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sms\models\Events */

$this->title = $model->place." on ".$model->date;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-report-view">
<div class="card card-success card-outline card-tabs">
    <div class="card-header p-0 pt-1">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
 <div class="card-body">
   <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_code',
            'place',
            'date',
            'time',
            [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>call_user_func(function ($data) {
                     $_status=$data->status;
                     if($_status=='drafting' || $_status=='returned'){$class="badge badge-danger";}else{$class="badge badge-success";}
                     
                     $badge='<small class="'.$class.'" ><i class="far fa-clock"></i> '. $_status.'</small> ';
                    
                return $badge;
            }, $model)
                ],
                 [
                 'label'=>'Created time',
                 'value'=>$model->timestamp,
                ],
                
                'description:ntext',
        ],
    ]) ?>
</div>
</div>  
</div>  
</div>
</div>
