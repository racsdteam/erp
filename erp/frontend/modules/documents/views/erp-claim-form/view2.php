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


 $q=" SELECT * FROM erp_claim_form as c where c.id='".$model->id."' ";
 $com = Yii::$app->db->createCommand($q);
 $row = $com->queryOne();


$datetime= explode(" ",$row['timestamp']);  
$date1= $datetime[0];

//------------------------------------claimant----------------------------------------------------------
$idperson=$row['employee'];
$q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$idperson."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

//----------------------------------------claimant unit-------------------------------------------------------
$q81=" SELECT * FROM erp_org_units where id='".$row7['unit_id']."' ";
$command81= Yii::$app->db->createCommand($q81);
$row81 = $command81->queryOne();


//-------------------------------------------------requestor----------------------------------------------------
$q82=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['created_by']."' ";
$command82= Yii::$app->db->createCommand($q82);
$row82 = $command82->queryOne(); 

//----------------travel request-associated-----------------
if(!empty($row['tr_id']))
{
 $q9=" SELECT * FROM erp_travel_request where id='".$row['tr_id']."' ";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 

$Destination=$row9['destination'];
$particulars="Allowance";
$from=$row9['departure_date'];
$to=$row9['return_date'];
}else{
 $q9=" SELECT * FROM  erp_claim_form_details where claim_form='".$row['id']."' ";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 
$Destination=$row9['country'];
$particulars=$row9['pariculars'];
$from=$row9['from'];
$to=$row9['to'];
}

?>
<style>
body {
  font-family: "Times New Roman", Times, serif;
  color:black;
}

</style>
<table class="table " style="width:100%;margin-bottom:40px;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<td  align="left"><img src= "https://rac.co.rw/erp/img/logo.png" alt="left logo"  height="100px"></td>
<td  align="right"><img src="https://rac.co.rw/erp/img/rightlogo.png" alt="Right logo" height="80px"></td>
</tr>
<tr>
<td style="padding:30px 25px" colspan="2" align="left"><h4>
    
    <b>STAFF CLAIM FORM</b>

</h4></td>
</tr>

<tr>


<td><b><h4>DATE:</b></h4></td><td style="padding:10px 0px"><?=$date1 ?></td>
</tr>

   
   
        
     <tr><td><b>Name of Claimant:</b></td><td style="padding:10px 0px"> <?= $row7['first_name']." ".$row7['last_name']; ?></td></tr>
       <tr><td><b>Position/Title:</b></td><td style="padding:10px 0px"> <?= $row7['position'] ?></td></tr> 
         <tr><td><b>Claim For:</b></td><td style="padding:10px 0px"><?= $row['purpose'] ?></td></tr> 
           <tr><td><b>Department/Unit/office:</b></td><td style="padding:10px 0px"><?= $row81['unit_name'] ?></td></tr> 
           <tr><td><b>Title of Mission /Training:</b></td><td style="padding:10px 0px"><?= $row9['purpose'] ?></td></tr> 
   



</table>


