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
  th {

text-align: center;
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header">
   <h3 class="card-title"><i class="fa fa-edit"></i> Drafts</h3>
 </div>
 <div class="card-body">
    <?php
    
     
  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
    
    $q=" SELECT m.*,c.categ_code,c.categ  FROM erp_memo as m
 inner join erp_memo_categ as c  on c.id=m.type  
   where m.created_by='".Yii::$app->user->identity->user_id."' and m.status='drafting' order by m.created_at desc ";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
      $i=0;
    ?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>#Memo Code#</th>
                                          <th>Title</th>
                                          <th>Memo Type</th>
                                        
                                         <th>Created</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                   <?php $i++; ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                       <td>  <?=
                                           $i;
                                            
                                           ?></td>
                                           
                                         <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-memo/view-pdf",'id'=>$row['id'],'status'=>$row["status"]
                                           ])
                                          ,['class'=>'btn btn-info btn-sm ','title'=>'View Memo Info'] ); ?> | 
                                            
                                           
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-memo/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm ','title'=>'Update Memo Info','disabled'=>$row["status"]!='drafting'] ); ?> |
                                         
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["erp-memo/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn btn-danger btn-sm action-delete','title'=>'Deelete Memo Info','disabled'=>$row["status"]!='drafting'] ); ?> 
        </div>     
                                            
                                            
                                        </td>    
                                           
                                    <td><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row["memo_code"],Url::to(["erp-memo/view-pdf",'id'=>$row['id'],'status'=>$row["status"]
                                           ])
                                          , ['class'=>'kv-author-linkx']) ?></td>
                                    <td>
                                            <?=
                                           $row["title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                             <?php
                                          
                                          
                                           if( $row['categ_code']=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fa fa-opencart"></i>';
                                     }
                                     else if( $row['categ_code']=='TR'){
                                         $label='Travel Request';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
                                     }
                                      else if( $row['categ_code']=='RFP'){
                                         $label='Request For Payment';  
                                         $class="label pull-left bg-orange";
                                         $fa='<i class="fa fa-money"></i>';
                                     }
                                     else{
                                          $label=$row['categ'];
                                          $fa='<i class="fa fa-file-o"></i>';
                                          $class="label pull-left bg-pink";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';
                                           
                                           
                                            
                                           ?>
                                          
                                          
                                          
                                         </td>
                                         
                                        
                                           
                                       
                                           
                                            <td><?php echo $row["created_at"] ; ?></td>
                                            
                                             <td><?php  
                                             if($row["status"]=='processing' || $row["status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='drafting'){
                                                  $class="label pull-left bg-graw";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'. $row["status"].'</small>'; ?></td>
                                            
                                             
      
                                             
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
  text: "Memo will be Deleted !",
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



