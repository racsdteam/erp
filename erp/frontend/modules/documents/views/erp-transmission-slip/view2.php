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
use common\models\ErpTransmissionSlipComments;

 
?>

<style>

 body,h1,h2,h3,h4,h6,h6,p{
  font-family: "Times New Roman", Times, serif;
  
} 

tr
	{
		
		color:black;
	}
	th
	{
	
		color:black;
	}
</style>

<table  style="width:100%;"  cellspacing="0" cellpadding="5">
<tr>
<td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>
</tr>

<tr>
<td style="padding:10px 0px,font-size:14px;" align="left"><b><h3>RWANDA AIRPORTS COMPANY</h3></b></td>
</tr>
<tr>
<td style="padding:5px 0px,font-size:14px;" align="left"><b><h3><u>TRANSIMISSION SLIP</u></h3></b></td>
</tr>

</table>  
  
             
 <table class="table  table-bordered  " style="width:100%;margin:10px 0" id="maintable" cellspacing="0" cellpadding="5">
<tr>
<td style=" width:50%"   align="left">No :</td>

<td  style="width:50%"  align="left">Received by :</td>
</tr>
<tr>
<td  style=" width:50%"   align="left">DEPARTMENT :</td>

<td  style=" width:50%" align="left">To be handled by :</td>
</tr>
<tr>
<td  style=" width:50%" align="left">&nbsp;</td>

<td style=" width:50%"  align="left">&nbsp;</td>
</tr>

</table> 

<table class="table  table-bordered  " style="width:100%;" id="maintable1" cellspacing="0" cellpadding="5"> 

<tr>
<td style="padding:0px 5px;">&nbsp;</td>

<td align="left">For Signature :</td>

<td style="padding:0px 5px;">&nbsp;</td>

<td align="left">For follow up :</td>

</tr>

<tr>
<td></td>

<td align="left">For Approval :</td>
<td></td>

<td  align="left">For Comments :</td>

</tr>

<tr>
<td></td>

<td   align="left">As Requested :</td>
<td></td>

<td align="left">For Information :</td>

</tr>

<tr>
<td></td>

<td  align="left">As agreed :</td>
<td ></td>

<td  align="left">For Your Files :</td>

</tr>

</table>

<?php 
   $s=['normal','urgent','immediate','very urgent'];
 
    ?>
<table>
    <tr>
<td  style="padding:10px" >Status :</td>

<?php  
   foreach ($s as $value) {
   
   if($model->severity==$value){
      
      $fa='<span class="fa fa-square">&#xf046;</span>'; 
       
     
   }else{
       
    $fa='<span class="fa fa-square">&#xf096;</span>';
       
   }
   
   echo  '<td style="padding:10px 40px" align="center">'.$fa.$value.'</td>';    
       
   }



?>

</tr>   
</table>

      
      
<h4>Comment(s)</h4> 

 

<table  class="table  table-bordered"  cellspacing="0" cellpadding="0">

<?php 

 $q1=" SELECT c.* FROM erp_transmission_slip_comments as c inner join erp_transmission_slip as t on t.id=c.trans_slip
where c.trans_slip={$model->id}  order by c.timestamp";
 $com1 = Yii::$app->db->createCommand($q1);
 $rows = $com1->queryAll(); 
var_dump($rows);
?>

<?php 
foreach($rows as $row) :
 
$datetime = explode(" ",$row['timestamp']);
$date = $datetime[0];
$time = $datetime[1];

$q8=" SELECT p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                            left join  signature  as s on s.user=u.user_id
                                           where pp.person_id='".$row['author']."' and pp.status=1";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne();

?>
<tr>
 <td>
<p>Date : <?=date('d/m/Y', strtotime($date)); ?> </p>    
 

<p>Time : <?=$time?>  </p> 
 
     
     
 </td> 
 
 <td>
<p><?php echo $row['comment']?>
</p>

 <p>   
 <?= $row8['position']." [".$row8['first_name']." ".$row8['last_name']." ]" ?>&nbsp;&nbsp;&nbsp;
 <img src="<?= Yii::$app->request->baseUrl."/".$row8['signature']?>"width :"300" height="60px">
</p>


</td>
    
</tr>



<?php  endforeach; ?>

</table>   
        
   
    
    
   