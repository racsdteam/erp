<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\UserHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Stock request(s)';
$this->params['breadcrumbs'][] = $this->title;



  $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];
  
  $user=Yii::$app->user->identity;
?>
<div class="request-to-stock-index">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>Pending Stock Voucher(s)</h3>
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

$q1=" SELECT re.* FROM request_approval_flow  as f inner join request_to_stock as re on re.reqtostock_id=f.request
     where f.approver='".Yii::$app->user->identity->user_id."' and f.status='pending' order by f.timestamp desc";
     $com1 = Yii::$app->db1->createCommand($q1);
     $rows = $com1->queryAll();
     $i=0;
    
    ?>


 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>Voucher Number</th>
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
                                             
                                             Url::to(["request-to-stock/view",'id'=>$row1['reqtostock_id']])
                                          
                                          ,['class'=>'btn-info btn-sm active ','title'=>'View Voucher Info'] ); ?> |
                                            
                                          <?php
                                          if(($row1["status"]=="processing" || $row1["status"]=="returned"  || $row1["status"]=="Approved") && ($userposition == "MGRLGX" || $userposition == "STOFC" || $user->user_level==User::ROLE_ADMIN )):
                                          ?>
                                          <?=Html::a('<i class="fa fa-recycle"></i> Check Out',
                                             Url::to(["request-to-stock/check-out",'id'=>$row1['reqtostock_id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active','title'=>'Check Out' ] ); ?>|
                                           
                                          <?php 
                                          endif;
                                          ?>
                                           <?php
                                          if( $row1['staff_id'] == Yii::$app->user->identity->user_id ||  $user->user_level==User::ROLE_ADMIN ):
                                          ?>
                                           <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                             Url::to(["request-to-stock/update",'id'=>$row1['reqtostock_id']
                                           ])
                                          ,['class'=>'btn-warning btn-sm active','title'=>'Edit Voucher' ] ); ?>
                                             <?php 
                                          endif;
                                          ?>    
                                          <?=Html::a('<i class="fa fa-archive"></i> Archive ',
                                              Url::to(["request-to-stock/done",'id'=>$row1['reqtostock_id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active archive-action','title'=>'Complete Memo Info'] ); ?> 
                                           
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                         
                                    <td nowrap><?= Html::a(' <i class="fa fa-file-text"></i>'." ".$row1["reqtostock_id"],
                                    Url::to(['request-to-stock/view','id'=>$row1["reqtostock_id"]]), ['class'=>'action-viewx']) ?></td>
                            
                                            <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row1['staff_id']."' and pp.status=1 "; 

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                            echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
                                            </td>
                                            
                                             <td><?php 
                                             $status= $row1["status"];
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


$('.table-responsive').on('scroll', function() {
   console.log('scroll');
});

 $('.archive-action').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Stock Voucher will be archived !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, archive  it!'
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