<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeSegment */

$this->title = 'Create Aerodrome Segment';
$this->params['breadcrumbs'][] = ['label' => 'Aerodrome Segments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aerodrome-segment-create">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
               
           <div class="card-body"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
</div>
</div>
