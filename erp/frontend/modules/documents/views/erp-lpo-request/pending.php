<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'pending LPO Request(s)';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
  
 ul#menu li {
  display:inline;
  margin-bottom:20px;
 
}


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-inbox"></i> Pending LPO Request(s)</h3>
   
  
       
      
       
  
   
 </div>
 <div class="card-body">

     


 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    <?php 
    
   $q1=" SELECT lpo_rf.* FROM erp_lpo_request_approval_flow  as lpo_rf 
   where lpo_rf.approver='".Yii::$app->user->identity->user_id."' and lpo_rf.status='pending' order by lpo_rf.timestamp desc";
   $com1 = Yii::$app->db->createCommand($q1);
   $rows = $com1->queryAll(); 
 
 
    
    ?>
    
    

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Actions</th>
                                         <th>LPO Request Type</th>
                                         <th>Request Title</th>
                                         
                                         <th>Submitted</th>
                                          <th>Submitted by</th>
                                           <th>Comment/Remark</th>
                                           <th>Severity</th>
                                              <th>Status</th>
                                                
                                                  
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
     <!-- for each approved memo  find the attach requ -->                                
                                  <?php foreach($rows as $row):?>
                                   
                                  <?php 
                           
                       $q=" SELECT r.*  FROM erp_lpo_request as r 
 
                      where   r.id={$row['lpo_request']} ";
 $com = Yii::$app->db->createCommand($q);
 $row1= $com->queryOne()  ;         

 
                              if(!empty( $row1)){
                                  $i++; 
                                  
                              

                                  ?> 
                                    
                                    
                                    
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     
                                     <td nowrap>
                                     <?php echo $i;  ?>  </td>
                                     
                                         <td nowrap>
                                            
                                                               <div class="centerBtn">
   
  
                                        <?=Html::a('<i class="fa fa-eye"></i>', Url::to(["erp-lpo-request/view-pdf",'id'=>$row1['id']])
                                          ,['class'=>'btn-info btn-sm active',
                                       
'title'=>'View Lpo request Info'] ); ?> 

<?php
                                          if( $row1['requested_by']==Yii::$app->user->identity->user_id || $row1["status"]=='Returned'):
                                          ?>
                                           |
         <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-lpo-request/update",'id'=>$row1['id']
                                           ])
                                          ,['class'=>'btn-success  btn-sm active','title'=>'Update Lpo Request Info','disabled'=>$row["status"]!='drafting'] ); ?> 
                                        <?php 
                                        endif;
                                        ?>
                                          
                                           |
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-lpo-request/done",'id'=>$row1['id'],
                                           ])
                                          ,['class'=>'btn-primary btn-sm active archive-action','title'=>'Archive LPO Request Info']); ?>
                                         
                                        

<?php if($row1["status"]=='approved') : echo '<b style="font-size:20px;">'.'|'.'</b>'?>
                                          
                                          
      <?=Html::a('<i class="fa fa-plus-circle"></i> Issue Lpo',
                                              Url::to(["erp-lpo/create",'request_id'=>$row1['id'],'type'=>$row1['code']])
                                          ,['class'=>'btn-success  btn-sm active',
                                       
'title'=>'Issue LPO'] ); ?>                                     
                                          
                                          <?php  endif ?>       
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                 
                                      <td><?php
                                     
                                     if($row1["type"]=='PR'){
                                       
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($row1["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
                                     }
                                     else{
                                          $label='Other';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                     
                                        <td><?php echo $row1["title"]; ?></td>     
                                      
                                          
                                        <td><?php echo $row["timestamp"]; ?></td>
                                            
                                            
                                             <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['originator']."' and pp.status=1  ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?>
                                        
                                         <td >
                                            
                                        <?php   echo '<em style=" font-family: Tahoma, Verdana, Segoe, sans-serif ;">'.$row['remark'].'</em>'; ?>  
                                            
                                        </td>
                                        
                                         <td>
                                        <?php 
                                          $sv= $row1["severity"];
                                         
                                         if( $sv=='immediate'){
                                                 
                                                 $class="label pull-left bg-orange";
                                             }else if($sv=='critical' || $sv=='urgent' ){
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical' || $sv=='very urgent' ){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                         <td><?php 
                                          $status= $row1["status"];
                                         if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }
                                             else if($status=='completed' ||$status=='Processed'){
                                                  
                                                  $class="label pull-left bg-purple";
                                                 
                                             }
                                             else{$class="label pull-left bg-orange";}
                                             
                                               $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".Yii::$app->user->identity->user_id."' and pp.status=1  ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


if($row7['position_level']=='pa'){
    
 //----------------find who he reports to------------------------------------------------------
 $q8=" SELECT u.user_id FROM user u 
inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
where pp.position_id={$row7['report_to']}";

$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();

//----------------------get status--------------------------------------------
  $q="SELECT f.* FROM erp_lpo_request_approval_flow  as f
 where approver={$row8['user_id']}  and f.lpo_request={$row1['id']} order by timestamp desc  ";
     $com = Yii::$app->db->createCommand($q);
     $rows2 = $com->queryAll(); 
    
    
    if(!empty($rows2)){
        $r2=$rows2[0];
        
        
        if($r2['status']=='pending'){
        
        $status='Waiting for Approval';
        $class="label pull-left bg-pink";
    }
    elseif($r2['status']=='done'){
        
        $status='Done';
        $class="label pull-left bg-green";
    }else if($r2['status']=='archived'){
        
        $status='Archived';
        $class="label pull-left bg-orange";
        
    }
        
    }
    

}
                                             
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         
                                            
                                        </tr>
                                    
                                    <?php } endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>

 </div>

 </div>
 
 
 </div>

</div>
 <!--modal -->           



        <?php
        
        
   
$script = <<< JS

     
  $('.archive-action').on('click',function () {


var url=$(this).attr('href');
 
    swal({
        title: "Are you sure?",
        text: "You want to archive this",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Archive ",
        closeOnConfirm: false
    }, function () {
        
$.post( url, function( data ) {
  //$( ".result" ).html( data );
});

        
    });
    
    return false;

});



JS;
$this->registerJs($script);



?>



