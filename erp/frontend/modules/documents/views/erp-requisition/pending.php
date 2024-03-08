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

 <?php
            
      $session=Yii::$app->session;
     
      $user=Yii::$app->user->identity->user_id;
            
            
             if ( $session->hasFlash('success')){

         Yii::$app->alert->showSuccess( $session->getFlash('success'));
                }
  
 
   if ( $session->hasFlash('error')){

         Yii::$app->alert->showError( $session->getFlash('error'));
            }
            
            ?>

<?php  

$query = ErpRequisitionApprovalFlow::find()->alias('main');
$subQuery = ErpRequisitionApprovalFlow::find()->alias('sub')
                                               ->select([new \yii\db\Expression('MAX(id) AS id'),'pr_id'])
                                               ->where(['sub.approver'=>$user,'sub.status'=>'pending'])
                                               ->groupBy('pr_id');

  $pendingApprovals=$query->innerJoin(['m' => $subQuery], 'm.id = main.id ')->orderBy(['timestamp'=>SORT_DESC])->all();
         

?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center"> Actions</th>
                                        <th>PR Code</th>
                                        <th>Requisition For</th>
                                        <th>Title</th>
                                        <th>Requested</th>
                                        <th>Requested By</th>
                                        <th>Status</th>
                                        
                                        <th>Received</th>
                                        <th>Received  From</th>
                                        <th>Comment</th>
                                       
                                       
                                      
                                      
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($pendingApprovals  as $app):?>
                                    <?php 
       $req=$app->requisition;
                                     $i++;
                                     
                       if($req!=null) {             
                                     
                                    ?>
                                    
        
                                    <tr class="<?php if($app->is_new=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                                                           <td nowrap>
                                              
                                              
                                              <div style="text-align:left" class="centerBtn">
        <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$req->id,'status'=>$req->approve_status,
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info']); ?>
                                          
                                          <?php
                                          if( ($req->isOwner($user) && !$req->isApproved()) 
                                          ):
                                          ?>
                                           |
        <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-requisition/update",'id'=>$req->id,
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-updatex','title'=>'Update Purchase Requisition Info']); ?>
                                        <?php 
                                        endif;
                                        ?>
                                        
                                        
                                           |
       
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-requisition/done",'id'=>$req->id,
                                           ])
                                          ,['class'=>'btn-success btn-sm active archive-action','title'=>'Purchase Requisition Info']); ?>
                                           
                                          
                                          
                                          
                                            <?php
                                            
                                            
                                            if($req->isApproved()){
              
  
  //----------------check request exist
                                         
                                      $q11="SELECT lpo_r.* FROM erp_lpo_request as lpo_r inner join  erp_requisition  as r   on r.id=lpo_r.request_id
 where lpo_r.request_id='".$req->id."' and lpo_r.type='PR' and  lpo_r.status IN ('processing' ,'approved','processed','completed') ";
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
                                              Url::to(["erp-lpo-request/create",'request_id'=>$req->id,'type'=>'PR'])
                                          ,['class'=>'btn-success btn-sm active',
                                       
'title'=>'create new request'] );                                                 
                                         }
                                         
                                         
                                            }
                                      
                                         ?>                                    
                                       
                                          </div>
    </td>  
                                    
                                    
                                    
                <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$req->requisition_code,Url::to(['erp-requisition/view-pdf','id'=>$req->id]), ['class'=>'pr_code']) ?></td>
                                 
                                 
                                         <td>
                                            <?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$req->category->type.'</small>';
                                         
                                          ?>
                                          
                                          
                                            <td>
                                            <?=
                                           $req->title ;
                                            
                                           ?>
                                          
                                         </td>
                                         
                                          <td><?php  
                                            
                                          echo $req->requested_at
                                            
                                            ?></td>
                                            
                                             <td><?php  
                                             
                                             
                                        echo $req->creator->first_name." ".$req->creator->last_name." [".$req->creator->findPosition()->position ."]"; 
                                            
                                            ?></td>
                                         
                                         <td><?php 
                                         
                                         $status=$req->approve_status;
                                             
                                             if( $status=='processing' ||  $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if( $status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                                                                        //--------------------------------------------CHECK STATUS FOR PAA--------------------------------------------------------------//
             $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".$user."'  and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


if($row7['position_level']=='pa'){
    
 //----------------find who he reports to------------------------------------------------------
 $q8=" SELECT u.user_id FROM user u 
inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
where pp.position_id={$row7['report_to']}";

$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();

if(!empty($req->id))
{
//----------------------get status--------------------------------------------
  $q="SELECT f.* FROM erp_requisition_approval_flow  as f
 where approver={$row8['user_id']}  and f.pr_id={$req->id} order by timestamp desc  ";
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
                                             
                                           
                                         
                                          <td><?php echo $app->timestamp; ?></td>
                                         
                                         
                                          
                                         </td>
                                           
                                              <td><?php 
                                             
                                 $originator=$app->orginatorUser;     
                                             
                         echo  $originator->first_name." ". $originator->last_name." [". $originator->findPosition()->position ."]"; 
                                             
                                             ?></td>
                                            
                                            
                                        
                                           <td><div class="remark"><?php echo '<em>'.$app->remark.'</em>'; ?></div></td>
                                            
                                            
                           
                                  
                 

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



