<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

use kartik\select2\Select2;

use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpRequisition;
use common\models\ErpMemo;
use yii\db\Query;

?>
<style>

.myDiv{
	display:none;
}



#erpmemoapproval-action label:not(:first-child){
    margin:0 10px;
}
/*styling dropdown selected otptios*/

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc !important;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px;
    color: rgba(255,255,255,0.7) !important;
}

ul.notice li{
 font-size:16px;
}
ul li.interim{
    background-color:yellow;
}

</style>




<?php  
  $user=Yii::$app->user->identity;
  
  ?>

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>
  
 <div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-tag"></i> Work Flow Actions  </h3>
 </div>
 <div class="card-body"> 
  
    <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
           
                <ul class="notice">
                    <li> Return :  Return  Purchase Requisition e.g : request for correction,request for more info </li>
                     <li>Forward : Send  Purchase Requisition to the next user for approval (For managers,Technicians & Officers)</li>
                     <li>Approve & Forward :  Approve  Purchase Requisition and forward it (For Directors)</li>
                  </ul>
  
              </div>

<?php

    
   
 $model1=ErpRequisition::find()->where(['id'=>$requisition_id])->one(); 
 
 
       
$user=Yii::$app->user->identity->user_id;
$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and  pp.status=1  order by pp.id desc";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

   $pos_level=$row7['level'];
$pos_code=$row7['position_code']; 
//--------------------all positions------------------------------------------------
$positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ;

//-----------------------all users in memo approval flow--------------------------------------------
$q8=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position,f.timestamp FROM user as u 
inner join erp_requisition_approval_flow  as f on f.originator=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where f.pr_id='".$requisition_id."'  order by f.timestamp desc";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryAll();

//------------creator-----------------------------------------------//

$q9=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_requisition as r on r.requested_by=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where r.id='".$requisition_id."'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne();

$row8[]=$row9;

//-------------------end merging creator---------------------------------------------------------//

$employees=ArrayHelper::map($row8, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;

//var_dump($row8);

 $q77=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where p.position_code='ADVMD' and pp.status=1";
  $command77= Yii::$app->db->createCommand($q77);
  $row77 = $command77->queryOne();
  
  $date = date('Y-m-d');
  $date=date('Y-m-d', strtotime($date));
  
$row888 =Yii::$app->muser->getInterim($user,$row77['user_id'],$date);

//-------------------disable settings----------------------------------------------------------
if(in_array($pos_code,array('AAMD','DMD','ADVMD')) || $row888 != null){
    
    $disabled=false;
}else{
    
    $disabled=true;
}


?>


<?php 

                  $items=array();
                  $items['1']='Return';
                  
                  
                  if($row7['level']=='manager' || $row7['level']=='officer' || $row7['level']=='pa'  || ($row7['level']=='director') && $model1->approve_status=='drafting'){
                      
                      $items['2']='Forward';
  
                         }
                 
                  if($row7['level']=='director' || ($row7['position_code']=='AAMD' && $row['categ_code']=='O')  || $row7['position_code']=='ITENG'){
                      
                      $items['3']='Approve & Forward';
  
                         }
                           $form = ActiveForm::begin([
        'id'=>'action-form1',
    
       ]);
                  echo $form->field($model, 'action')->radioList($items)->label(false);
                  
                  ?>




<?php
   ActiveForm::end();
                            
 ?>                  
                  
            
              <div id="form1" class="myDiv">
	<h3>Select Next Recipient/Approver</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['erp-requisition-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden" id="requisition_id" name="ErpRequisitionApproval[requisition_id]" value="<?php echo $requisition_id ?>">
    <input type="hidden" id="Action" name="ErpRequisitionApproval[action]" value="rfa">
    
    <div class="row">
        
        
    
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
         <?= $form->field($model, 'employee')->dropDownList($employees, 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-0' ,
			  'onchange'=>'
			'])->label('Employee Name (user the memo passed through)'); ?> 
        
    </div>
        
    </div>
    

    
     
 
 
  	

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 
<?= Html::submitButton('<i class="fa fa-mail-reply-all"></i> Return ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>    
                        
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Next Recipient/Approver</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-requisition-approval/work-flow'],
        'method' => 'post'
       ]);

?>
  

   <input type="hidden" id="ReqId" name="ErpRequisitionApproval[requisition_id]" value="<?php echo $requisition_id ?>">
   <input type="hidden" id="Action" name="ErpRequisitionApproval[action]" value="cforward">
     
    <div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-','class'=>['Select2 form-control select2'],'id'=>'2',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-2' ,
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Next Recipient/Approver</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['erp-requisition-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    
<div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-','class'=>['Select2 form-control select2'],'id'=>'4',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-4' ,
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 <?= $form->field($model, 'requisition_id')->hiddenInput(['value'=>$requisition_id])->label(false);?>
 <?= $form->field($model, 'action')->hiddenInput(['value'=>'approve'])->label(false);?>
<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?>
</div> 
 
              </div>

 </div>





          <?php
$url=Url::to(['erp-persons-in-position/get-employee-names']); 

$script1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         
          $('#emp-'+id).html(data);
    });
   
}



JS;
$this->registerJs($script1,$this::POS_HEAD);


$script = <<< JS

$('#work-form1').on('beforeSubmit', function (e) {
    
    
    
    if ($("#erpmemoapproval-remark").val().trim().length < 1) {
        
        swal("Error!", "please add remark for correction!", "error");
        return false;
    }
    return true;
});
 
 
 $(document).ready(function(){
    
    
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });
    
    $('.Select2').select2({width:'100%'})
     $('.select2').select2({width:'100%'})
 
 });
 



JS;
$this->registerJs($script);
?>
