<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php 
include("boostrap-css.php");
?>
    <?php $this->head() ?>

</head>
<body>
     <?php $this->beginBody() ?>
     
<div class="RCR-notification">
     <p>Hello <?= Html::encode($recipient) ?>,</p>
     <p>Here is the RCR Of <?= Html::encode($model->date) ?></p>
   <?php if($model->condition_status): ?>    
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i><strong>RCR</strong></h3>
                       </div>
               
           <div class="card-body">
<div style="border: solid black 4px;">
    <div class= "row">
        <div class ="col-2 ">
            <h3  style="color:blue"><strong>RCR</strong></h3>
        </div>
        <div class ="col-1 text-center p-1">
           <label> <mark><?= $model->aerodrome ?></mark></label>
            <p style="color:blue"><small>Aerodrome</small></p>
            
        </div>
        <div class ="col-2 text-center p-1">
            <?php $date = new \DateTime($model->date);?>
            <label> <mark><?= $date->format('mdGi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p>
        </div>
        <div class ="col-1 text-center p-1">
           
            <label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p>
        </div>
        <div class ="col-2 text-center p-1">
         <label> <mark>   <?php  
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
           $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage);
           if($i!=0):
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
           if($i!=0):
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
           if($i!=0):
            ?>
            /
            <?php
            endif;
            if($report->assessed_depth >= 4 ):
            ?>
            <?= $report->assessed_depth ?>
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
                    $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage);
           if($i!=0):
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
            <label> <mark><?= $date->format('mdGi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p>
        </div>
        <div class ="col-1 text-center p-1">
           
            <label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p>
        </div>
        <div class ="col-2 text-center p-1">
         <label> <mark>   <?php  
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
                 $code=6;
           if($i!=0):
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
           if($i!=0):
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
           if($i!=0):
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
            $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
             foreach ( $segment_repots as $i => $report): 
                    $condition ="DRY";
                    
           if($i!=0):
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

<?php endif; ?>
</div>
 <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
