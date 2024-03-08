<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpMemoAttachMerge;
use common\models\ErpMemoRequestForAction;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;



 $q=" SELECT r.*,s.name,s.country,s.city FROM  reception_goods as r inner join supplier as s on s.id=r.supplier where r.id='".$model->id."' ";
 $com = Yii::$app->db1->createCommand($q);
 $row = $com->queryOne();


$datetime= explode(" ",$row['timestamp']);  
$date= $datetime[0];   

$q7=" SELECT * FROM items_reception 
where reception_good='".$row['id']."' ";
$command7= Yii::$app->db1->createCommand($q7);
$rows7 = $command7->queryAll(); 

?>

<style>


.table-b th{
  border:none;
    
    
}
  
  
  </style>

<table  style="width:100%;" id="maintable" cellspacing="0" cellpadding="10">
<tr>
<td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" colspan="3" align="center"><h3>PROCES VERBAL DE RECEPTION</h3><br><h3>RECEPTION OF GOODS</h3></td>
</tr>

<tr>
<td  class="text-uppercase" colspan="2" style="font-size:12px;" align="left" valign="top">

    
<h4 ><b>Supplier (Fournisseur): <?=$row['name']  ?></b></h4><br><br>
 <h4><b>Address: <?=$row['country']."/".$row['city']  ?></b></h4>
 
 </td>
 <td  class="text-uppercase" colspan="2" style="font-size:12px;" align="left" valign="top">

 <h4><b>N0: <?=$row['number'] ?></b></h4><br><br>
 <h4><b>Date: <?=$row['reception_date'] ?></b></h4><br><br>
<h4><b>Purchase Order N0: <?=$row['purchase_order_number'] ?></b></h4><br>
<h4><b>(N0 Bon de commande)</b></h4>
</td>
</tr>

</table>


                               <table  class=" table  table-bordered  table-responsive" style="width:100%; " cellspacing="0" cellpadding="0">
                                  <thead style=" display: table-row-group">
                                        <tr>
                                        
                                        <th >No</th>
                                        <th >Designation</th>
                                        <th >Unit</th>
                                        <th >Unit Price</th>
                                        <th >Quantity Ordered</th>
                                        <th >Quantity Delivered</th>
                                        <th >Amount Ordered</th>
                                        <th >Amount Delivered</th>
                                        <th>Balance Qty</th>
                                        <th>Balance Amount</th>
                                       
                                        </tr>
                                   
                                   </thead>
                                  
                                 
                                   
                                     
                                  <?php $i=0;  $sum=0; foreach($rows7 as $row7):?>
                                   <?php 
                                   
                                   $i++; 
                                   
                                    $q11=" SELECT * FROM   items as i where i.it_id='".$row7['item']."' ";
                                    $com11 = Yii::$app->db1->createCommand($q11);
                                     $row11 = $com11->queryOne();
                                     $item_price=$row7["item_qty"]*$row7["item_unit_price"];
                                   $sum=$sum+$item_price;
                                   ?>
                                   
                                     <tr>
                                     <td >
                                     <?php echo   $i; ?>
                 
                                     </td>
                                            <td><?php echo $row11["it_code"].' / '.$row11["it_name"] ; ?></td>
                                              <td ><?php echo $row11["it_unit"]; ?></td>
                                                 <td ><?php echo number_format($row7["item_unit_price"]); ?></td>
                                          <td ><?php echo $row7["item_qty_ordered"]; ?></td>
                                          <td ><?php echo $row7["item_qty"]; ?></td> 
                                          <td ><?php echo number_format($row7["item_qty_ordered"]*$row7["item_unit_price"]) ; ?></td>
                                          <td ><?php echo number_format($row7["item_qty"]*$row7["item_unit_price"]) ; ?></td> 
                                            <td ><?php  echo number_format($row7["item_qty"]-$row7["item_qty_ordered"]);?>
                                           <td ><?php  echo number_format(($row7["item_qty"]*$row7["item_unit_price"])-($row7["item_qty_ordered"]*$row7["item_unit_price"]));?>
                                          </td>
                                    
                                        </tr>
                                    
                                    <?php endforeach;?>
                                   <tr>
                               <td colspan="8"><b>Total Amount Delivered:</b></td><td colspan="2"><?= number_format($sum)?></td>
                               </tr>
                                    <tr>
                               <td colspan="10"><b>Observations:</b>:<?= $row['observation']?></td>
                               </tr>
                               <tr>
                               <td colspan="5"><b>End User department:</b>:<br>
                               <?php 
                               $q9=" SELECT p.position_code,p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  
                               erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where u.user_id='".$row['end_user_officer']."' ";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                               
                               ?>
                               
                               Names:  <?= $r9['first_name']?> <?= $r9['last_name']?><br>
                               Signature:  <img src="<?= Yii::$app->request->baseUrl."/". $r9['signature'] ?>" height="50px"> 
                              
                               </td>
                               <td colspan="5">
                               <br>
                                 <b>Store Keeper:</b>:<br>
                               <?php 
                               $q9=" SELECT p.position_code,p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where u.user_id='".$row['store_keeper']."' ";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                               
                               ?>
                               
                               Names:  <?= $r9['first_name']?> <?= $r9['last_name']?><br>
                               Signature:  <img src="<?= Yii::$app->request->baseUrl."/". $r9['signature'] ?>" height="50px"> 
                               </td>
                               </tr>
                               </table>
<b> Manager Logistic signature:</b>
 
     
     
