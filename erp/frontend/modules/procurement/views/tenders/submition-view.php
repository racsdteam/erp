<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tender Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

if(empty($model->number))
$tender_number= $model->generateNumner();
else
$tender_number= $model->number;
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

  

  <!---

Start for Tender information information
      -->   
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              <h2>Tender Number <?= $tender_number ?></h2>
                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i>Tender basic Info</h3>
                       </div>
                       <div class="card-body">

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
                [
                  'label'=>'DAO',
                  'format' => 'raw',
                  'value'=>call_user_func(function ($data) {
                      if($data)
                      return Html::a('<i class="fas fa-eye"></i> View document', Url::base()."/".$data, ['class'=>['text-info'],
                        'title' => Yii::t('app', 'DAO'),
                        'target' => '_blank',
                    ]);
                      else
                      return "No";
             }, $model->dao),
                  
                 
                 ],
                 [
                  'label'=>'RFQ',
                  'format' => 'raw',
                  'value'=>call_user_func(function ($data) {
                      if($data)
                      return Html::a('<i class="fas fa-eye"></i> View document', Url::base()."/".$data, ['class'=>['text-info'],
                        'title' => Yii::t('app', 'RFQ'),
                        'target' => '_blank',
                    ]);
                      else
                      return "No";
             }, $model->rfq),
                  
                 
                 ],
                 [
                  'label'=>'RFP',
                  'format' => 'raw',
                  'value'=>call_user_func(function ($data) {
                      if($data)
                      return Html::a('<i class="fas fa-eye"></i> View document', Url::base()."/".$data,['class'=>['text-info'],
                        'title' => Yii::t('app', 'RFP'),
                        'target' => '_blank',
                    ]);
                      else
                      return "No";
             }, $model->rfp),
                  
                 
                 ],
        ],
    ]) ?>
</div>
</div>
</div>
</div>
<!---

End for Tender basic information
      -->


<!---

Start for Tender Lots information
      -->      
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
            
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

<div class="card card-default text-dark">

      <div class="card-header ">
           <h3 class="card-title"><i class="fas fa-suitcase"></i>Items or Services to be purchased</h3>
      </div>

<div class="card-body">
<?php
    $dataProviderItems= new  \yii\data\ActiveDataProvider([
      'models' => $items= $lot->getItems(),
      'pagination'=>false
      
  ]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderItems,
        'columns' => [
        
         ['class' => 'yii\grid\SerialColumn',
         'contentOptions' => ['style' => ' white-space:nowrap;']
        ],
            'name',
            [
              'attribute' => 'description',
              'format' => 'html', // Set the format to HTML
              'value' => function ($model) {
                  return Html::tag('div', $model->description, ['class' => 'custom-class']);
                  // Assuming $model->description contains the HTML content you want to display
              },
          ],
            'type',
            'unite',
            'quantity',

        ],
    ]); ?>
</div>
</div>
</div>
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
  <?php 
  if($section->is_staffing):
?>
    <?php
    $dataProviderDocuments= new  \yii\data\ActiveDataProvider([
      'models' => $items= $lot->getStaffs($section->code),
      'pagination'=>false
      
  ]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderDocuments,
        'columns' => [
         ['class' => 'yii\grid\SerialColumn',
         'contentOptions' => ['style' => ' white-space:nowrap;']
        ],
            'position',
            'description',
            'documents',

        ],
    ]); ?>
  <?php else: ?>
    <?php
    $dataProviderDocuments= new  \yii\data\ActiveDataProvider([
      'models' => $items= $lot->getDocuments($section->code),
      'pagination'=>false
      
  ]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderDocuments,
        'columns' => [    
         ['class' => 'yii\grid\SerialColumn',
         'contentOptions' => ['style' => ' white-space:nowrap;']
        ],
            'document_code',
            'number',

        ],
    ]); ?>
  <?php 
endif;
  ?>
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


<!---

End for Tender Lots information
      -->

<!---

Start for Tender Stages information
      -->   
      <div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i>Tender Satges</h3>
                       </div>
                       <div class="card-body">
                       <div class="callout callout-warning">
                  <h5>Tender Stages Definition and Setup!</h5>

                  <p>This Window Help on the tender satges setup</p>
                </div>           
<?php
  $stage_sequencies=$model->getStages()->stageSequencies;
  $tender_stage_sequencies=$model->getStageInstances();
    $dataProviderStages= new  \yii\data\ActiveDataProvider([
      'models' => $items= $tender_stage_sequencies,
      'pagination'=>false
      
  ]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderStages,
        'columns' => [

         ['class' => 'yii\grid\SerialColumn',
         'contentOptions' => ['style' => ' white-space:nowrap;']
        ],
            'stage_name',
            'stage_code',
            'sequence_number',
            'start_date',
            'end_date',

        ],
    ]); ?>


                       </div>
                 </div>
             </div>
      </div>
  </div>
</div>
<h3>Click here To Submit the tender</h3>
<div class="d-flex  flex-sm-row flex-column  justify-content-between">
   
  <div class="float-right">
     <p>
        <?= Html::a('<i class="fas fa-file"></i> Save Tender', ['tenders/submition', 'id' =>(string) $model->_id,'number'=>$tender_number],
         [
          'class' => 'btn btn-outline-success btn-lg ','title'=>'Submit Tender',
          'data' => [
              'confirm' => 'Are you sure you want to Save this Tender?',
              'method' => 'post',
          ]
          ]) ?>
    </p>   
      </div>
  </div> 
</div>