<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeSegment */

$this->title = 'Update Aerodrome Segment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aerodrome Segments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aerodrome-segment-update">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
               
           <div class="card-body"> 
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
</div>