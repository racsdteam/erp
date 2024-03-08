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
use common\models\RequestApproval;
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
  
 <div class="card ">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i> Work Flow Actions  </h3>
 </div>
 <div class="card-body text-dark"> 
      <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
           
                <ul class="notice">
                    <li> Return :  Return  Stock voucher  e.g : request for correction,request for more info </li>
                     <li>Forward : Send  Stock voucher  to the next user for approval (For managers,Technicians & Officers)</li>
                     <li>Approved and Forward:  Approve   Stock voucher  and forward it (For Directors)</li>
                  </ul>
  
              </div>
 


<?php  


$user=Yii::$app->user->identity->user_id;
$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();


$row9=array();
$q99=" SELECT DISTINCT(originator),timestamp FROM request_approval_flow where request='".$request."' order by timestamp desc";
$command99= Yii::$app->db1->createCommand($q99);
$rows99 = $command99->queryAll();
foreach($rows99 as $row99)
{
$q9=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where u.user_id='".$row99['originator']."'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryAll();
}


//------------creator-----------------------------------------------//
$q99=" SELECT DISTINCT(staff_id),timestamp FROM request_to_stock where reqtostock_id='".$request."' order by timestamp desc";
$command99= Yii::$app->db1->createCommand($q99);
$row99 = $command99->queryOne();

$q10=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where u.user_id='".$row99['staff_id']."'";
$command10= Yii::$app->db->createCommand($q10);
$row10 = $command10->queryOne();


 $q77=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position_code='DAF' and pp.status=1";
  $command77= Yii::$app->db->createCommand($q77);
  $row77 = $command77->queryOne();

  $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
$row8 = Yii::$app->muser->getInterim($user,$row77['user_id'],$approvalDate);


$employees=ArrayHelper::map($row9, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;

//--------------------all positions------------------------------------------------
$positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ;





                 $items=array();
                  $items['1']='Return';
        if($row7['position_code']!= 'DAF'){
                      $items['2']=' Forward';
        }
                  if($row7['position_code']=='DAF'   || $row7['position_code']=='ITENG' ||  $row8 != null){
                      
                      $items['3']='Approve & Forward';
  
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
                  
      <div id="form1" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['request-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden" id="lpo" name="RequestApproval[request]" value="<?php echo $request ?>">
    <input type="hidden" id="Action" name="RequestApproval[approval_action]" value="rfa">
    
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
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['request-approval/work-flow'],
        'method' => 'post'
       ]);

?>

     
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
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-2' ,])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>

  <?= $form->field($model, 'request')->hiddenInput(['value'=>$request])->label(false);?>
<?= $form->field($model, 'approval_action')->hiddenInput(['value'=>'cforward'])->label(false);?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['request-approval/work-flow'],
        'method' => 'post'
       ]);

?>

<div class="row">
    
    <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
        <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-','class'=>['Select2 form-control select2'],'id'=>'3',
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]
			  
			  ]
			  
			  
			  
			  ])->label('Select Employee Position'); ?>  
        
    </div>
    
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-3'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>
<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 <?= $form->field($model, 'request')->hiddenInput(['value'=>$request])->label(false);?>
 <?= $form->field($model, 'approval_action')->hiddenInput(['value'=>'approve'])->label(false);?>
<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?>
</div> 
 
              </div>

 </div>




          <?php
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
