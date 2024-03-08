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



//-----------------------------memo info--------------------------------------------
 $q=" SELECT * FROM  erp_memo  as m  inner join erp_memo_categ as c on c.id=m.type  
 where m.id='".$model->id."' ";
 $com = Yii::$app->db->createCommand($q);
$row = $com->queryOne();
$datetime= explode(" ",$row['created_at']);  
$date= $datetime[0];   

//-----------------------creator names and position---------------------------------------------
$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row['created_by']."' ";

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


//---------------------------------creator signature-------------------------------------------
$q8=" SELECT * from signature where user=".$row['created_by']." ";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne(); 

 

//-----------------------------memo approvals status-----------------------------------------------------------
$q9=" SELECT *  FROM erp_memo_approval  where memo_id='".$model->id."' order by approved desc ";
$command = Yii::$app->db->createCommand($q9);
$rows9 = $command->queryAll();

//---------------------------memo comments-----------------------------------------------------------------------

$q10=" SELECT *  FROM erp_memo_remark where memo='".$model->id."' order by timestamp desc ";
$command = Yii::$app->db->createCommand($q10);
$rows10 = $command->queryAll();

//----------------------------------unit depart office------------------------------------------------------------
$q11=" select u.unit_name,l1.level_name,u2.unit_name as parent,l2.level_name as parent_level from erp_org_units as u 
inner join erp_org_units as u2 on u2.id=u.parent_unit inner join erp_org_levels as l1 on l1.id=u.unit_level 
inner join erp_org_levels as l2 on l2.id=u2.unit_level and u.id=(SELECT p.unit_id from erp_persons_in_position as p where p.person_id={$row['created_by']}) ";
$command11 = Yii::$app->db->createCommand($q11);
$row11 = $command11->queryOne();

//-----------------------------supervisor of the claima---------------------------------------

 $q9=" SELECT p.report_to FROM erp_memo as m
  inner join user as u on u.user_id=m.created_by 
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 where erp_memo.id='".$model->id."' order by erp_memo.created_at desc";
 $com9 = Yii::$app->db->createCommand($q9);
$rows9 = $com9->queryOne();

 $q98=" SELECT * FROM erp_org_positions where id='".$rows9['report_to']."'";
 $com98 = Yii::$app->db->createCommand($q98);
$rows98 = $com98->queryOne();
//-----------------------------supervisor of the supervisor---------------------------------------

 $q999=" SELECT * FROM erp_org_positions where id='".$rows98['report_to']."'";
 $com999 = Yii::$app->db->createCommand($q999);
