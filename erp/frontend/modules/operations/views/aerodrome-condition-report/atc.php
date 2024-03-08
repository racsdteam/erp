<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\modules\operations\models\AerodromeSegment;
use frontend\modules\operations\models\AerodromeConditionReport;
use frontend\modules\operations\models\AerodromeConditionType;

$this->context->layout='signup';
/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeConditionReport */

$this->title =  "Runway Condition Report On ".$model->date;
$this->params['breadcrumbs'][] = ['label' => 'Aerodrome Condition Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$segments=ArrayHelper::map(AerodromeSegment::find()->where(["aerodrome"=>$model->aerodrome])->all(), 'id','segment_name') ;
$current_user=Yii::$app->user->identity->user_id;
?>

<h2>Runway Conditions Reports ICAO Gobal Format</h2>
<div class="aerodrome-condition-report-view">

<?php if($model->condition_status): ?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i><strong>RCR</strong></h3>
                       </div>
               
           <div class="card-body">
<div style="border: solid black 4px;">
    <div class= "row">
        <div class ="col-2">
            <h3  style="color:blue"><strong>RCR</strong></h3>
        </div>
        <div class ="col-1 text-center p-1">
           <label> <mark><?= $model->aerodrome ?></mark></label>
            <p style="color:blue"><small>Aerodrome</small></p>
            
        </div>
        <div class ="col-2 text-center p-1">
            <?php $date = new \DateTime($model->date);?>
            <label> <mark><?= $date->format('mdHi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p>
        </div>
        <div class ="col-1 text-center p-1">
           
            <label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p>
        </div>
        <div class ="col-2 text-center p-1">
         <label> <mark>   <?php  
             foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id')->one();
                 
           $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage,$report->rubber_deposit_status);
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            <?= $condition->code ?>
          <?php endforeach ?>
          </mark></label>
          <p style="color:blue"><small>RWYCC</small></p>
        </div>
        
        <div class ="col-2 text-center p-1">
          <label> <mark>     <?php  
            foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id')->one(); 
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            <?= $report->coverage_percentage ?>
          <?php endforeach ?>
          </mark></label>
           <p style="color:blue"><small>% Coverage</small></p>
        </div>
        <div class ="col-2 text-center p-1">
             <label> <mark>
             <?php  
             foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id')->one(); 
           if($i!=1):
            ?>
            /
            <?php
            endif;
            if($report->assessed_depth >= 4 ):
            ?>
        <?=  sprintf("%02d", $report->assessed_depth );?>
            <?php else: ?>
            NR
            <?php endif; ?>
          <?php endforeach ?>
           </mark></label>
           <p style="color:blue"><small>Depth in mm</small></p>
        </div>
   
    
    </div>
    
    <div class="row justify-content-md-center">
          <?php  
              foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id')->one();
                    $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage,$report->rubber_deposit_status);
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
             <div class ="col-3 p-1">
               <p class="text-center"><label> <mark>    <?= $condition->state ?>  </mark>  </label><br>
                  <span style="color:blue" class="text-center"><small>Contaminant Type <?= $report->segment->segment_name ?></small></span></p>
                 </div>
    <?php endforeach ?>
    </div>
    
    
    <div class="row">
        <div class="col-3 p-1">
            <p class="text-right" style="color:blue"> Plain language remarks: </p>
        </div>
        <div class ="col-6 p-1">
         <P> <label> <mark> <?= $model->awareness ?>  </mark>  </label></P>
    </div>
    <div class="col-3 text-center p-1 ">
            <p class="text-center"><label> <mark>...................</mark>  </label><br>
            <span style="color:blue" class="text-center"><small>Reduced RWYWidth m(if Applicable)</small></span></p>
        </div>
    </div>
    
</div>
           
</div>

</div>
</div>
<?php else: ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i><strong>RCR</strong></h3>
                       </div>
               
           <div class="card-body">
<div style="border: solid black 4px;">
    <div class= "row">
        <div class ="col-2">
            <h3  style="color:blue"><strong>RCR</strong></h3>
        </div>
        <div class ="col-1 text-center p-1">
           <label> <mark><?= $model->aerodrome ?></mark></label>
            <p style="color:blue"><small>Aerodrome</small></p>
            
        </div>
        <div class ="col-2 text-center p-1">
            <?php $date = new \DateTime($model->date);?>
            <label> <mark><?= $date->format('mdHi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p>
        </div>
        <div class ="col-1 text-center p-1">
           
            <label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p>
        </div>
        <div class ="col-2 text-center p-1">
         <label> <mark>   <?php  
            
             foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
                 $code=6;
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            <?= $code ?>
          <?php endforeach ?>
          </mark></label>
          <p style="color:blue"><small>RWYCC</small></p>
        </div>
        
        <div class ="col-2 text-center p-1">
          <label> <mark>     <?php  
            foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            <?= "NR" ?>
          <?php endforeach ?>
          </mark></label>
           <p style="color:blue"><small>% Coverage</small></p>
        </div>
        <div class ="col-2 text-center p-1">
             <label> <mark>
             <?php  
            foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            NR
          <?php endforeach ?>
           </mark></label>
           <p style="color:blue"><small>Depth in mm</small></p>
        </div>
   
    
    </div>
    
    <div class="row justify-content-md-center">
          <?php  
         foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one(); 
                    $condition ="DRY";
                    
           if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
             <div class ="col-3 p-1">
               <p class="text-center"><label> <mark>    <?= $condition ?>  </mark>  </label><br>
                  <span style="color:blue" class="text-center"><small>Contaminant Type <?= $report->segment->segment_name ?></small></span></p>
                 </div>
    <?php endforeach ?>
    </div>
    
    
    <div class="row">
        <div class="col-3 p-1">
            <p class="text-right" style="color:blue"> Plain language remarks: </p>
        </div>
        <div class ="col-6 p-1">
         <P> <label> <mark> <?= $model->awareness ?>  </mark>  </label></P>
    </div>
    <div class="col-3 text-center p-1 ">
            <p class="text-center"><label> <mark>...................</mark>  </label><br>
            <span style="color:blue" class="text-center"><small>Reduced RWYWidth m(if Applicable)</small></span></p>
        </div>
    </div>
    
</div>
           
</div>
</div>
</div>
<?php endif; ?>
</div>



        <?php
  $ckeckUrl=Url::to(["check-last-report", "aerodrome"=>$model->aerodrome]); 
$script = <<< JS
var current_id= $model->id ;
var checkUrl ="$ckeckUrl"; 
$(function(){
  // Backbone code in here
  setInterval(function(){
        $.ajax({
                              url : checkUrl,
                              type: 'GET',
                          }).done(function(success){
                            var res = JSON.parse(success);
                          if(res.id!=current_id)
                          {
                    
                             Swal.fire({
                            position: 'center',
                         icon: 'warning',
                  title: 'The RCR has Changed',
                 showConfirmButton: false,
                 timer: 3000
                  });
                             location.reload();
                          }
                          }).fail(function(error){
                              console.log(error)
                          });
      
  }, 3000);
});


JS;
$this->registerJs($script);

?>