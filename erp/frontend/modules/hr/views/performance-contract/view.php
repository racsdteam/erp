<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
use common\models\UserHelper;
use frontend\modules\hr\models\PcTargetMillstone;
use frontend\modules\hr\models\PcTarget;


$this->title = "Imihigo ".$model->financial_year;
$this->params['breadcrumbs'][] = ['label' => 'Draft Performance Appraisals', 'url' => ['draft']];
$this->params['breadcrumbs'][] = $this->title;
 if($model->position_level=="officer"){
$dataProvider = PcTarget::find()->where(["pa_id"=>$model->id])->all();
 }else{
   $organisationDataProvider = PcTarget::find()->where(["pa_id"=>$model->id,"type"=>"organisation level"])->all();  
   $departmentDataProvider = PcTarget::find()->where(["pa_id"=>$model->id,"type"=>"department level"])->all(); 
    $employeeDataProvider = PcTarget::find()->where(["pa_id"=>$model->id,"type"=>"employee level"])->all(); 
 }   
  $getOwner=function() use($model){
  
 if($model->user_id!=null){
     
    $user=UserHelper::getUserInfo($model->user_id) ;
   
    $pos=UserHelper::getPositionInfo($model->user_id);
  
    return $user['first_name']." ".$user['last_name']." / ".$pos['position'];  
 }
 else{
     
     return null;
 }
 
  
    
};


