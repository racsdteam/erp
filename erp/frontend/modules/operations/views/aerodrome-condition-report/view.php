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
/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeConditionReport */

$this->title =  "Runway Condition Report On ".$model->date;
$this->params['breadcrumbs'][] = ['label' => 'Aerodrome Condition Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$segments=AerodromeSegment::find()->where(["aerodrome"=>$model->aerodrome])->all();
$current_user=Yii::$app->user->identity->user_id;
?>
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');
echo $msg;
   echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 3000
                  })";
  echo '</script>';
 
  ?>
    <?php endif; ?>
<div class="aerodrome-condition-report-view">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
                       <div class="card-body">
<?php
if($model->status==AerodromeConditionReport::NOT_SHARED):
?>
<div class="float-right">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this RCR?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </div>
    <?php
    endif;
    ?>

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
            'aerodrome',
            'date',
                 [
                 'label'=>'Is more than 25% of any runway third surface wet or contaminated?',
                 'value'=>call_user_func(function ($data) {
                     if($data)
                     return "Yes";
                     else
                     return "No";
            }, $model->condition_status),
                 
                
                ],
                
            'awareness:ntext',
        ],
    ]) ?>
</div>
</div>
</div>
</div>

<?php if( empty($model->segmentreports) && $model->condition_status): ?>

         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i>Segment Report</h3>
                       </div>
               
           <div class="card-body">
  <?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
    'id'=>'dynamic-form',
      'action' => ['add-segment-report','id'=>$model->id],
    'enableClientValidation'=>true,
    'enableAjaxValidation' => false,
    'method' => 'post',
                               ]); ?>                              

   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="4">
        
   <h4 style="display:inline;" class="card-title"><i class="fa fa-cart-arrow-down"></i>Segments Report</h4>

    </th>
    
   
                
            </tr>
            <tr>
                
                  <th   class="text-center" style="width:20%;">Segment</th>
                 <th>Assessed Water Depth in mm</th>
                <th>Coverage Percentage</th>
                <th>Is there Rubber Deposit?</th>
               
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($segments as $i => $segment): ?>
            <tr class="item">
         <td class="text-center" style="width:20%;">
                       <b><?= $segment->segment_name ?></b>
                    <?= $form->field($aerodromeSegmentReport, "[{$i}]segment_id")->hiddenInput(['value'=>$segment->id])->label(false); ?>
                  
                </td>

                 <td>
                    
                    <?=  
                 $form->field($aerodromeSegmentReport, "[{$i}]assessed_depth")->textInput()->label(false)
                 ?> 
                </td>
                <td>
                    
                    <?=  
                 $form->field($aerodromeSegmentReport, "[{$i}]coverage_percentage")
                 ->dropDownList(["NR"=>"NR","25"=>"25","50"=>"50","75"=>"75","100"=>"100",],['prompt'=>'Select type...','class'=>['Select2']])->label(false)
                 ?> 
                </td>
                <td>
                    
                    <?=  
                 $form->field($aerodromeSegmentReport, "[{$i}]rubber_deposit_status")
                 ->dropDownList(["0"=>"No","1"=>"yes",],['prompt'=>'Select type...','class'=>['Select2']])->label(false)
                 ?> 
                </td>
                
              
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
   </div> 

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
           
                </div>
</div>
</div>

<?php elseif($model->condition_status): ?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i>Segment Report</h3>
                       </div>
               
           <div class="card-body">
 
   
    
    <div class="table-responsive">
     <table style="width:100%" class="table table-bordered table-striped">
        <thead>
            <tr>
                
                  <th   class="text-center" style="width:20%;">Segment</th>
                  <th   class="text-center" style="width:20%;">RWYC</th>
                  <th   class="text-center" style="width:20%;">Contaminat Type</th>
                 <th>Assessed Water Depth in mm</th>
                <th>Coverage Percentage in percentage</th>
                <th>Is there Rubber Deposit?</th>
            </tr>
        </thead>
        <tbody>
       <?php 
       $segment_repots= $model->getSegmentreports()->orderBy('segment_id') ->all();
       foreach ( $segment_repots as $i => $report): 
       $condition = $report->getRunwayCondition( $report->assessed_depth,$report->coverage_percentage,$report->rubber_deposit_status);
       ?>
            <tr>
         <td class="text-center" style="width:20%;">
                     <?= $report->segment->segment_name ?>
                </td>
 <td class="text-center" style="width:20%;">
                     <?= $condition->code ?>
                </td>
                 <td class="text-center" style="width:20%;">
                     <?= $condition->state ?>
                </td>
                 <td>
                    <?= $report->assessed_depth ?>
                </td>
                <td>
                     
                <?= $report->coverage_percentage ?>
                </td>
                <td>
                   <?=  $report->rubber_deposit_status ? "Yes" : "NO" ?>  
                </td>
                
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
   </div> 
           
                </div>
</div>
</div>
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
              $i=0;
         foreach ( $segments as $segment): 
            $i++;
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id])->orderBy('segment_id')->one();
                 
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
             $i=0;
         foreach ( $segments as $segment): 
            $i++;
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id ])->orderBy('segment_id')->one(); 
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
             $i=0;
         foreach ( $segments as $segment): 
            $i++;
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id])->orderBy('segment_id')->one(); 
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
               $i=0;
         foreach ( $segments as $segment): 
            $i++;
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id ])->orderBy('segment_id')->one();
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
<?php 
if($current_user==$model->user_id):
?>
<div class="card-footer">
    <?=Html::a('<i class="fa fa-archive"></i> Share RCR ',
                                              Url::to(["aerodrome-condition-report/share",'id'=>$model->id,
                                           ])
                                          ,['class'=>'btn-success btn-sm active share-action','title'=>'Share RCR'] ); ?> 
</div>
<?php
endif;
?>
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
             $i=0;
         foreach ( $segments as $segment): 
            $i++;
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id ])->orderBy('segment_id') ->one();
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
             $i=0;
         foreach ( $segments as $segment): 
            $i++; 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id])->orderBy('segment_id') ->one();
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
            $i=0;
         foreach ( $segments as $segment): 
            $i++; 
                 
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id])->orderBy('segment_id') ->one();
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
          $i=0;
         foreach ( $segments as $segment): 
            $i++;     
                 $report = $model->getSegmentreports()->where(["segment_id"=> $segment->id])->orderBy('segment_id') ->one(); 
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
<?php 
if($current_user==$model->user_id):
?>
<div class="card-footer">
    <?=Html::a('<i class="fa fa-archive"></i> Share RCR ',
                                              Url::to(["aerodrome-condition-report/share",'id'=>$model->id,
                                           ])
                                          ,['class'=>'btn-success btn-sm active share-action','title'=>'Share RCR'] ); ?> 
</div>
<?php
endif;
?>
</div>
</div>
<?php endif; ?>
</div>



        <?php
   
$script = <<< JS


 $('.share-action').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This RCR will be share to all stakeholders!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, share  it!'
}).then((result) => {
  if (result.value) {
   $.post(url, function(data) {
        console.log("yes")
 
});
  }
})

    return false;

});

JS;
$this->registerJs($script);

?>