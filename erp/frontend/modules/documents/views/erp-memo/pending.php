<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use kartik\dropdown\DropdownX;
use yii\bootstrap\ButtonDropdown;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'pending Memos';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
{
  left: 50%;
  
  right: auto;
  text-align: center;
  transform: translate(-78%, 0);
  z-index:1 !important;
  overflow:hidden;
}

th {
    text-align:center
}

div.btn-group{
   margin-top:0;margin-bottom:0;
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-inbox"></i> Pending Memo(s)</h3>
 </div>
 <div class="card-body">
 <?php 
    
      
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
    
 $user= Yii::$app->user->identity->user_id;  
    
 $q=" SELECT f.*  FROM erp_memo_approval_flow as f
 where f.approver='".$user."'  and f.status='pending' order by f.timestamp desc ";
 $com = Yii::$app->db->createCommand($q);
 $rows = $com->queryAll();
 $i=0;

 $q7=" SELECT u.unit_name,u.unit_code,p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
 inner join erp_org_units as u on u.id=pp.unit_id
 where  pp.person_id='".$user."' and pp.status=1";
 $command7= Yii::$app->db->createCommand($q7);
 $row7 = $command7->queryOne();
 
 
                             
                              
                               if(($row7 ['unit_code']=='HRU' || $row7 ['unit_code']=='HRADMIN'  ) ){
      
       $is_in_hr=true;
  }else{
      
       $is_in_hr=false;
  }
  
                            
 
   //var_dump($is_in_hr);
 
    ?>
 <div style="overflow-y: hidden;" class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>#Memo Code#</th>
                                          <th>Title</th>
                                          <th>Memo For</th>
                                         <th>Submited</th>
                                          <th>Submited By</th>
                                         
                                          <th>Status</th>
                                           <th>Remark</th>
                                          
                                           
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row):
                                
                                  $q1=" SELECT m.*,c.categ_code,c.categ FROM erp_memo as m
 inner join erp_memo_categ as c  on c.id=m.type  
where m.id=".$row['memo_id']." and m.status!='expired' ";
     $com1 = Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryone();
    
     
     
     $i++;   
     
    if($row1!=null):
                                    
                                  
                                    
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                           </td>
                                           
                                           <td nowrap>
                            <div style="text-align:center">
                                
                               
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["erp-memo/view-pdf",'id'=>$row1['id']])
                                          
                                          ,['class'=>'btn  btn-info btn-xs  action-viexw','title'=>'View Memo Info'] ); ?> | 
                                            
                                          
                                          <?php if($row1['created_by']==Yii::$app->user->identity->user_id && $row1['status']!='approved' )  :?> 
                                          
                                          <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-memo/update",'id'=>$row1['id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm  ','title'=>'Update Memo Info'] ); ?> |
                                          
                                          <?php endif;?>
                                          
                                          <?php  
                                          
                                          if( $is_in_hr && $row1['status']=='approved') :?>
      
 
                                <?=Html::a('<i class="fa fa-plus-circle"></i> Create Travel Request',
                                              Url::to(["erp-travel-request/create",'memo'=>$row1['id']])
                                          ,['class'=>'btn btn-primary btn-sm ','title'=>'Create Travel Request'] ); ?> |          
                                          
                                          <?php endif;?>
                                           
                                            
                                          
                                          <?=Html::a('<i class="fa fa-archive"></i> Archive ',
                                              Url::to(["erp-memo/done",'id'=>$row['memo_id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm  archive-action','title'=>'Complete Memo Info'] ); ?> 
                                          
                                         
                                                 
                                         
                         </div>
                                   
                                          </td >
                                          
                                          <td nowrap>
                                         <?= Html::a('<i class="fa  fa-file-text-o"></i>'." ".$row1["memo_code"],Url::to(['erp-memo/view-pdf','id'=>$row1["id"]]), ['class'=>'']) ?>     
                                              
                                     
                                       </td>
                                    
                                    <td>
                                            <?=
                                           $row1["title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                            
                                            
                                             <?php
                                          
                                          
                                           if( $row1['categ_code']=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fa fa-opencart"></i>';
                                     }
                                     else if( $row1['categ_code']=='TR'){
                                         $label='Travel Request';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
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
                                         
                                        
                                           
                                           
                                            <td><?php echo $row["timestamp"] ; ?></td>
                                            
                                            <td><?php
                                            
                                            $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner 
                                            join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['originator']."' and pp.status=1 ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name']; 
                                            
                                           echo $full_name." [".$pos." ]"; ?></td>
                                            
                                             <td><?php 
                                             $status= $row1["status"];
                  
                                             
                                             
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='approved'){
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
where pp.position_id={$row7['report_to']} and pp.status=1";

$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();

 $rows2=array();

if(!empty($row8)){
    
  //----------------------get status--------------------------------------------
  $q="SELECT f.* FROM erp_memo_approval_flow  as f
 where approver={$row8['user_id']}  and f.memo_id={$row1['id']} order by timestamp desc  ";
     $com = Yii::$app->db->createCommand($q);
     $rows2 = $com->queryAll();  
}
 
    
    
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
                
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                            
                                             <td><div style="overflow: auto;height:150px;width:200px;"><?=$row['remark']?></div></td>
      
                                            

                                         
                                            
                          
                                        </tr>

                                     <?php 
                                    endif;
                                    ?>
                                    
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
/*
$('.dropdown').on('show.bs.dropdown', function () {
  $('body').append($('.dropdown').css({
    position:'absolute',
    left:$('.dropdown').offset().left, 
    top:$('.dropdown').offset().top
  }).detach());
});

$('.dropdown').on('hidden.bs.dropdown', function () {
  $('.bs-example').append($('.dropdown').css({
    position:false, left:false, top:false
  }).detach());
});*/

$('.table-responsive').on('scroll', function() {
   console.log('scroll');
});

 $('.archive-action').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Memo will be archived !",
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



