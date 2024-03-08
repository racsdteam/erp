<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpPersonsInPosition;
use common\models\UserHelper;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveRequest;
use frontend\modules\hr\models\LeaveApprovalList;
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
  
 <div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Work Flow Actions  </h3>
 </div>
 <div class="box-body"> 
      <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
           
                <ul class="notice">
                    <li> Return :  Return  Leave form e.g : request for request for more info </li>
                     <li>Send to Human Resource Office Or send to last Approval Level : This is option is used by staffs to sent the leave on HR office
                     Or to the last approval Level after making requested corrections.. </li>
                     <li>Send to Next Approval Level:   forward it to next approval Level</li>
                  </ul>
  
              </div>
 


<?php 
                              
$user=Yii::$app->user->identity->user_id;

$model1=LeaveRequest::find()->where(['id'=>$request,])->one();
                              
//--------------------all positions------------------------------------------------
$HRpositions=ArrayHelper::map(ErpOrgPositions::find()
                              ->where(['or',['report_to'=>'19'],['report_to'=>'29',]])
                              ->all(), 'id', 'position') ;
                              

//--------------------current Approval ------------------------------------------------
$user_approval =LeaveApprovalList::find()
                              ->where(['and',['approver'=>$user],['leave_request_id'=>$request,],['or',["approval_status"=>"declined"],["approval_status"=>"approved"]]])
                              ->one();
if($model1->status=="HR Office"||$model1->status=="drafting")
{                              
//--------------------next Approval ------------------------------------------------
$next_approval =LeaveApprovalList::find()
                              ->where(['and',['leave_request_id'=>$request,],["approval_status"=>"no action"]])
                              ->one();    
}
else{
  //--------------------next Approval ------------------------------------------------
$next_approval =LeaveApprovalList::find()
                              ->where(["and",['>','id',$user_approval->id],["approval_status"=>"no action"],['leave_request_id'=>$request,]])
                              ->one();     
}
$next_approver= UserHelper::getUserInfo($next_approval->approver);

$next_position=ErpOrgPositions::find()->where(["id"=>(int) $next_approval->position])->one();
$next_person_in_position=ErpPersonsInPosition::find()->where(["position_id"=>$next_position->id])->one();
 $next_department=ErpOrgUnits::find()->where(["id"=>$next_person_in_position->unit_id])->one();

$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."'";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();
$row9=array();
$q99=" SELECT DISTINCT  originator FROM leave_approval_flow where request='".$request."' order by timestamp desc";
$command99= Yii::$app->db4->createCommand($q99);
$rows99 = $command99->queryAll();
foreach($rows99 as $row99)
{
$q9=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where u.user_id='".$row99['originator']."'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryAll();
}

$employees=ArrayHelper::map($row9, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;

//------------creator-----------------------------------------------//
$q99=" SELECT * FROM leave_request where id='".$request."' order by timestamp desc";
$command99= Yii::$app->db4->createCommand($q99);
$row99 = $command99->queryOne();

$q10=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where u.user_id='".$row99['user_id']."'";
$command10= Yii::$app->db->createCommand($q10);
$row10 = $command10->queryOne();







                 $items=array();
                 if ($row99['status']=="drafting"){
                  $items['1']='Send to Human Resource Office Or The last approval level';
                 }else{
                      $items['2']='Return';
                      $items['3']='Send to Next Approval Level Or Next Office';
  
                         
                 }
if( $row7['position_code']=='AAMD' || $row7['position_code']=='DMD'){
    
    $disabled=false;
}else{
    
    $disabled=true;
}



?>

                         <?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);

                  echo $form->field($model, 'approval_action')->radioList($items)->label(false);

   ActiveForm::end();
                            
 ?>                  
                   
<!--  --------------------------Send to Hr Office------------------------------------------------------>
        <div id="form1" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['leave-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden"  name="LeaveApproval[request]" value="<?php echo $request ?>">
    <input type="hidden"  name="LeaveApproval[approval_action]" value="hroffice">

<?php if(!empty($next_approver['first_name'] ))
{
?>

    <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-success text-lg">
                          Next
                        </div>
                      </div>
                   
                      Name: <br /> <?= $next_approver['first_name'] ?>  <?= $next_approver['last_name'] ?><br />
                      <small>Position:<br> <?= $next_position->position ?> <br> Unit / Department/ Office :<br><?= $next_department->unit_name ?></small>
                    </div>
                  </div>
                     <?= $form->field($model, 'employee')->hiddenInput(['value'=>$next_approval->approver])->label(false);?>
<?php }else{
?> 
 <div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($HRpositions, 
	         ['prompt'=>'-Choose a position-','class'=>['Select2 form-control select2'],'id'=>'1',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-1',])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>
      <?php
}
?>     
   

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 
<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Send To HR Office ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>                       
<!--  --------------------------Retrun------------------------------------------------------>
      <div id="form2" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['leave-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden"  name="LeaveApproval[request]" value="<?php echo $request ?>">
    <input type="hidden" name="LeaveApproval[approval_action]" value="rfa">
    
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

    <div id="form3" class="myDiv">
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['leave-approval/work-flow'],
        'method' => 'post'
       ]);

?>
<div class="row">
<?php if(!empty($next_approver['first_name'] ))
{
?>

    <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-success text-lg">
                          Next
                        </div>
                      </div>
                   
                      Name: <br /> <?= $next_approver['first_name'] ?>  <?= $next_approver['last_name'] ?><br />
                      <small>Position:<br> <?= $next_position->position ?> <br> Unit / Department/ Office :<br><?= $next_department->unit_name ?></small>
                    </div>
                  </div>
                     <?= $form->field($model, 'employee')->hiddenInput(['value'=>$next_approval->approver])->label(false);?>
<?php }else{
    ?>
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
       <?= $form->field($model, 'employee')->dropDownList($employees, 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-0' ,])->label('Employee Name (user the memo passed through)'); ?> 
        </div>
    <?php
}
?>
</div>


<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>

  <?= $form->field($model, 'request')->hiddenInput(['value'=>$request])->label(false);?>
<?= $form->field($model, 'approval_action')->hiddenInput(['value'=>'cforward'])->label(false);?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  
 
              </div>

 </div>




          <?php

$script1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         
          $('#emp-'+id).html(data);
    });
   
}



JS;
$this->registerJs($script1,$this::POS_HEAD);
$url=Url::to(['../doc/erp-persons-in-position/get-employee-names']); 

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
