<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\models\ErpRequisitionApprovalFlow;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'pending Purchase Requisitions';
$this->params['breadcrumbs'][] = $this->title;

  

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


  .remark{
  
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}
</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fab fa-opencart"></i> Pending Purchase Requisition(s)</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton:true,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
   
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>

  
   <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
                <?php echo Yii::$app->session->getFlash('failure')?>
              </div>
    <?php endif; ?>

<?php  


//---------------------------------pending req----------------------------------------------------------------

$q1=" SELECT distinct(r.pr_id),r.is_new FROM erp_requisition_approval_flow  as r 
where r.approver='".Yii::$app->user->identity->user_id."' and r.status='pending' order by r.timestamp desc";
 $com1 = Yii::$app->db->createCommand($q1);
 $rows = $com1->queryAll();
 
         

?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th> Actions</th>
                                        <th>PR Code</th>
                                        <th>Requisition For</th>
                                        <th>Title</th>
                                        <th>On procurement Plan</th>
                                         <th>Status</th>
                                        
                                        <th>Submitted</th>
                                        <th>Submitted  by</th>
                                        <th>Remark</th>
                                       
                                       
                                      
                                      
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row1):?>
                                    <?php 
                                     
    $q=" SELECT pr.*,t.type as pr_type FROM erp_requisition as pr inner join erp_requisition_type as t on t.id=pr.type
   
   where pr.id='".$row1['pr_id']."' ";
        $com = Yii::$app->db->createCommand($q);
        $row = $com->queryOne();
                                     $i++;
                                     
                       if($row) {             
                                     
                                    ?>
                                    
        
                                    <tr class="<?php if($row1['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                                                           <td nowrap>
                                              
                                              
                                              <div style="text-align:center" class="centerBtn">
        <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row['id'],'status'=>$row["approve_status"],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info']); ?>
                                          
                                          <?php
                                          if( ($row['requested_by']==Yii::$app->user->identity->user_id && $row["approve_status"]=='Returned') ||
                                          ($row1['approver']==Yii::$app->user->identity->user_id && $row["approve_status"]=='Returned')
                                          ):
                                          ?>
                                           |
        <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-requisition/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-updatex','title'=>'Update Purchase Requisition Info']); ?>
                                        <?php 
                                        endif;
                                        ?>
                                        
                                        
                                           |
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-requisition/done",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active archive-action','title'=>'Purchase Requisition Info']); ?>
                                          
                                          
                                          
                                            <?php
                                            
                                            
                                            if($row['approve_status']=='approved'){
              
  
  //----------------check request exist
                                         
                                      $q11="SELECT lpo_r.* FROM erp_lpo_request as lpo_r inner join  erp_requisition  as r   on r.id=lpo_r.request_id
 where lpo_r.request_id='".$row['id']."' and lpo_r.type='PR' and  lpo_r.status IN ('processing' ,'approved','processed','completed') ";
 $com11 = Yii::$app->db->createCommand($q11);
 $res= $com11->queryOne(); 
 
 
 
 //if request exist and in processing or processed or approved----------already sent
                                        
                                         if(!empty($res))
                                         {
                                     echo '<small style="padding:5px;border-radius:9px" class="label label-info"><i class="fa fa-check-circle 
                                      " style="font-size:12px;color:green"></i> 
                                     LPO Request Sent</small>';;           
                                          
                                         }else{
                                             
                                             
                                            
  echo  Html::a('<i class="fa  fa-plus-circle"></i> Create LPO Request ',
                                              Url::to(["erp-lpo-request/create",'request_id'=>$row['id'],'type'=>'PR'])
                                          ,['class'=>'btn-success btn-sm active',
                                       
'title'=>'create new request'] );                                                 
                                         }
                                         
                                         
                                            }
                                      
                                         ?>                                    
                                       
                                          </div>
    </td>  
                                    <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$row["requisition_code"],Url::to(['erp-requisition/view-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>
                                 
                                 
                                         <td>
                                            <?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$row["pr_type"].'</small>';
                                         
                                          ?>
                                          
                                          
                                            <td>
                                            <?=
                                           $row["title"] ;
                                            
                                           ?>
                                          
                                         </td>
                                         
                                          <td><?php  
                                            
                                            if($row['is_tender_on_proc_plan']){
                                                
                                               echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. "Yes".'</small>';  
                                            }else{
                                                
                                              echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-red">'. "No".'</small>';     
                                            }
                                            
                                            ?></td>
                                         
                                         <td><?php 
                                         
                                         $status=$row["approve_status"];
                                             
                                             if( $status=='processing' ||  $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if( $status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                                                                        //--------------------------------------------CHECK STATUS FOR PAA--------------------------------------------------------------//
             $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".Yii::$app->user->identity->user_id."'  and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


if($row7['position_level']=='pa'){
    
 //----------------find who he reports to------------------------------------------------------
 $q8=" SELECT u.user_id FROM user u 
inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
where pp.position_id={$row7['report_to']}";

$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();

if(!empty($row['id']))
{
//----------------------get status--------------------------------------------
  $q="SELECT f.* FROM erp_requisition_approval_flow  as f
 where approver={$row8['user_id']}  and f.pr_id={$row['id']} order by timestamp desc  ";
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
}
                                             
                                             echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">'.$status.'</small>'; ?></td>
                                          
                                         </td>
                                             
                                           
                                         
                                          <td><?php echo $row1["timestamp"]; ?></td>
                                         
                                         
                                          
                                         </td>
                                           
                                              <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  
                                             erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row1['originator']."' and pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                            
                                            
                                        
                                           <td><div class="remark"><?php echo '<em>'.$row1["remark"].'</em>'; ?></div></td>
                                            
                                            
                           
                                  
                 

                                        </tr>

                                     
                                    
                                    <?php }endforeach;?>
                                       
                                    </tbody>
                                </table>

                                 </div>

 </div>

 </div>
 
 
 </div>

</div>


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



