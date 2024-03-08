<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<div class="RCR-notification">
     <p>Hello RAC ATC, AIM and other stakeholders,</p>
     <p>Here is the RCR Of <?= Html::encode($model->date) ?></p>
   <?php if($model->condition_status): ?>    

               
                            <h3 class="card-title"><i class="fa fa-file-o"></i><strong>RCR</strong></h3>
<table style="border: solid black 4px;">
<tr>
    <td colspan="2" ><h3  style="color:blue"><strong>RCR</strong></h3></td>
    <td class ="text-center" ><label> <mark><?= $model->aerodrome ?></mark></label>
            <p style="color:blue"><small>Aerodrome</small></p></td>
     <td colspan="2" class ="text-center" > <?php $date = new \DateTime($model->date);?>
           <label> <mark><?= $date->format('mdHi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p></td>
            
                 <td class ="text-center" colspan="2" ><label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p></td>
               <td class ="text-center" colspan="2" >
               <label> <mark>   <?php  
              foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
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
          </td>
               <td class ="text-center" colspan="2">
             <label> <mark>     <?php  
           foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
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
          </td>
           
           
             <td class ="text-center" colspan="2">
            <label> <mark>
             <?php  
             foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
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
          </td>
</tr>
<tr>
     <?php  
            foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
                        $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage,$report->rubber_deposit_status);
          ?>
    <td class ="text-center" colspan="4" >
        
               <p class="text-center"> 
               <?php 
        if($i!=1):
            ?>
        /
            <?php
            endif;
            ?><label> <mark>    <?= $condition->state ?>  </mark>  </label><br>
                  <span style="color:blue" class="text-center"><small>Contaminant Type <?= $report->segment->segment_name ?></small></span></p>
    </td>
     <?php endforeach ?>
</tr>
<tr class=" justify-content-md-center">
    <td colspan="3"><p class="text-right" style="color:blue"> Plain language remarks: </p></td>
    <td colspan="6" ><P> <label> <mark> <?= $model->awareness ?>  </mark>  </label></P></td>
    <td colspan="3">  <p class="text-center"><label> <mark>...................</mark>  </label><br>
            <span style="color:blue" class="text-center"><small>Reduced RWYWidth m(if Applicable)</small></span></p></td>
</tr>
</table>
<?php else: ?>  
   
               
                            <h3 class="card-title"><i class="fa fa-file-o"></i><strong>RCR</strong></h3>
<table  style="border: solid black 4px;">
<tr>
    <td><h3  style="color:blue" colspan="2"><strong>RCR</strong></h3></td>
    <td class ="text-center" ><label> <mark><?= $model->aerodrome ?></mark></label>
            <p style="color:blue"><small>Aerodrome</small></p></td>
     <td class ="text-center"  colspan="2"> <?php $date = new \DateTime($model->date);?>
           <label> <mark><?= $date->format('mdHi')  ?></mark></label>
            <p style="color:blue"><small>Date & Time</small></p></td>
            
                 <td class ="text-center" colspan="2" ><label> <mark> <?= $model->aerodromeinfo->lower_runway_designator ?></mark></label>
            <p style="color:blue"><small>RWY</small></p></td>
               <td class ="text-center"  colspan="2">
               <label> <mark>   <?php  
              foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
            if($i!=1):
            ?>
            /
            <?php
            endif;
            ?>
            6
          <?php endforeach ?>
          </mark></label>
          <p style="color:blue"><small>RWYCC</small></p>
          </td>
               <td class ="text-center"  colspan="2">
             <label> <mark>     <?php  
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
           <p style="color:blue"><small>% Coverage</small></p>
          </td>
           
           
             <td class ="text-center"  colspan="2">
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
          </td>
</tr>
<tr>
     <?php  
            foreach ( $segments as $i => $segment): 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $i])->orderBy('segment_id') ->one();
                       $condition ="DRY";
          ?>
    <td class ="text-center"  colspan="4">
               <p class="text-center">  <?php 
        if($i!=1):
            ?>
        /
            <?php
            endif;
            ?><label> <mark>    <?= $condition ?>  </mark>  </label><br>
                  <span style="color:blue" class="text-center"><small>Contaminant Type <?= $report->segment->segment_name ?></small></span></p>
    </td>
     <?php endforeach ?>
</tr>
<tr class=" justify-content-md-center">
    <td colspan="3"><p class="text-right" style="color:blue"> Plain language remarks: </p></td>
    <td colspan="6" ><P> <label> <mark> <?= $model->awareness ?>  </mark>  </label></P></td>
    <td colspan="3">  <p class="text-center"><label> <mark>...................</mark>  </label><br>
            <span style="color:blue" class="text-center"><small>Reduced RWYWidth m(if Applicable)</small></span></p></td>
</tr>
</table>
<?php endif; ?>
</div>
<br>
<p>
    This Report is created by <b><?=  $model->User()!=null? $model->User()->first_name ." ".$model->User()->last_name : ''; ?></b>. Please contact the person for more information.
</p>
