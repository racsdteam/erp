<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\models\ErpLpoRequest;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Drafts';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
a.lpo-type {
  color:blue;
  font-family: helvetica;
  text-decoration: underline;
  text-transform: uppercase;
}

a.lpo-type:hover {
  text-decoration: underline;
}

a.lpo-type:active {
  color: black;
}

a.lpo-type:visited {
  color: purple;
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="far  fa-edit"></i> My  Drafts LPO(s)</h3>
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
    
    


$q1=" SELECT lpo.* FROM  erp_lpo as lpo 
where lpo.created_by='".Yii::$app->user->identity->user_id."' and lpo.status='drafting' order by lpo.created desc";
 $com1 = Yii::$app->db->createCommand($q1);
 $rows = $com1->queryAll();
  
  $i=0;

    
    
    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Actions</th>
                                         <th>PO #</th>
                                         <th>PO Type</th>
                                          <th>PO Name</th>
                                         <th>PO Description</th>
                                         <th>PO Created Date</th>
                                         <th>PO created By</th>
                                        <th>Status</th>
                                        
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
     <!-- for each approved memo  find the attach requ -->                                
                                  <?php foreach($rows as $row):?>
                                   
                                  <?php 
                                       
                                $i++;                                 
                                  ?> 
                                    
                                    
                                    
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?>
                                     
                                     </td>
                                     
                                     <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                           
                                                <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-lpo/view-pdf",'id'=>$row['id'],'status'=>$status])
                                          ,['class'=>'btn-info btn-sm active ',
                                       
'title'=>'View Lpo  Info'] ); ?> |
                                          
                                     
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Url::to(["erp-lpo/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'Update Lpo  Info','disabled'=>$row["status"]!='drafting'] ); ?> |
                                          
                                                 <?=Html::a('<i class="far fa-trash-alt"></i>',
                                              Url::to(["erp-lpo/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete LPO  Info','disabled'=>$row["status"]!='drafting'] ); ?>   
                                            
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                                     
                                    <td nowrap>
                                     <?php echo  '<kbd style="font-size:10px;">'. $row["lpo_number"].'</kbd>' ; ?>
                 
                                     </td>
                                     
                                     <td nowrap><?php
                                     
                                     if($row["type"]=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($row["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fas fa-plane"></i>';
                                     }
                                     else{
                                          $label="Other";
                                          $fa='<i class="fab fa-opencart"></i>';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                          
                                            <td>
                                            
                                         <?php echo '<em>'. $row['file_name'].'</em></span>'  ?>   
                                            
                                        </td>
                                      
                                        <td>
                                            
                                         <?php echo '<em>'. $row['description'].'</em></span>'  ?>   
                                            
                                        </td>
                                        
                                         <td><?php echo $row["created"]; ?></td>
                                        
                                       <td><?php 
                                       
                                      
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['created_by']."' and pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                              
                                       
                                       ?>
                                       </td>
                                        
                                         <td><?php 
                                          $status= $row["status"];
                                         if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='rejected'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         
                                        
                                             
                                           
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
  text: "LPO will be Deleted !",
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

$('.update-action').on('click',function () {


var disabled=$(this).attr('disabled');

if(disabled){
    
swal("You are not Allowed to Edit This Memo!", "", "error");
return false;
}


});
 
  



JS;
$this->registerJs($script);



?>







