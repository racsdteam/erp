<?php



use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
use common\models\ErpRequisition;
use common\models\ErpMemo;
use common\models\ErpMemoCateg;
use common\models\ErpMemoApprovalSettings;
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
 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
     $user=Yii::$app->user->identity;
  
  ?>

  
 <div class="card card-default  ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-fa-gavel"></i> Submit for Approval  </h3>
 </div>
 <div class="card-body text-dark">
     
     <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
                <ul class="notice">
                    <li> Return :  Return the memo e.g : request for correction,request for more info </li>
                     <li>Forward : Send the memo to the next user for approval (For managers,Technicians & Officers)</li>
                     <li>Approve & Forward :  Approve the memo and forward it (For Directors) </li>
                  </ul>
                
  
              </div> 
 



<?php
$approval=ErpMemoApprovalSettings::findByMemo($memo_id);
$model1=ErpMemo::find()->where(['id'=>$memo_id])->One();
$model2=ErpMemoCateg::find()->where(['id'=>$model1->type])->One();
$user=Yii::$app->user->identity->user_id;
$final_app=empty($approval)? null:$approval->final_approver;
$is_final_app= empty($approval)? false : $approval->isFinalApprover($user);



//------------current approval-------------------------------------------------------------------------
$q10=" SELECT *  FROM erp_memo_approval_flow  where memo_id='".$model1->id."' ORDER BY 	timestamp desc ";
$command = Yii::$app->db->createCommand($q10);
$rows10 = $command->queryOne();




$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."'  and  pp.status=1 order by pp.id desc";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

$pos_level=$row7['level'];
$pos_code=$row7['position_code'];



    
//--------------------all positions------------------------------------------------
$positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ;

//-----------------------all users in memo approval flow--------------------------------------------
$q8=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position,f.timestamp FROM user as u 
inner join erp_memo_approval_flow as f on f.originator=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where f.memo_id='".$memo_id."' order by f.timestamp desc";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryAll();

//------------creator-----------------------------------------------//

$q9=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_memo as m on m.created_by=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where m.id='".$memo_id."'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne();

$row8[]=$row9;