$rows999 = $com999->queryOne();
?>
<style>
.img{background-color: #e6e6e6}
p,h1,h2,h3,h4 {
  font-family: "Times New Roman", Times, serif;
}
</style>



<table style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<td align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>

</tr>
<tr><td colspan="2" class="text-uppercase" style="padding:20px;font-size:12px;" align="left">
    
    
    <?php if(!empty($row11['parent_level']) && $row11['parent']!=='Board of Directors') :?>
    
<h4 ><b><?=$row11['parent_level']  ?>: <?=$row11['parent']  ?></b></h4><br><br>
    <?php endif;?>
 <h4><b><?=$row11['level_name']  ?>: <?=$row11['unit_name']  ?></b></h4><br><br>
 <h4><b>Date: <?=$date ?></b></h4><br><br>



    </td>
    
    </tr>

<tr>
<td colspan="2" style="border:1px solid black;" align="left"><h2><b>MEMO</b></h2></td>
</tr>

<tr>
<td style="width:50% ; border:1px solid black;"  align="left" valign="top">
<br>
From: <b><?= $row7['first_name']." ".$row7['last_name']; ?></b><br><br>

Position: <b><?= $row7['position'] ?></b><br><br>

Date: <b><?=$date ?></b><br><br>

Signature:</b><br> <img src="<?= Yii::$app->request->baseUrl."/". $row8['signature'] ?>"  class="img" height="100px" width="200">
</td>
<td style="border:1px solid black;"  align="left" valign="top">
<br>
<table>

<tr>
<td>To MD:</td>
    <?php  foreach($rows9 as $row9): ?>
<?php 
 
$q9=" SELECT p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where pp.person_id='".$row9['approved_by']."' ";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                                           
                                  $q1=" SELECT person_id  FROM erp_persons_in_position where 	position_id='' order by id desc ";
                                         $com1= Yii::$app->db->createCommand($q1);
                                          $row1 = $com1->queryOne();
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row99 = $com->queryOne();           
                                           
                                           ?>
                                   
<?php if($r9['position']=='Managing Director'|| $row9['approved_by']==$row99['person_in_interim'])  :
    $ignature=$r9['signature'];
    $date32=   $row9['approved'];
break;
else:
continue;
endif?>
<?php  endforeach; ?>

<td><?php if(!empty($ignature)){?><img src="<?= Yii::$app->request->baseUrl."/".  $ignature ?>" height="40px"><?php } ?> </td>
<td><?php  echo $date32;?></td>
</tr>

<tr>
<?php  foreach($rows9 as $row9): 
 
$q9=" SELECT p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where pp.person_id='".$row9['approved_by']."' ";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                                           
                                  $q1=" SELECT person_id  FROM erp_persons_in_position where 	position_id='".$rows999['id']."' order by id desc ";
                                         $com1= Yii::$app->db->createCommand($q1);
                                          $row1 = $com1->queryOne();
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row99 = $com->queryOne();           
                                           
                                           ?>
                                   
<?php if($r9['position']==$rows999['position']  || $row9['approved_by']==$row99['person_in_interim']) :?>
<td>Through :<br><?= $r9['position']?></td><td><img src="<?= Yii::$app->request->baseUrl."/". $r9['signature'] ?>" height="50px"></td> <td><?php  echo $row9['approved'];?></td>
 <?php  
 endif;
 endforeach; 
 ?>
 </tr>
 <tr>
<?php  foreach($rows9 as $row9): 
 
$q9=" SELECT p.position,u.first_name,u.last_name,s.signature FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id left join  signature as s on s.user=u.user_id
                                           where pp.person_id='".$row9['approved_by']."' ";
                                           $command7= Yii::$app->db->createCommand($q9);
                                           $r9 = $command7->queryOne(); 
                                           
                                  $q1=" SELECT person_id  FROM erp_persons_in_position where 	position_id='".$rows98['id']."' order by id desc ";
                                         $com1= Yii::$app->db->createCommand($q1);
                                          $row1 = $com1->queryOne();
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row99 = $com->queryOne();           
                                           
                                           ?>
                                   
<?php if($r9['position']==$rows98['position']  || $row9['approved_by']==$row99['person_in_interim']) :?>
<td>Through :<br><?= $r9['position']?></td><td><img src="<?= Yii::$app->request->baseUrl."/". $r9['signature'] ?>" height="50px"></td> <td><?php  echo $row9['approved'];?></td>
 <?php  
 endif;
 endforeach; 
 ?>
 </tr>
 </table>
</td>
</tr>

<tr>
<td colspan="2" style="border:1px solid black; " align="center"><h2><b><?= $row['title'] ?></b></h2></td>
</tr>
</table>


<!--memo description  -->
<?=$row['description']  ?><br><br>

<!-- comments --->
<h3><b>Comments/ Remarks</b></h3>
<table class="table table-bordered table-hover" style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<th>
position
</th>
<th>
Name
</th>
<th>
Comments/ Remarks
</th>
<th>
Date Time
</th>
</tr>
<?php  foreach($rows10 as $row10): 
if(!empty($row10["remark"]))
$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row10["author"]."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
?> 
<tr>
<td><?= $row7["position"] ?></td>
<td ><?= $row7['first_name']." ".$row7['last_name']; ?></td>
<td ><?= $row10["remark"] ?></td>
<td ><?= $row10["timestamp"] ?></td>
</tr>
 <?php  endforeach; ?>

 </table>
 
