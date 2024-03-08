<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\models\ErpMemoCateg;
use common\components\Constants;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved Memos';
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
   <h3 class="card-title"><i class="fas fa-boxes"></i> Approved Memo(s)</h3>
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

     $user=Yii::$app->user->identity;
    $cond[]='and'; 
   
    $cond[]=['=', 'tbl_m.status',Constants::STATE_APPROVED];//cond1
   
    if($user->user_level!=User::ROLE_ADMIN){
     
     $cond[]=['=', 'tbl_m.created_by',$user->user_id]; //cond 3
     }
     $cond[]=['=', 'tbl_m_ap.approval_status',Constants::STATE_FINAL_APPROVAL];//cond2 
     
     $query = new Query;
     $query->select([
        'tbl_m.*',
        'tbl_m_ap.approved',
        'tbl_m_ap.approved_by',
        'tbl_m_ap.approver_position',
        'tbl_m_ap.is_new as  is_new_approval',
        'tbl_t.categ',
        'tbl_t.categ_code'
        ]
        )  
        ->from('erp_memo as tbl_m')
        ->join('INNER JOIN', 'erp_memo_approval as tbl_m_ap',
            'tbl_m.id =tbl_m_ap.memo_id')		
        ->join('INNER JOIN', 'erp_memo_categ as tbl_t', 
            'tbl_m.type =tbl_t.id')
        ->where($cond)	; 
		
$command = $query->createCommand();
$data = $command->queryAll();

 
?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>#Memo Code#</th>
                                          <th>Title</th>
                                          <th>Memo For</th>
                                           <th>Approval Status</th>
                                           <th>Approved</th>
                                            <th>Approved By</th>
                                             
                                             
                                              
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($data))
                                    {
                                    foreach($data as $row):
                                 
     $i++;                              
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new_approval']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                      <td>   <?=
                                           $i;
                                            
                                           ?></td>
                                                 <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["erp-memo/view-pdf",'id'=>$row['id']])
                                          
                                          ,['class'=>'btn-info btn-sm active ','title'=>'View Memo Info'] ); ?> 
                                            
                                        
                                                 
                                                 
                                         
                         </div>
                                   
                                          </td >     
                                           
                                    <td style="white-space:nowrap;"><?= Html::a('<i class="fa fa-file-text"></i>'." ".$row["memo_code"],Url::to(['erp-memo/view','id'=>$row["id"]]), ['class'=>'link-code']) ?></td>
                                    <td>
                                            <?=
                                           $row["title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                        <?php
                                          
                                         
                                           if($row['categ_code']=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($row['categ_code']=='TR'){
                                         $label='Travel Request';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fas fa-plane"></i>';
                                     }
                                      else if($row['categ_code']=='RFP'){
                                         $label='Request For Payment';  
                                         $class="label pull-left bg-orange";
                                         $fa='<i class="fa fa-money"></i>';
                                     }
                                     else{
                                          $label=$row['categ'];
                                          $fa='<i class="fas fa-file"></i>';
                                          $class="label pull-left bg-warning";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';
                                           
                                           
                                            
                                           ?>
                                          
                                          
                                         </td>
                                         
                                         
                                             <td><?php 
                                             $status= $row["status"];
                                      
                                             
                                             if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                            
                                          <td><?php echo $row["approved"] ; ?></td>  
                                           <td><?php 
                                           
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['approved_by']."' and pp.position_id='".$row['approver_position']."'";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name']; 
                                            
                                           echo $full_name." [".$pos." ]"; ?></td>
                                           
                                           </td>  
      
                                             

                        
                                          
                          
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