<table class="table-bordered table "  style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
    <th colspan="4" align="center" style="padding:0 20px">(PARTICULARS  (MUST BE SHOWN IN FULL)</th>
    <th></th>
    <th></th>
     <th align="center"  style="padding:0 20px">AMOUNT</th>
</tr>
<tr><th  style="width:5%; ">No</th>
     <th   style="width:20%; ">PARTICULARS</th>
     <th  style="width:20%; "><?php if($row9['type']==1){echo 'Destination';}else{echo 'Country';} ?></th>
     <th  style="width:20%; ">DATES</th>
     <th style="width:15%; ">N°. OF DAYS</th>
     <th  style="width:12%; ">RATES(<?php echo $row['currancy_type']=='USD'?'$':'RWF' ?>) </th>
     <th align="center" style="width:13%; ">TOTAL(<?php echo $row['currancy_type']=='USD'?'$':'RWF' ?>)</th>
</tr>
<tr><td style="width:5%; ">1</td>
     <td style="width:20%; "><?= $particulars ?></td>
     <td style="width:20%; "><?= $Destination ?></td>
     <td style="width:20%; ">
         <?php $d1  = strtotime($from); 
        $day   = date('d',$d1);
        $month = date('m',$d1);
        $year  = date('Y',$d1);
        
        echo  $day."/".$month." to ".date("d/m/Y", strtotime($to))
         ?>
         
         
         </td>
     <td align="center" style="width:10%; "><?= $row['day'] ?></td>
     <td align="right" style="width:10%; "><?= $row['rate'] ?></td>
     <td align="center" style="width:20%; "><?= $row['total_amount'] ?></td>
</tr>

<tr><td style="width:5%; "></td>
     <td style="width:20%; "><b>ToTAL</b></td>
     <td style="width:20%; "></td>
     <td style="width:20%; "></td>
     <td style="width:10%; "></td>
     <td style="width:10%; "></td>
     <td align="center" style="width:20%; "><?= $row['total_amount'] ?></td>
</tr>
</table>

 <table class=" "  style="width:100%;"  cellspacing="0" cellpadding="0">
            
                                     <tr>
                                        <th align="left">Amount in words:</th>
                                        <td style="width:61%; background: url('img/dot.gif') 0 75% repeat-x;padding:15px 0; color:black;font-size:20px;" nowrap>
                                            <?= $row['total_amount_in_words']  ?></td>
                                      
                                       
                                        
                                         <th align="left">Date:</th>
                                       
                                       <td style="width:15%; background: url('img/dot.gif') 0 68% repeat-x; color:black;font-size:20px;"></td>
                                       
                                       </tr> 
                                       
                                      
        </table>



<table class="" style="width:100%;" cellspacing="0" cellpadding="0">
<tr >
    
<th  align="left" style="padding:15px 0;white-space: nowrap;">Prepared by:</th>
<td  style="width:67%;background: url('img/dot.gif') 0 62% repeat-x; color:black;font-size:20px;">
<?php

echo $row82['first_name']." ".$row82['last_name'];


 
$date = date("d/m/Y", strtotime($date1));
                                       
                                         
                                         ?> 
 

 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"> <?php  echo $date; unset($date);?> </td>
</tr>

</table>

<!-- ------------------------------------------------------------------------------------------------------------->
<table class="" style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">

<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Signature of  claimant:</th>
<td  style="width:59%;background: url('img/dot.gif') 0 62% repeat-x">
<?php
                                       
                                         ?> 
 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>

<!-- -----------------------------end table-------------------------------------------------------------------------------->
<table class="" style="width:100%;"  cellspacing="0" cellpadding="0">
<br>
<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Recommended by: Head/HR </th>
<td style="width:53%;background: url('img/dot.gif') 0 62% repeat-x">
<?php ?> 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>


<!-- ------------------------------------------------------------------------------------------------------------->

<table class="" style="width:100%;"  cellspacing="0" cellpadding="0">
<br>
<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Verified by: Chief Accountant </th>
<td style="width:52%;background: url('img/dot.gif') 0 62% repeat-x">
<?php ?> 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>


<table class="" style="width:100%;"  cellspacing="0" cellpadding="0">
<br>
<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Certified by: Director Finance </th>
<td style="width:52%;background: url('img/dot.gif') 0 62% repeat-x">
<?php ?> 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>


<table class="" style="width:100%;"  cellspacing="0" cellpadding="0">

<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Certified by: DMD </th>
<td style="width:63%;background: url('img/dot.gif') 0 62% repeat-x">
<?php ?> 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>

<table class="" style="width:100%;"  cellspacing="0" cellpadding="0">

<tr>
<th align="left" style="padding:15px 0;white-space: nowrap;">Approved for Payment:Managing Director </th>
<td style="width:40%;background: url('img/dot.gif') 0 62% repeat-x">
<?php ?> 
 
 </td>
<th align="left">Date: </th>
<td style="width:15%;background: url('img/dot.gif') 0 62% repeat-x"><?php  echo $date; unset($date);?> </td>
</tr>
</table>



