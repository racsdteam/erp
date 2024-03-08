<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drafts';
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
   <h3 class="card-title"><i class="far fa-edit"></i> Drafts</h3>
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
  showConfirmButton: false,
  timer: 1500
})";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

   echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
 
  ?>
    <?php endif; ?>
<?php 



     

    $q=" SELECT pr.*,t.type as pr_type FROM erp_requisition as pr inner join erp_requisition_type as t on t.id=pr.type
   
   where requested_by='".Yii::$app->user->identity->user_id."' and  pr.approve_status='drafting' order by pr.requested_at desc ";
        $com = Yii::$app->db->createCommand($q);
        $rows = $com->queryAll();
       $i=0;
?>

 <div class="table-responsive">
 <table class="table  table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                         <th align="center">Actions</th>
                                        <th>PR Code</th>
                                        <th>Title</th>
                                        <th>Requisition For</th>
                                        <th>Requested</th>
                                        <th>Requested by</th>
                                         <th>Tender On Proc Plan</th>
                                        <th>Status</th>
                                       
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
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row['id'],'status'=>$row["approve_status"],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info','disabled'=>$row["approve_status"]!='drafting'] ); ?> | 
                                            
                                           
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-requisition/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-success  btn-sm active ','title'=>'Update Purchase Requisition Info','disabled'=>$row["approve_status"]!='drafting'] ); ?> | 
                                           
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["erp-requisition/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete Purchase Requisition Info','disabled'=>$row["approve_status"]!='drafting'] ); ?> 
                                            
                                             
        </div>     
                                            
                                            
                                        </td>  
                                           
                                           
                                    <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$row["requisition_code"],Url::to(['erp-requisition/view-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>
                                 
                                 
                                            <td>
                                            <?=
                                           $row["title"] ;
                                            
                                           ?>
                                          
                                         </td>
                                         <td>
                                            <?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$row["pr_type"].'</small>';
                                         
                                          ?>
                                          
                                         </td>
                                         
                                          <td><?php echo $row["requested_at"]; ?></td>
                                         
                                         
                                          
                                         </td>
                                           
                                              <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['requested_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                            
                                            
                                            
                                            <td><?php  
                                            
                                            if($row['is_tender_on_proc_plan']){
                                                
                                               echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. "Yes".'</small>';  
                                            }else{
                                                
                                              echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-red">'. "No".'</small>';     
                                            }
                                            
                                            ?></td>
                                            
                                            <td><?php  
                                             if($row["approve_status"]=='processing' || $row["approve_status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">'. $row["approve_status"].'</small>'; ?></td>
                                            
                           
                                          
                                            
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

$('.action-delete').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Requisition will be Deleted !",
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
$this->registerJs($script);



?>



