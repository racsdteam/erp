<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Used Fuel  requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-to-stock-index">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>All Used Fuel Vouchers</h3>
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
    
        
 $q1=" SELECT r.*  FROM  fuel_voucher_info  as r   order by r.timestamp desc";
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
                                        <th>Date</th>
                                           <th>Car</th>
                                          <th>Driver</th>
                                          <th>Item</th>
                                          <th>Quantity</th>
                                             <th>User</th>
                                             
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row1):
                                      $i++;
                                      $q7=" SELECT * FROM items_request where id='".$row1['item_request_id']."' ";
                                   $command7= Yii::$app->db1->createCommand($q7);
                                        $row7 = $command7->queryone(); 
                                          $q11=" SELECT * FROM   items as i where i.it_id='".$row7['it_id']."' ";
                                    $com11 = Yii::$app->db1->createCommand($q11);
                                     $row11 = $com11->queryOne();
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr>
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                         </td> 
                                     
                                
                                    <td nowrap>  
                                     <div style="text-align:center" class="centerBtn">
                             
                                    <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                             Url::to(["request-to-stock/update-fuel-out",'id'=>$row1['id']
                                           ])
                                          ,['class'=>'btn-warning btn-sm active','title'=>'Edit Fuel Out' ] ); ?>|
                                          
                                           <?=Html::a('<i class="fa fa-trash"></i> Delete',
                                              Url::to(["request-to-stock/delete-fuel-out",'id'=>$row1['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete Fuel Out'] ); ?> 
                                          </div>
                                          </td>
                            <td><?= $row1['date'] ?></td>
                            <td><?= $row1['car'] ?></td>
                            <td><?= $row1['driver'] ?></td>
                            <td><?= $row11['it_name'] ?></td>
                            <td><?= $row7['out_qty']." ". $row11['it_unit'] ?></td>
                                       <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row1['user_id']."' and pp.status=1"; 

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                            echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
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


 

$('.action-delete').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Used Fuel Voucher will be Deleted !",
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



