<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'pending Purchase Order(s)';
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
 <div class="card-header">
   <h3 class="card-title"><i class="fas fa-database"></i> Pending Purchase Order(s)</h3>
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
    
     $q1=" SELECT f.* FROM erp_lpo_approval_flow  as f inner join erp_lpo as po on po.id=f.lpo
     where f.approver='".Yii::$app->user->identity->user_id."' and f.status='pending' order by f.timestamp desc";
     $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll(); 
 
 
 
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".Yii::$app->user->identity->user_id."' and pp.status=1 " ;
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
    
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
                                         <th>PO Created</th>
                                          <th>PO Submitted</th>
                                          <th>PO Submitted By</th>
                                          <th>Remark</th>
                                            <th>Status</th>
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                 
                                  <?php foreach($rows as $row0):?>
                                   
                                  <?php 
        $q2=" SELECT lpo.* FROM  erp_lpo as lpo where lpo.id='".$row0['lpo']."'";
 $com2 = Yii::$app->db->createCommand($q2);
 $row = $com2->queryOne();  
 

                               
                                
                                if(!empty( $row)){
                                  $i++
                                  
                                  ?> 
                                    
                                    
                                    
                                     <tr class=" <?php if($row0['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?>
                                     </td>
                                     
                                      <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
                                        
                                           
                                                <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-lpo/view-pdf",'id'=>$row['id'],'status'=>$row['status']])
                                          ,['class'=>'btn-info btn-sm active ',
                                       
'title'=>'View Lpo  Info'] ); ?> 
                                          
                                       
          <?php
                                          if( $row['created_by']==Yii::$app->user->identity->user_id && $row['status']!='approved'):
                                          ?>
                                          
                                           <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-lpo/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn btn-success  btn-sm action-update','title'=>'Update Lpo  Info'] ); ?> |
                                          
                                          <?php endif ?>  
                                          
                                          
                                          
                                          
                                          <?=Html::a('<i class="fa fa-archive"></i> Archive ',
                                              Url::to(["erp-lpo/done",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn btn-primary btn-sm ','title'=>'Complete LPO Info'] ); ?> |
                                          
                                       
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                                    <td nowrap>
                                     <?php echo  '<kbd style="font-size:13px;">'. $row["lpo_number"].'</kbd>' ; ?>
                 
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
                                     elseif($row['type']='O'){
                                          $label='Other';
                                          $fa='<i class="fab fa-opencart"></i>';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>'; 
                                    
                                    
                                    ?></td>
                                          
                                         <td>
                                            
                                         <?php echo '<em>'. $row['file_name'].'</em></span>'  ?>   
                                            
                                        </td>
                                        <td>
                                            
                                         <?php echo '<em>'. $row['description'].'</em>'  ?>   
                                            
                                        </td>
                                        
                                         <td><?php echo $row["created"]; ?></td>
                                        
                                          <td><?php echo $row0["timestamp"]; ?></td>
                                          
                                           <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row0['originator']."' and pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                           <td><?php echo '<em>'.$row0['remark'].'</em>'; ?></td>
                                        
                                         <td><?php 
                                          $status= $row["status"];
                                         
                                         if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }
                                             
                                             else if($status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                                                                  $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".Yii::$app->user->identity->user_id."'  and pp.status=1";
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
  $q="SELECT f.* FROM erp_lpo_approval_flow  as f
 where approver={$row8['user_id']}  and f.lpo={$row['id']} order by timestamp desc  ";
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

     
 


JS;
$this->registerJs($script);



?>



