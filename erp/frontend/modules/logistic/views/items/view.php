<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Itemlist */

$this->title = $model->it_name;
$this->params['breadcrumbs'][] = ['label' => 'Itemlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="itemlist-view">
     <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body">
    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
   
    </p>
    <h3><?= Html::encode($this->title) ?></h3>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'it_code',
             'subcategories.name',
             'subcategories.categories.name',
            'it_name',
            'it_tech_specs',
            'it_min',
            'it_unit',
         
        ],
    ]) ?>

</div>
</div>
</div>
</div>