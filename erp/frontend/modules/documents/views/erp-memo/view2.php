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
use common\models\UserHelper;



$creator=$model->creator;
$position=$model->creator->findPosition();
$orgUnit=$model->creator->findOrgUnit();

//-----------------------------memo info--------------------------------------------
 $q=" SELECT * FROM  erp_memo  as m  inner join erp_memo_categ as c on c.id=m.type  
 where m.id='".$model->id."' ";
 $com = Yii::$app->db->createCommand($q);
$row = $com->queryOne();
$datetime= explode(" ",$row['created_at']);  
$date= $datetime[0];   



//---------------------------------creator signature-------------------------------------------
$q8=" SELECT * from signature where user=".$model->created_by." ";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne(); 


//-----------------------------memo approvals status-----------------------------------------------------------
$q9=" SELECT distinct(approved_by), approved  FROM erp_memo_approval  where memo_id='".$model->id."' order by 	approved desc ";
$command = Yii::$app->db->createCommand($q9);
$rows9 = $command->queryAll();

//---------------------------memo comments-----------------------------------------------------------------------

$q10=" SELECT *  FROM erp_memo_approval_flow  where memo_id='".$model->id."' ORDER BY 	timestamp desc ";
$command = Yii::$app->db->createCommand($q10);
$rows10 = $command->queryAll();

//----------------------------------unit depart office------------------------------------------------------------
$q11=" select u.unit_name,l1.level_name,u2.unit_name as parent,l2.level_name as parent_level from erp_org_units as u 
inner join erp_org_units as u2 on u2.id=u.parent_unit inner join erp_org_levels as l1 on l1.id=u.unit_level 
inner join erp_org_levels as l2 on l2.id=u2.unit_level and u.id=(SELECT pp.unit_id from erp_persons_in_position as pp where pp.person_id={$row['created_by']} 
and pp.position_id={$row['user_position']} and pp.status=1) ";
$command11 = Yii::$app->db->createCommand($q11);
$row11 = $command11->queryOne();


//----------------------------------Last Approval------------------------------------------------------------
$query_last_approver=" SELECT 	final_approver FROM erp_memo_approval_settings  where memo_id='".$model->id."' order by timestamp desc ";
$command = Yii::$app->db->createCommand($query_last_approver);
$last_approval_setting = $command->queryOne();
$last_approval=UserHelper::getPositionInfo($last_approval_setting ["final_approver"]);
?>
<style>
.img{background-color: #e6e6e6}
p,h1,h2,h3,h4 {
  font-family: "Times New Roman", Times, sans-serif;
}
</style>



<table style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<td align="left"><img src="<?=Yii::$app->request->baseUrl?>/img/logo.png" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="<?=Yii::$app->request->baseUrl?>/img/rightlogo.png" height="100px"></td>

</tr>
<tr><td colspan="2" class="text-uppercase" style="padding:20px;font-size:12px;" align="left">
    
   <?php if($orgUnit->parent!=null && (!in_array($orgUnit->parent->type->level_name , array('Office','Organization')))) :?>
    
<h4 ><b><?=$orgUnit->parent->type->level_name ?>: <?=$orgUnit->parent->unit_name  ?></b></h4><br><br>
    <?php endif;?> 
 
 <h4><b><?=ucfirst(strtolower( $orgUnit->type->level_name))  ?>: <?=$orgUnit->unit_name   ?></b></4><br><br>
 <h4><b>Date: <?=$date ?></b></h4><br><br>



    </td>
    
    </tr>

<tr>
<td colspan="2" style="border:1px solid black;" align="left"><h2><b>MEMO</b></h2></td>
</tr>

<tr>
<td style="width:50% ; border:1px solid black;"  align="left" valign="top">
<br>
From: <b><?= $creator->first_name." ".$creator->last_name; ?></b><br><br>

Position: <b><?= $position->position ?></b><br><br>

Date: <b><?=$date ?></b><br><br>

Signature:</b><br> <img src="<?=Yii::$app->request->baseUrl."/".$row8['signature'] ?>"   height="100px" width="200">
</td>
<td style="border:1px solid black;"  align="left" valign="top">
<br>
<table>



<?php 
if($row["status"]!="approved" && $row["status"]!="Returned"){
    ?>
    <tr>
    <td>To <?php  echo $last_approval["position"];?></td>
    <td></td>
    <td></td>
    </tr>
<?php
}
?>
    <?php foreach($rows9 as $row9): ?>
<?php 
 
$q9=" SELECT p.position,p.position_code,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where pp.person_id='".$row9['approved_by']."' and pp.status=1";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                                           
                                 
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row99 = $com->queryOne();           
                                           
                                           ?>
                                   
<?php if($r9['position_code']=='MD'|| $row9['approved_by']==$row99['person_in_interim'])  :
    $ignature=$r9['signature'];
    $date32=   $row9['approved'];
break;
else:
continue;
endif?>
<?php  endforeach; ?>
<tr>
<td><?php if(!empty($ignature)){?>To Managing Director:<?php } ?></td>
<td><?php if(!empty($ignature)){?><img src="<?= Yii::$app->request->baseUrl."/".  $ignature ?>" height="40px"><?php } ?> </td>
<td><?php  echo $date32;?></td>
</tr>

<?php  foreach($rows9 as $row9):
$q999=" SELECT a.approval_action FROM erp_memo_approval as a where a.approved_by='".$row9['approved_by']."' and memo_id='".$model->id."' and approved = '".$row9['approved']."' ";
$command999= Yii::$app->db->createCommand($q999);
$r999 = $command999->queryOne(); 
?>
<tr>
<?php 
if($r999['approval_action']=='approved' || $r999['approval_action']=='confirmed')
{
$q9=" SELECT p.position, p.position_code, u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where pp.person_id='".$row9['approved_by']."' and pp.status=1";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                                           
                                 
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row99 = $com->queryOne();           
                                           
                                           ?>
                                   
<?php if($r9['position_code']!='MD' && $r9['position_code']!='AAMD')  :?>
<td>Through :<br><?= $r9['position']?></td><td><img src="<?= Yii::$app->request->baseUrl."/". $r9['signature'] ?>" height="50px"></td> <td><?php  echo $row9['approved'];?></td>
 <?php  endif?>

</tr>
 <?php } endforeach; ?>
 
 </table>
</td>
</tr>

<tr>
<td colspan="2" style="border:1px solid black; " align="center"><h2><b><?= $row['title'] ?></b></h2></td>
</tr>
</table>


<!--memo description  -->
<?=$row['description']  ?><br><br>