//-------------------end merging creator---------------------------------------------------------//
$employees=ArrayHelper::map($row8, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;


 $q77=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position_code='ADVMD' and pp.status=1";
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


 
 
 $approvalDate = date('Y-m-d');
 $approvalDate=date('Y-m-d', strtotime($approvalDate));
 
 //------------interim for approver 
$q9="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$final_app."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 




//----------------------------manager can approve in case of interim------------------------------------
if(!empty($row9) && $pos_level!='director'){
    
   $pos_level='director';
}



  $items=array();
                  $items['1']='Return';
                  
                  
                  if(!$is_final_app && ($pos_level=='manager' || $pos_level=='officer' || $pos_level=='pa'  || ($pos_level=='director' && $model1->status=='drafting'))){
                      
                       
                   
                   
                   $items['2']=' Forward';   
                      
                 
                  }
  
                         
                  if(
                    $is_final_app
                   ||$pos_level=='director' 
                   || ($row7['position_code']=='AAMD' && $model2->categ_code=='O')  
                   || Yii::$app->user->identity->isAdmin() ){
                      
                      $items['3']='Approve & Forward';
  
                         }

?>



<?php 

    $form = ActiveForm::begin([
        'id'=>'request-approval-form',
    
       ]);   ?>
       
                 <input type="hidden" id="MemoId" name="ErpMemoApproval[memo_id]" value="<?php echo $memo_id ?>">
                 <?=$form->field($model, 'action') ->inline(true)->radioList($items)->label(false) ?>


              <div id="form1" class="myDiv">
	<h3>Select Recipient/Approver </h3>

    
    <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="rfa">
    
    <div class="row text-black">
        
        
    
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
         <?= $form->field($model, 'employee')->dropDownList($employees, 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-0' ,
			  'onchange'=>'
			'])->label('Employee Name (user the memo passed through)'); ?> 
        
    </div>
        
    </div>
    
  <?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 
 <?= Html::Button('<i class="fas fa-undo"></i> Send Back', ['class' => 'btn btn-warning btn-submit']) ?>



</div>    
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	

  
    
     <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="cforward">

   <?php if($model1->status=='drafting' &&  $model1->created_by==$user)  :?>
  
 
   
   <div  class="row bg-green">   

     <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12 ">
         
          <h3 style="display: inline;"><b>Final Approver : </b></h3> (<em>Select who should approve this Memo</em>) 
     </div>
     
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6 input">
     <?= $form->field($model0, 'approver_position')->dropDownList($positions, 
	         ['prompt'=>'-Choose an option-','class'=>['Select2 form-control select2'],'id'=>'10',
			   'onchange'=>'getEmployee(this.value,this.id)'])->label('Select Employee Position'); ?>   
      
  </div>
  
  <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6 input">
   <?= $form->field($model0, 'approver_name')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-10' ,
			  'onchange'=>'
			'])->label('Final Approver Name (automatically filled in)'); ?>	   
      
  </div>
      
      
  </div>
  
  
  <?php endif?>
  
  
    
    
      <!-- -------------------------manager can send directly the director for purchase requisition----------------------------------------------------------------->
  
  <?php if(($pos_level=='manager' && $model2->categ_code=='PR') && ($model1->status=='drafting' || $model1->status=='returned' ))
  
  :?>
  
  <!--- -------nothing-------------------> 
   <?php echo $pos_level ?>
  
  <?php  else : ?>
  
  
  
  <?php if(($model1->status=='drafting' &&  $model1->created_by==$user) && $pos_level!='director')  :?>
  
   <br/>
   <div class="row bg-primary">
       
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
       
        <h3 style="display: inline;" > <b>Through :  </b></h3> (<em>Select Through who the Memo Should Pass</em>)
   </div>
        
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
   
   <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-',
	         'class'=>['Select2 form-control select2'],
	         'id'=>'14',
	         
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' => $disabled ]
			  
			  ]
			  ])->label('Select Employee Position'); ?>    
      
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      
      
  <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-14',
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>                
                    
      
  </div>
  </div>
  
  <?php endif;?>
  
   <?php  if($rows10['approver']==$user): ?>
   
     <div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <h3 class="text-dark">Select Next Approver Position :</h3>
   </div>
        
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
   
   <?= $form->field($model, 'position')->dropDownList($positions, 
	         ['prompt'=>'-Choose a position-',
	         'class'=>['Select2 form-control select2'],
	         'id'=>'12',
	         
			  'onchange'=>'getEmployee(this.value,this.id)',
			  'options' => [1=> ['disabled' => $disabled ]
			  
			  ]
			  ])->label('Select Employee Position'); ?>    
      
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      
      
  <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-12' ,
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>                
                    
      
  </div>
    </div>
  <?php endif?>
  
  
  
  <?php endif;?>
  
  
  
<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 
 <?= Html::Button('<i class="fas fa-share-square"></i> Forward ', ['class' => 'btn btn-info btn-submit']) ?>

 
 
</div> 





<!-- ------------------------Approve--------------------------------------------------------- -->

<div id="form3" class="myDiv">
	

   
  
   <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="approve"> 
   
   

    
    <h3>Select Next Recipient / Approver</h3>
    
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
			  ])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>
    
  <?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
  
  <?= Html::Button('<i class="fas fa-thumbs-up"></i> Approve ', ['class' => 'btn btn-success btn-submit']) ?>

</div> 
 
 
 
<?php
   ActiveForm::end();

 ?>

 
 
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


function onReturnSelected(){
    
    
    
}


JS;
$this->registerJs($script1,$this::POS_HEAD);


$script = <<< JS


  $(document).ready(function(){
    
    
    
   toggleForms($('input:radio[name="ErpMemoApproval[action]"]:checked').val());
    
    
     $('input[type="radio"]').click(function(){
    
        toggleForms($(this).val());
    });
    
function toggleForms(ckValue){
 
 if(ckValue!=='') {
    
 $('div.myDiv').not('.'+ ckValue).hide().find('input:text,input:hidden,textarea, select').prop("disabled",true);
 
  $("#form"+ckValue).show().find('input:text,input:hidden, textarea,select').prop("disabled",false);


 
}
    
}  
    
    
    $('.Select2').select2({width:'100%'})
     $('.select2').select2({width:'100%'})
 
 });
 
 $(".btn-submit").click(function(){        
   $("#request-approval-form").submit();
    });


 $('#request-approval-form').on('beforeSubmit', function (e) {
    
      var values = $(this).serializeArray();
     
      
       if (values[6].value=="") {
        
       Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'No Employee Found For Selected Position!',
  
})
        return false;
    }
    
   
    return true;
});


JS;
$this->registerJs($script);
?>

