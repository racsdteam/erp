<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Memos';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 

  .m-title{
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}
</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-boxes"></i> All Memo(s)</h3>
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
    
        
 $q1=" SELECT m.*,c.categ,c.categ_code  FROM erp_memo as m
 inner join erp_memo_categ as c  on c.id=m.type  order by m.created_at desc";
     $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();
     $i=0;
    
    ?>


 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                               <th align="center">Actions</th>
                                        <th>Memo Code</th>
                                          <th>Title</th>
                                          <th>Category</th>
                                          <th>Created</th>
                                           <th>Expiry</th>
                                           <th>Created By</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row1):
                                
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row1['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["erp-memo/view-pdf",'id'=>$row1['id'],'flow'=>$row['id']])
                                          
                                          ,['class'=>'btn btn-info  btn-sm  action-viexw','title'=>'View Memo Info'] ); ?> 
                                            
                                          
                                          <?=Html::a('<i class="fa fa-recycle"></i> Histroy',
                                             Url::to(["erp-memo/memo-tracking",'id'=>$row1['id']
                                           ])
                                          ,['class'=>'btn btn-primary  btn-sm  saction-view','title'=>'Memo tracking History' ] ); ?>
                                           
                                                 
                                                 
                                         
                         </div>
                                   
                                          </td > 
                                         
                                         
                                    <td nowrap><?= Html::a(' <i class="fa fa-file-text"></i>'." ".$row1["memo_code"],Url::to(['erp-memo/view','id'=>$row1["id"]]), ['class'=>'action-viewx']) ?></td>
                                    <td>
                                        <div class="m-title">
                                            <?=
                                           $row1["title"]
                                            
                                           ?>
                                            
                                        </div>
                                            
                                          
                                          
                                         </td>  
                                    <td nowrap>
                                                  <?php
                                          
                                          
                                           if( $row1['categ_code']=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if( $row1['categ_code']=='TR'){
                                         $label='Travel Request';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fas fa-plane"></i>';
                                     }
                                      else if( $row1['categ_code']=='RFP'){
                                         $label='Request For Payment';  
                                         $class="label pull-left bg-orange";
                                         $fa='<i class="fa fa-money"></i>';
                                     }
                                     else{
                                          $label=$row1['categ'];
                                          $fa='<i class="fa fa-file-o"></i>';
                                          $class="label pull-left bg-pink";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';
                                           
                                           
                                            
                                           ?>
                                          
                                          
                                         </td>
                                         
                                        
                                           
                                           
                                            <td><?php echo $row1["created_at"] ; ?></td>
                                            <td nowrap><?php echo $row1["expiration_date"] ; ?></td>
                                            
                                            <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row1['created_by']."' and pp.status=1 "; 

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                            echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
                                            </td>
                                            
                                             <td><?php 
                                             $status= $row1["status"];
     /*                                        //----------------------------check if someone else has approved---in case of interim----------------------------------
    $q2=" SELECT r.*  FROM erp_memo_flow_recipients as r  where
     r.flow_id={$row['flow_id']} and r.timestamp='".$row['time_sent']."' and r.status='approved' ";
    $command2 = Yii::$app->db->createCommand($q2);
    $r2 = $command2->queryOne(); 
    
    if($r2){
        
     $status= $r2['status'] ;  
    } */                                        
                                             
                                             
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='expired'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{
                                                  $class="label pull-left bg-orange";
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                            
                                             
      
                                              
                                            
                          
                                        </tr>

                                     
                                    
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
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



