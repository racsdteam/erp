<?php



use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
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

.next-ap-visible{
    
  display:visible;  
}

.next-ap-hidden{display:none;}

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
  
 <div class="card card-default  ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-fa-gavel"></i> Work Flow Actions  </h3>
 </div>
 <div class="card-body">
     
     <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="fa fa-question-circle"></i> Info!</h4>
                
                <ul class="notice">
                    <li> Return :  Return the memo e.g : request for correction,request for more info </li>
                     <li>Forward : Send the memo to the next user for approval (For managers,Technicians & Officers)</li>
                     <li>Approve & Forward :  Approve the memo and forward it (For Directors)</li>
                  </ul>
                
  
              </div 
 



<?php

    
$user=Yii::$app->user->identity->user_id;
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
$q8=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
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
  where  p.position_code='AAMD' and pp.status=1 ";
  $command77= Yii::$app->db->createCommand($q77);
  $row77 = $command77->queryOne();
  
  $date = date('Y-m-d');
  $date=date('Y-m-d', strtotime($date));
  
$row888 =Yii::$app->muser->getInterim($user,$row77['user_id'],$date);

//-------------------disable settings----------------------------------------------------------
if($pos_code=='AAMD' || $pos_code=='DMD' || $row888!= null){
    
    $disabled=false;
}else{
    
    $disabled=true;
}

$model1=ErpMemo::find()->where(['id'=>$memo_id])->One();
$model2=ErpMemoCateg::find()->where(['id'=>$model1->type])->One();


  //----------------------------------interim for director----------------------------------------------------------                 
       $final_approver_settings=ErpMemoApprovalSettings::find()->where(['memo_id'=>$memo_id])->One(); 
       $final_app=$final_approver_settings->final_approver;
 
 
 $approvalDate = date('Y-m-d');
 $approvalDate=date('Y-m-d', strtotime($approvalDate));
  
$q9="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$final_app."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 



//----------------------------manager can approve------------------------------------
if(!empty($row9) && $pos_level!='director'){
    
   $pos_level='director';
}

?>



<?php 

                  $items=array();
                  $items['1']='Return';
                  
                  
                  if(($pos_level=='manager' || $pos_level=='officer' || $pos_level=='pa'  || ($pos_level=='director' && $model1->status=='drafting'))){
                      
                       
                   
                   
                   $items['2']=' Forward';   
                      
                 
                  }
   
                 
                 
                         
                  if($pos_level=='director' || ($row7['position_code']=='AAMD' && $model2->categ_code=='O')  || 
                  
                  $row7['position_code']=='ITENG' ){
                      
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
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['erp-memo-approval/work-flow'],
        'method' => 'post'
       ]);

?>
    <input type="hidden" id="MemoId" name="ErpMemoApproval[memo_id]" value="<?php echo $memo_id ?>">
    <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="rfa">
    
    <div class="row text-black">
        
        
    
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
         <?= $form->field($model, 'employee[]')->dropDownList($employees, 
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
	
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-memo-approval/work-flow'],
        'method' => 'post'
       ]);

?>

     <input type="hidden" id="MemoId" name="ErpMemoApproval[memo_id]" value="<?php echo $memo_id ?>">
     <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="cforward">

<?php if($model1->status=='drafting' &&  $model1->created_by==$user)  :?>
  
 
   
   <div  class="row bg-green">   

     <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12 ">
         
          <h3 style="display: inline;"><b>To : </b></h3> (<em>Select who should approve this Memo</em>) 
     </div>
     
     <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6 input">
     <?= $form->field($model0, 'approver_position')->dropDownList($positions, 
	         ['prompt'=>'-Choose an option-','class'=>['Select2 form-control select2'],'id'=>'10',
			   'onchange'=>'getEmployee(this.value,this.id)'])->label('Select Employee Position'); ?>   
      
  </div>
  
  <div class="col-xs-12 ol-sm-12 col-md-6 col-lg-6 input">
   <?= $form->field($model0, 'approver_name')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-10' ,'multiple'=>'multiple',
			  'onchange'=>'
			'])->label('Final Approver Name (automatically filled in)'); ?>	   
      
  </div>
      
      
  </div>
  
  
  <?php endif?>
  
  
    
    
      <!-- -------------------------manager can send directly the director for purchase requisition----------------------------------------------------------------->
  
  <?php if($pos_level=='manager' && $model2->categ_code=='PR' && ($model1->status=='drafting' || $model1->status=='returned' ))
  
  :?>
  
  <!--- -------nothing-------------------> 
 
  <?php  else : ?>
  
  
  
  <?php if($model1->status=='drafting' &&  $model1->created_by==$user)  :?>
  
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
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-14' ,'multiple'=>'multiple',
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>                
                    
      
  </div>
  </div>
  
   <?php else: ?>
     <div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <h3>Select Next Approver Position :</h3>
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
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-12' ,'multiple'=>'multiple',
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>                
                    
      
  </div>
    </div>
  <?php endif?>
  
  <?php endif;?>
  
  
  
<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>


<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
 
 
</div> 





<!-- ------------------------Approve--------------------------------------------------------- -->

<div id="form3" class="myDiv">
	
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['erp-memo-approval/work-flow'],
        'method' => 'post'
       ]);

?>

   
   <input type="hidden" id="MemoId" name="ErpMemoApproval[memo_id]" value="<?php echo $memo_id ?>">
   <input type="hidden" id="Action" name="ErpMemoApproval[action]" value="approve"> 
   
   

    
    <h3>Select Next Recipient(s)</h3>
    
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
	         ['prompt'=>'-Choose a employee-','class'=>['Select2 form-control select2'],'id'=>'emp-2' ,'multiple'=>'multiple',
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>   
         
     </div>
    
    </div>
    
  
     
 
  
			
			

<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
 
<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
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