$attributes = [
   
   
    [
        
        'label'=>'Financial Year',
        'value'=>$model->financial_year ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        
        'label'=>'Employee',
        'value'=>$getOwner($model),
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    
    [  
        'label'=>'Position',
        'value'=>$model->emp_pos ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        
        'label'=>'Status ',
        'value'=>$model->status ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
   [
        
        'label'=>'Date Created',
        'value'=>$model->timestamp ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
  
];


$user=Yii::$app->user->identity->user_id;

?>
<div class="performance-appraisal-view">
<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i><?= $this->title ?></h6>
                     
                        </div>
                        
                        
                        <div class="card-body">
                            
    <?=  DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bsVersion'=>4,
    'bordered' =>false,
    'striped' =>false,
    'condensed' => true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'left',
    'vAlign'=>'middle',
    'fadeDelay'=>1000,
    'panel' => [
        'type' =>'default', 
        'heading' => '<h5><i class="fas fa-folder-open"></i>IMIHIGO Details</h5>',
       
    ],
    
     'buttons1' =>'',
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);
                  ?>
</div>
</div>

<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i><?= $this->title ?></h6>
                     
                        </div>
                        
                        
                        <div class="card-body"
  
    <p>
        <?= Html::a('Add Tagert', ['pc-target/create','id' => $model->id,'position_level' => $model->position_level], ['class' => 'btn btn-primary action-create','title'=>'Add Target.']) ?>
         <?php if($model->position_level!="officer"):?>
        <?= Html::a('Add Quarter Millstone', ['pc-target-millstone/create', 'id' => $model->id], ['class' => 'btn btn-primary action-create','title'=>'Add Target Millstone.']) ?>
        <?php endif; ?>
         
    </p>  
    <div class="table-responsive"> 
 <?php if($model->position_level=="officer"):?>
 <table class="table  table-bordered table-striped table-hover dataTable imihigo js-exportable ">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                      
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($dataProvider)){
                                    foreach($dataProvider as $modelTarget):
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr >
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$modelTarget->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td>
                                    <?= $modelTarget->output ?> 
                                    </td>    
                                    <td>
                                    <?= $modelTarget->indicator ?>
                                    </td>
                                    </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
  <?php else:  ?>
  
                        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
             
             
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-organisation-tab" data-toggle="pill" href="#custom-content-above-organisation" role="tab"  aria-controls="custom-content-above-organisation" aria-selected="true">
                   Organisation Level Tagerts
                 </a>
              </li>
             
               <li class="nav-item">
                <a class="nav-link" 
                id="custom-content-above-unity-tab" data-toggle="pill" href="#custom-content-above-unity" role="tab" aria-controls="custom-content-above-unity" aria-selected="true">
                   Departement Level Tagerts
                 </a>
              </li>
                <li class="nav-item">
                <a class="nav-link " id="custom-content-above-employee-tab" data-toggle="pill" href="#custom-content-above-employee" role="tab"  aria-controls="custom-content-above-employee" aria-selected="true">
                   Employee Level Tagerts
                 </a>
              </li>
            
            
            </ul>
                   <div class="tab-content" id="custom-content-above-tabContent">
       <div class="tab-pane fade  active show " id="custom-content-above-organisation" role="tabpanel"  aria-labelledby="custom-content-above-organisation-tab">
           
  <table class="table  table-bordered table-striped table-hover dataTable imihigo js-exportable ">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                        <th>Q1 Output(s) </th>
                                          <th>Q2 Output(s)</th>
                                            <th>Q3 Output(s)</th>
                                          <th>Q4 Output(s)</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($organisationDataProvider)){
                                    foreach($organisationDataProvider as $modelTarget):
                                    $q1_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q1"])->all();    
                                   $q2_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q2"])->all();    
                                   $q3_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q3"])->all();    
                                   $q4_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q4"])->all();    
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr >
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$modelTarget->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td>
                                    <?= $modelTarget->output ?> 
                                    </td>    
                                    <td>
                                    <?= $modelTarget->indicator ?>
                                    </td>
                                     <td>
                                  <?php if($q1_targets!=null):
                                         ?>
                                        <ul>
                                        <?php
                                      foreach($q1_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                      <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                    ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>
                                    </td>
                                    <td>
                                         <?php if($q2_millstones!=null):
                                        ?>
                                        <ul>
                                        <?php
                                      foreach($q2_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                  No Milleston 
                                  <?php endif; ?>   
                                    </td>  
                                    <td>
                                         <?php if($q3_millstones!=null):
                                              ?>
                                        <ul>
                                        <?php
                                      foreach($q3_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>        
                                    </td> 
                                     <td>
                                         <?php if($q4_millstones=null):
                                                 ?>
                                        <ul>
                                        <?php
                                      foreach($q4_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                   ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston
                                  <?php endif; ?>        
                                    </td>
                                
                                        </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
 </div>
      <div class="tab-pane fade"  id="custom-content-above-unity" role="tabpanel" aria-labelledby="custom-content-above-unity-tab">
  <table class="table  table-bordered table-striped table-hover dataTable imihigo js-exportable ">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                        <th>Q1 Output(s) </th>
                                          <th>Q2 Output(s)</th>
                                            <th>Q3 Output(s)</th>
                                          <th>Q4 Output(s)</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($departmentDataProvider)){
                                    foreach($departmentDataProvider as $modelTarget):
                                    $q1_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q1"])->all();    
                                   $q2_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q2"])->all();    
                                   $q3_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q3"])->all();    
                                   $q4_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q4"])->all();    
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr >
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$modelTarget->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td>
                                    <?= $modelTarget->output ?> 
                                    </td>    
                                    <td>
                                    <?= $modelTarget->indicator ?>
                                    </td>
                                     <td>
                                  <?php if($q1_targets!=null):
                                         ?>
                                        <ul>
                                        <?php
                                      foreach($q1_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                      <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                    ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>
                                    </td>
                                    <td>
                                         <?php if($q2_millstones!=null):
                                        ?>
                                        <ul>
                                        <?php
                                      foreach($q2_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                  No Milleston 
                                  <?php endif; ?>   
                                    </td>  
                                    <td>
                                         <?php if($q3_millstones!=null):
                                              ?>
                                        <ul>
                                        <?php
                                      foreach($q3_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>        
                                    </td> 
                                     <td>
                                         <?php if($q4_millstones=null):
                                                 ?>
                                        <ul>
                                        <?php
                                      foreach($q4_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                   ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston
                                  <?php endif; ?>        
                                    </td>
                                
                                        </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
 </div>
      <div class="tab-pane fade"  id="custom-content-above-employee" role="tabpanel" aria-labelledby="custom-content-above-employee-tab">
  <table class="table  table-bordered table-striped table-hover dataTable imihigo js-exportable ">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                        <th>Q1 Output(s) </th>
                                          <th>Q2 Output(s)</th>
                                            <th>Q3 Output(s)</th>
                                          <th>Q4 Output(s)</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($employeeDataProvider)){
                                    foreach($employeeDataProvider as $modelTarget):
                                    $q1_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q1"])->all();    
                                   $q2_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q2"])->all();    
                                   $q3_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q3"])->all();    
                                   $q4_millstones=PcTargetMillstone::find()->where(["target_id"=>$modelTarget->id, "quarter"=>"Q4"])->all();    
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr >
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$modelTarget->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td>
                                    <?= $modelTarget->output ?> 
                                    </td>    
                                    <td>
                                    <?= $modelTarget->indicator ?>
                                    </td>
                                     <td>
                                  <?php if($q1_targets!=null):
                                         ?>
                                        <ul>
                                        <?php
                                      foreach($q1_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                      <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                    ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>
                                    </td>
                                    <td>
                                         <?php if($q2_millstones!=null):
                                        ?>
                                        <ul>
                                        <?php
                                      foreach($q2_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                  No Milleston 
                                  <?php endif; ?>   
                                    </td>  
                                    <td>
                                         <?php if($q3_millstones!=null):
                                              ?>
                                        <ul>
                                        <?php
                                      foreach($q3_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     
                                     </li>
                                  <?php endforeach;
                                  ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston 
                                  <?php endif; ?>        
                                    </td> 
                                     <td>
                                         <?php if($q4_millstones=null):
                                                 ?>
                                        <ul>
                                        <?php
                                      foreach($q4_millstones as $millstone):
                                      ?>
                                     <li> <?= $millstone->millstone ?>
                                     
                                        <?=Html::a('<i class="fas fa-trash-alt" style="color:red"></i>',
                                             
                                             Url::to(["pc-target-millstone/delete",'id'=>$millstone->id])
                                          
                                          ,['class'=>'active delete-millstone-action','title'=>'Delete Target'] ); ?>
                                     </li>
                                  <?php endforeach;
                                   ?> 
                                  </ul>
                                  <?php
                                  else:
                                  ?> 
                                   No Milleston
                                  <?php endif; ?>        
                                    </td>
                                
                                        </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
 </div>
 </div>
  <?php endif ?>
</div>
</div>
</div>
 <p>
         <?= Html::a('View And Submit Imihigo PDF', ['performance-contract/view-pdf', 'id' => $model->id], ['class' => 'btn btn-info','title'=>'View Imihigo PDF.']) ?></p>
        <br>
<br>
</div>

          <?php


$script = <<< JS


 $( document ).ready(function($){

         var dTable=$('.imihigo').DataTable( {
        destroy: true,
       
});      
           
        });

 $('.delete-action').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Target will be Deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
 
});
  }
})

    return false;

});


 $('.delete-millstone-action').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "The Quater Millstone will be Deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
 
});
  }
})

    return false;

});


        
        

JS;
$this->registerJs($script,$this::POS_END);
?>