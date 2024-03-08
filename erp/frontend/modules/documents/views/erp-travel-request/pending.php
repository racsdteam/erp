<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Travel Request';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-inbox"></i> Pending Travel Request(s)</h3>
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
<?php 
$i=0; 
$q=" SELECT tr_flow.*,tr.*,tr.status as tr_status  FROM erp_travel_request_approval_flow as tr_flow
 inner join erp_travel_request as tr  on tr.id=tr_flow.tr_id  
where approver='".Yii::$app->user->identity->user_id."' and tr_flow.status='pending' order by tr_flow.timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
  //var_dump( $rows);die();
    
    
    $q7=" SELECT u.unit_name,u.unit_code,p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
 inner join erp_org_units as u on u.id=pp.unit_id
 where  pp.person_id='".Yii::$app->user->identity->user_id."' ";
 $command7= Yii::$app->db->createCommand($q7);
 $row7 = $command7->queryOne();
 
 
                             
                              
                               if(($row7 ['unit_code']=='HRU' || $row7 ['unit_code']=='HRADMIN'  ) ){
      
       $is_in_hr=true;
  }else{
      
       $is_in_hr=false;
  }
  
   
?>

<div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                         <th>Actions</th>
                                        <th>Tr.Request Number</th>
                                      
                                        <th>Purpose</th>
                                         <th>Destination</th>
                                          <th>Dep.Date</th>
                                           <th>Ret.Date</th>
                                        <th>Submitted</th>
                                         <th>Submitted By</th>
                                         <th>Status</th>
                                         <th>Remark</th>
                                        
                                        
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                     
                                     $i++;
                                    ?>
                                    
        
                                    <tr class="<?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                             <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-travel-request/viewer-pdf",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View  Travel Request Info'] ); ?> |
                                                       <?php  
                                          
                                          if( $is_in_hr && $row["status"]=='processing') :?>
                                            
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-travel-request/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active ','title'=>'Update Memo Info'] ); ?> |
                                          <?php 
                                        endif;
                                        ?>  
                                              <?php
                                              
                                              
                                          if($row["status"]=='approved' || $row["status"]=='processing'|| $row["status"]=='Returned'):
                                          ?>
                                           |
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-travel-request/done",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-primary btn-sm active archive-action','title'=>'Archive Travel Request Info']); ?>
                                        <?php 
                                        endif;
                                        ?>    
                                            
        </div>     
                                            
                                            
                                        </td>
                                    <td><?= Html::a($row["tr_code"],Url::to(['erp-travel-request/view','id'=>$row["id"]]), ['class'=>'']) ?></td>
                                 
                                 
                                            <td>
                                            <?=
                                           $row["purpose"]
                                            
                                           ?>
                                          
                                         </td>
                                         <td>
                                            <?=
                                           $row["destination"]
                                            
                                           ?>
                                          
                                         </td>
                                         
                                          <td>
                                            <?=
                                           $row["departure_date"]
                                            
                                           ?>
                                          
                                         </td>
                                         
                                          <td>
                                            <?=
                                           $row["return_date"]
                                            
                                           ?>
                                          
                                         </td>
                                           
                                             <td><?php echo $row["timestamp"] ; ?></td>
                                             
                                             <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['originator']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                             
                                              
                                            
                                            <td><?php 
                                            
                                            $status=$row["status"];
                                             
                                             if($status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved'){
                                                  
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                             
                                               $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".Yii::$app->user->identity->user_id."'  ";
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
  $q="SELECT f.* FROM erp_requisition_approval_flow  as f
 where approver={$row8['user_id']}  and f.tr_id={$row['id']} order by timestamp desc  ";
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
                                             
                                             echo '<small style="padding:5px; border-radius:13px" class="'.$class.'">'. $status.'</small>'; ?></td>
                                            <td><?php echo '<em>'.$row["remark"].'</em>' ; ?></td>
                           
                                            
                                            
                                            
                                            
                                            
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
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



