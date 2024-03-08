<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved LPO(s)';
$this->params['breadcrumbs'][] = $this->title;

//---------------------------------approved LPO----------------------------------------------------------------

  
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
   <h3 class="card-title"><i class="fa fa-tag"></i>Approved LPO(s)</h3>
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
  
  
$q63=" SELECT lpo_ap.* FROM erp_lpo_approval as lpo_ap inner join erp_lpo  as po  on po.id=lpo_ap.lpo where
 po.created_by=".Yii::$app->user->identity->user_id." and 
 lpo_ap.approval_action='approved' and lpo_ap.approval_status='final' ";
 $com63 = Yii::$app->db->createCommand($q63);
 $rows= $com63->queryAll();


    //var_dump($rows)
    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                         <th>PO Code</th>
                                         <th>PO Type</th>
                                         <th>PO Name</th>
                                         <th>PO Description</th>
                                         <th>PO Created Date</th>
                                         <th>PO created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
     <!-- for each approved memo  find the attach requ -->                                
                                  <?php foreach($rows as $row1):?>
                                   
                                  <?php 
    $user=Yii::$app->user->identity->user_id;
    $const_pos1='BUDGET AND PAYABLES ACCOUNTANT';
    $const_pos2='Manager Finance and Accounts Service';
    $const_pos3='Director Finance Unit';
    
    $q2=" SELECT p.position from erp_org_positions as p  inner join 
   erp_persons_in_position as pp on pp.position_id=p.id  
    where pp.person_id={$user} and pp.status=1";
   $command2 = Yii::$app->db->createCommand($q2);
    $user_pos = $command2->queryOne(); 
   
   
                           
                       
                       if( $user_pos== $const_pos1 ||  $user_pos== $const_pos2 || $user_pos== $const_pos3) {
              
                             $q2=" SELECT lpo.*  FROM  erp_lpo as lpo 
where lpo.id='".$row1['lpo']."'  ";
 $com2 = Yii::$app->db->createCommand($q2);
 $row = $com2->queryOne();                
                           
                       }else{
                     
                             $q2=" SELECT lpo.*  FROM  erp_lpo as lpo 
where lpo.id='".$row1['lpo']."' and lpo.created_by='".$user."'   ";
 $com2 = Yii::$app->db->createCommand($q2);
 $row = $com2->queryOne();       
                       }     
                             
                     
 
 if(!empty($row)){
 
 
                                $i++;                                 
                                  ?> 
                                    
                                    
                                    
                                     <tr class=" <?php if($row1['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?>
                                    <td nowrap>
                                     <?php echo  '<kbd style="font-size:10px;">'. $row["lpo_number"].'</kbd>' ; ?>
                 
                                     </td>
                                    <td><?php
                                     
                                     if($row["type"]=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fa fa-opencart"></i>';
                                     }
                                     else if($row["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
                                     }
                                     else{
                                          $label="Other";
                                          $class="label pull-left bg-purple";
                                          $fa='<i class="fa fa-file-o"></i>';
                                     }
                                     
                                     echo '<small style="padding:10px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
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
                                         if( $status=='processing' ||   $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }
                                             else if($status=='approved'){
                                                  
                                                  $class="label pull-left bg-green";
                                                 
                                             }
                                             
                                             
                                             else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         
                                            
                                          
                                            <td> 
                                                <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-lpo/view-pdf",'id'=>$row['id'],'status'=>$status])
                                          ,['class'=>'btn-info btn-sm active action-view',
                                       
'title'=>'View Lpo Info'] ); ?> </td>
                                          
                                  
                                            
                                        </tr>
                                    
                                    <?php } endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>


 </div>

 </div>
 
 
 </div>

</div>


        <?php
   
$script = <<< JS

 

JS;
$this->registerJs($script);



?>



