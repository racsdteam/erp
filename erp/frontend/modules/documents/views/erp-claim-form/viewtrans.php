<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpClaimFormApproval;
 
?>

<style>
 .panel-heading{
     
     font-family: "Times New Roman", Times, serif;
     font-weight: bold;
     font-size:16px;
 } 
 
 .td-table1{
     
   width:50%;
   height:25px;
 }
 .td1-table2{
     
   width:2%;
   height:25px;
 }
  .td2-table2{
     
   width:48%;
   height:25px;
 }
 .list-inline li{
     
    
 }
.timeline{
   
    font-weight:bold;
    font-family: "Times New Roman", Times, serif;
    width:50%;
}
 
 .comment{padding-left:5px;}
 #maintable tr td{
   padding-left:5px;  
     
 }
 
 .empty-cell{width:10%;}
 .empty-cell2{width:10%;}
}   
</style>
<div class="container">
    
    <div class="row">
        
        <div class="col">
           <div style="margin-bottom:15px;" class="panel-heading">RWANDA AIRPORTS COMPANY</div> 
        </div>
        
    </div>
    
     <div class="row">
        
        <div class="col">
           <div style="text-decoration:underline;margin-bottom:5px;" class="panel-heading">TRANSIMISSION SLIP</div> 
        </div>
        
    </div>
    
     <div class="row">
         
         <div class="col">
             
            <table border=1 style="width:100%;height:auto; empty-cells: show; " id="maintable" cellspacing="0" cellpadding="10">
<tr>
<td style="padding:15px;" colspan="5"  align="left">No :</td>

<td   align="left">Received by :</td>
</tr>
<tr>
<td  style="padding:15px;"  colspan="5" align="left">DEPARTMENT :</td>

<td  align="left">To be handled by :</td>
</tr>
<tr>
<td  colspan="5" align="left">&nbsp;</td>

<td  align="left">&nbsp;</td>
</tr>

<tr>
    
 <td border=0 colspan="6"  align="left">&nbsp;</td>   
</tr>

<tr>
<td style="padding:15px;"  class='empty-cell'>&nbsp;</td>

<td  colspan="2"  align="left">For Signature :</td>

<td class='empty-cell'>&nbsp;</td>

<td colspan="2"  align="left">For follow up :</td>

</tr>
<tr>
<td style="padding:15px;"  class='empty-cell'></td>

<td  colspan="2"  align="left">For Approval :</td>
<td class='empty-cell'></td>

<td  colspan="2" align="left">For Comments :</td>

</tr>
<tr>
<td style="padding:15px;"  class='empty-cell'></td>

<td colspan="2"  align="left">As Requested :</td>
<td class='empty-cell'></td>

<td  colspan="2" align="left">For Information :</td>

</tr>

<tr>
<td style="padding:15px;"  class='empty-cell'></td>

<td colspan="2"  align="left">As agreed :</td>
<td class='empty-cell'></td>

<td colspan="2" align="left">For Your Files :</td>

</tr>

<tr>


<td   colspan="6"  align="left">
 
<span class="panel-heading">Status :</span>

<?php $items0=['normal'=>'Normal','urgent'=>'Urgent','immediate'=>'Immediate','very urgent'=>'Very Urgent'];

foreach($items0 as $item){
   
   echo '<span>'. $item .'</span>';
   echo str_repeat("&nbsp;", 10);
    
}

?>

  
</td>


</tr>
</tr>
<tr>
<td  colspan="6"><span class="panel-heading">Comment(s)</span></td>
</tr>
<?php  
$comments=ErpClaimFormApproval::find()->where(['claim_form'=>$id])->all();

foreach($comments as $comment)
 {
$datetime = explode(" ",$comment['approved']);
$date = $datetime[0];
$time = $datetime[1];

$q8=" SELECT p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                            left join  signature  as s on s.user=u.user_id
                                           where pp.person_id='".$comment['approved_by']."' ";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne();

?>
<tr>
 <td style="padding:20px;width:200px;"colspan="2">
    <p  class="timeline" >
Date : <?=date('d/m/Y', strtotime($date)); ?>   
</p>

<p  class="timeline" >
    
 Time : <?=$time?>   
</p> 
     
     
 </td> 
 
 <td class="comment" colspan="4">
<p><?php echo $comment['remark']?>
</p>

 <p>   
 <?= $row8['position']." [".$row8['first_name']." ".$row8['last_name']." ]" ?>&nbsp;&nbsp;&nbsp;<img src="<?= Yii::$app->request->baseUrl."/".$row8['signature']?>" height="30px">
</p>


</td>
    
</tr>



<?php }?>

</table>   
             
         </div>
         
       
         
     </div>
    
   
    
    
    </div>