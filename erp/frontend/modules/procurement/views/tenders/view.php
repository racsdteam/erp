<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tender Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php 

  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   ?>


<div class="tender-stages-view">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
                       <div class="card-body">
<div class="float-right">
    <p>
        <?= Html::a('Update', ['update','id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete','id' => (string)  $model->_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Tender Staging?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </div>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                 'label'=>'Created By',
                 'value'=>call_user_func(function ($data) {
                     $_user=$data->User();
                     
                return $_user!=null? $_user->first_name ." ".$_user->last_name : '';
            }, $model),
                 
                
                ],
                
            'title',
            'number',
            'procurement_activity_id',
            'created_at',
            'updated_at',
            'funding_source_code',
            'currencies',
            'number_lots',
            'bid_security_amount',
            'tender_document',
            'alternative_bid_status',
            'final_destination',
            'manufactures_authorization_status',
            'bid_validity_periode',
            'tender_doc_charges_amount',
            'tender_doc_charges_status',
              [
                 'label'=>'Is The tender allowed  alternative bid?',
                 'value'=>call_user_func(function ($data) {
                     if($data)
                     return "Yes";
                     else
                     return "No";
            }, $model->alternative_bid_status),
                 
                
                ],  
        ],
    ]) ?>
</div>
</div>
</div>
</div>
<div class="row clearfix">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                              <h3 class="card-title"><i class="fa fa-file-o"></i>Tender Lots</h3>
                       </div>      
         
  
           <div class="card-body">
               <div class="callout callout-warning">
                  <h5>Tender Lot Definition and Setup!</h5>

                  <p>This Window Help on the tender Lot setup</p>
                </div>
                        <div class="d-flex  flex-sm-row flex-column  justify-content-between">
    <h4></h4>
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Lot', ['tender-lots/create', 'tender_id' =>(string) $model->_id], ['class' => 'btn btn-outline-primary btn-lg ','title'=>'Add Satge']) ?>
    </p>   
       
   </div>
   <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
   <?php
      
      $lots=$model->getLots();
        ?>   
             <?php foreach($lots as $lot) : ?>
            
             
              <li class="nav-item">
                <a class="nav-link <?php echo $lot->number==1 ?'active show':''  ?>" 
                id="custom-content-above-<?php echo $lot->number ?>-tab" 
                data-toggle="pill" href="#custom-content-above-<?php echo $lot->number?>" role="tab" 
                aria-controls="custom-content-above-<?php echo $lot->number ?>" aria-selected="true">
                  <strong> Lot  <?php echo $lot->number ?></strong> 
                   </a>
              </li>
             
             <?php endforeach; ?>
            
            
            </ul>

                     
            <div class="tab-content" id="custom-content-above-tabContent">
                
              <?php foreach($lots as $lot) : ?>
           
              <div class="tab-pane fade  <?php echo $lot->number==1 ?'active show':''  ?> " 
              id="custom-content-above-<?php echo $lot->number ?>" role="tabpanel" 
               aria-labelledby="custom-content-above-<?php echo $lot->number ?>-tab">
            <h2><?php echo $lot->title ?></h2>
            <?= $lot->description ?>

<?php
$envelopes= $lot->getEnvelopes();

?>

 <?php foreach($envelopes as $envelope) : ?>
    
            <h3>Lot Envelope: <?=$envelope->name  ?></h3>
 <?php $sections=$envelope->sections; ?>

 <?php foreach($sections as $section) : ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i>   <?=  $section->name?></h3>
                       </div>
               
           <div class="card-body">

    <div class="d-flex  flex-sm-row flex-column  justify-content-end mt-3 mb-3">
                 <?= Html::a('<i class="fas fa-user-plus"></i> Add lot section'.$lot->number, ['create','lot_number'=>(string)$lot->_id], ['class' => 'btn btn-outline-primary btn-md mr-2 ','title'=>'lot section Add']) ?>
    </div> 
    </div>
   </div>
  </div>
<?php endforeach;?>

<strong>End Envelope</strong>
 <?php endforeach;?>
             </div> 
           <?php endforeach;?>


             </div> 
</div>
</div>
</div>
</div>
</div>