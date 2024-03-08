<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayrollRepsApprovalRequestInstances;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Approval History', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>

<style>
    .not-active td{
     background-color: #EBEBE4;    
    }
    
</style>

<?php


if(Yii::$app->session->hasFlash('success')){
  Yii::$app->alert(Yii::$app->session->getFlash('success'),'success');
   
    
}

if(Yii::$app->session->hasFlash('error')){
   Yii::$app->alert(Yii::$app->session->getFlash('error'),'error');
    
}


$stepStatusCallBack=function($step){
$res=[];
    switch($step->status){
                   
                       case  'started' :
                          $res['bageClass']='badge badge-warning';
                          $res['cardClass']='card-warning';
                          $res['status']='Waiting For Approval';
                          
                        break;
                         case 'not started':
                          $res['bageClass']='badge badge-secondary';
                          $res['cardClass']='card-default';
                          $res['status']="Not Initiated";
                         break;
                     case 'approved' :
                     case 'reviewed' :
                     case 'completed' :
                          $res['bageClass']='badge badge-success';
                          $res['cardClass']='card-success';
                          $res['status']=$step->status;
                         break;
                     
                     default:
                          $res['bageClass']='badge badge-warning';
                          $res['cardClass']='card-warning';
                          $res['status']=$step->status;
                        
                }
                
    return $res;            
};
$approvalStatusCallBack=function($task){
$res=[];
    switch($task->status){
                   
                       case  'pending' :
                          $res['bageClass']='badge badge-warning';
                          $res['status']=$task->action_required.' Pending';
                          
                        break;
                         case 'started':
                          $res['bageClass']='badge badge-info';
                          $res['status']=$task->action_required.' Started';
                         break;
                     case 'approved' :
                     case 'reviewed' :
                     case 'completed' :
                          $res['bageClass']='badge badge-success';
                          $res['status']=$task->outcome;
                         break;
                     
                     default:
                          $res['bageClass']='badge badge-warning';
                          $res['status']=$task->status;
                        
                }
                
    return $res;            
}
?>
    
    

              
         <?php
               
         $wfInst=PayrollRepsApprovalRequestInstances::findOne($wf);
         $attributes = [
   
    [
        'columns' => [
            [
                'attribute'=>'wf_name', 
                'label'=>'Approval Flow Name',
                'value'=>$wfInst->wf_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'initiator', 
                'label'=>'Started By',
                'value'=>$wfInst->wfInitiator->first_name.' '.$wfInst->wfInitiator->last_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
        ],
    ],
   
      [
        'columns' => [
            [
                'attribute'=>'started_at', 
                'label'=>'Started',
                'value'=>$wfInst->started_at,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'completed_at', 
                'label'=>'Completed',
                'value'=>$wfInst->completed_at,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ],
     [
                'attribute'=>'status', 
                'label'=>'Status',
                'value'=>call_user_func(function ($data) {
               $class='';
                
                switch($data->status){
                    case 'approved':
                         $class='badge badge-success';
                         break;
                     case 'rejected':
                     case 'canceled':    
                         $class='badge badge-danger';
                         break;
                     default:
                          $class='badge badge-warning';
                        
                }
                return Html::tag('span', Html::encode(ucwords($data->status)), ['class' =>$class]) ;
            }, $wfInst),
               
          'format' => 'raw',
                'valueColOptions'=>['style'=>'width:100%'], 
                'displayOnly'=>true
            ],
 
];

?>
<div class="card card-default">
         
          <div class="card-body text-dark">
<?php
// View file rendering the widget
echo DetailView::widget([
    'model' => $wfInst,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' =>true,
    'striped' => true,
    'condensed' =>true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'right',
    'vAlign'=>'middle',
   
   
   
]);
         ?>
  <div class="d-flex flex-column mt-2">
 <!-------------Approval List--------------------------------------------->        
  <?php if(!empty($wfInst->reviewStepInstances))  : ?>       
  <?php $i=1; $size=count($wfInst->reviewStepInstances); foreach($wfInst->reviewStepInstances as $step) : $res=$stepStatusCallBack($step);?>
<div class="card card-outline <?php echo $res['cardClass'];?>">
              <div class="card-header">
                <h3 class="card-title"><b><?=$step->name ?> </b><?= Html::tag('span', Html::encode(ucwords($res['status'])), ['class' =>$res['bageClass']])?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
               <?php
               //get all submitted approvals for this step
               $approvals=$step->getTaskInstances($wfInst::TASK_CLASS);
               if(!empty( $approvals)) :
                  echo '<ul class="products-list product-list-in-card pl-2 pr-2">';
               foreach($approvals as $approval) : 
                    
                    $res=$approvalStatusCallBack($approval);
                    $lastReviewed=$approval->isComplete() ? $approval->completed_at :  date("Y-m-d H:i:s");
                    $assigned=$approval->created_at;
                    $dateTime1 = new DateTime($lastReviewed);
                    $dateTime2 = new DateTime($assigned);
                    $diff = $dateTime1->diff($dateTime2);
               ?>
               <li class="item">
                    <div class="product-img">
                      <img class="img-circle" src="/erp/img/avatar-user.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?=$approval->assignedTo->first_name.' '.$approval->assignedTo->last_name ?>
                        <span class="<?php echo $res['bageClass'] ?> float-right"><?=$res['status']?></span></a><br/>
                        <small class="float-right text-muted"><i class="far fa-clock"></i> Time Elapsed :  
                       <?php echo $diff->format(' Yrs : %Y , M : %m , Dys : %d , hrs : %h ,min : %i ,sec : %s') ?></small>
                      <span class="product-description">
                          <?php if($approval->isComplete()) : ?>
                           <?= $approval->getComment()->comment?> <br/>
                          <small><i class="far fa-clock"></i> Action Date: <?=$approval->completed_at ?></small>
                         <?php endif;?>
                      
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                
               
                <?php endforeach ;?>
                
               <?php echo '</ul>';  endif;?>
              </div>
              <!-- /.card-body -->
            </div>
     <?php echo  $i < $size ? '<small class="text-center"><i class="fas fa-long-arrow-alt-down text-info"></i></small>' :''; $i++; ?>        
            <?php endforeach ;?> 
  <?php endif ?>         
</div>         
</div>
</div>

          <?php
         



$script = <<< JS

$(document).ready(function()
 {
  
});

JS;
$this->registerJs($script);

?>


