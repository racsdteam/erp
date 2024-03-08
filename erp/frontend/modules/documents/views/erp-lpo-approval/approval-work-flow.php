<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\User;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpLpoRequest;
use common\models\ErpMemo;
use yii\db\Query;

?>
<style>

.myDiv{
	display:none;
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
   <h3 class="card-title"><i class="fas fa-handshake"></i> Approvals   </h3>
 </div>
 <div class="card-body"> 
      <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
           
                <ul class="notice">
                    <li> Return :  Return  LPO Request e.g : request for correction,request for more info </li>
                     <li>Forward : Send   LPO Request to the next user for approval (For managers,Technicians & Officers)</li>
                     <li>Approve & Forward :  Approve  LPO Request and forward it (For Directors)</li>
                  </ul>
  
              </div>
 


<?php  


$user=Yii::$app->user->identity->user_id;
$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and  pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

$pos_level=$row7['level'];
$pos_code=$row7['position_code'];

$q9=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position,f.timestamp FROM user as u 
inner join  erp_lpo_approval_flow  as f on f.originator=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where f.lpo='".$lpo."' order by f.timestamp desc";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryAll();




//------------creator-----------------------------------------------//

$q10=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_lpo as f on f.created_by=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where f.id='".$lpo."'";
$command10= Yii::$app->db->createCommand($q10);
$row10 = $command10->queryOne();

$row9[]=$row10;

//-------------------end merging creator---------------------------------------------------------//

$employees=ArrayHelper::map($row9, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;

//--------------------all positions------------------------------------------------
$positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ;


$users=ArrayHelper::map(User::find()->all(), 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name'];
}) ;



                 $items=array();
                  $items['1']='Return';
                  
                  
                  if($row7['level']=='manager' || $row7['level']=='officer' || $row7['level']=='pa'  || ($row7['level']=='director') && $model1->status=='drafting'){
                      
                      $items['2']='Forward';
  
                         }
                 
                  if($row7['level']=='director' || ($row7['position_code']=='AAMD' && $row['categ_code']=='O')  || $row7['position_code']=='ITENG'){
                      
                      $items['3']='Approve & Forward';
  
                         }
                         
                         
                         
 $q77=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where p.position_code='ADVMD' and pp.status=1 ";
  $command77= Yii::$app->db->createCommand($q77);
  $row77 = $command77->queryOne();
  
  $date = date('Y-m-d');
  $date=date('Y-m-d', strtotime($date));
  
$row888 =Yii::$app->muser->getInterim($user,$row77['user_id'],$date);

//-------------------disable settings----------------------------------------------------------
if(in_array($pos_code,array('AAMD','DMD','ADVMD')) || $row888!= null){
    
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

                  echo $form->field($model, 'action')->inline(true)->radioList($items)->label(false);

   ActiveForm::end();
                            
 ?>                  
                  
      <div id="form1" class="myDiv">
	<h3>Select Next Recipient/Approver</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
        'options' => [
                'class' => 'lpo-approval'
             ],
         'action' => ['erp-lpo-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden" id="lpo" name="ErpLpoApproval[lpo]" value="<?php echo $lpo ?>">
    <input type="hidden" id="Action" name="ErpLpoApproval[action]" value="rfa">
    
    <div class="row">
        
        
    
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
         <?= $form->field($model, 'employee')->dropDownList($employees, 
	         ['prompt'=>'-Choose a employee-','class'=>['form-control select2 employee-select'],'id'=>'emp-0' ,
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
        'options' => [
                'class' => 'lpo-approval'
             ],
         'action' => ['erp-lpo-approval/work-flow'],
        'method' => 'post'
       ]);

?>

     
<div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-','class'=>[' form-control select2'],'id'=>'2',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>[' form-control select2 employee-select'],'id'=>'emp-2'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>

  <?= $form->field($model, 'lpo')->hiddenInput(['value'=>$lpo])->label(false);?>
<?= $form->field($model, 'action')->hiddenInput(['value'=>'cforward'])->label(false);?>

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
        'options' => [
                'class' => 'lpo-approval'
             ],
         'action' => ['erp-lpo-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    
    
  	<div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-','class'=>['form-control select2'],'id'=>'4',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>[' form-control select2 employee-select'],'id'=>'emp-4'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>
<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 <?= $form->field($model, 'lpo')->hiddenInput(['value'=>$lpo])->label(false);?>
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


 
 
 $(document).ready(function(){
    
    
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide().find('input:text,input:hidden, select').prop("disabled",true);;
        $("#form"+value).show().find('input:text,input:hidden, select').prop("disabled",false);
    });
    
   
    $(".select2").select2({width:'100%'});
      
 
 $('#work-form1').on('beforeSubmit', function (e) {
    
    
    
    if ($("#erpmemoapproval-remark").val().trim().length < 1) {
        
        swal("Error!", "please add remark for correction!", "error");
        return false;
    }
    return true;
});


 $('.lpo-approval ').on('beforeSubmit', function (e) {
    
      var values = $(this).serializeArray();
      
       if (values[2].value=="") {
        
       Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'No Employee Found For Selected Position!',
  
})
        return false;
    }
    
   
    return true;
});


 });
 



JS;
$this->registerJs($script);
?>
