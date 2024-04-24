<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tender Item Types Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if (Yii::$app->session->hasFlash('success')){

Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
}


if (Yii::$app->session->hasFlash('error')){

Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
}
?>

<div class="row clearfix">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

        <div class="card card-default ">

            
      
  <div class="card-body">
<div class="callout callout-warning">
         <h5>Tender Item Type!</h5>

         <p> These are all Types of items that are puchased by RAC</p>
       </div>
<div class="d-flex  flex-sm-row flex-column  justify-content-between">
<h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<p>
<?= Html::a('<i class="fas fa-plus"></i> Add Source ', ['create'], ['class' => 'btn btn-outline-primary btn-lg','title'=>'Add Source Fund']) ?>
</p>   

</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            'description:ntext',
            'user_id',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>