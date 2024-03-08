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

?>

<?php

$muser=Yii::$app->muser;

$userInfo=$muser->getUserInfo($model->created_by);
$userPos=$muser->getPosInfo($model->created_by);
$userUnit=$muser->getUnitInfo($model->created_by);
$parent=$userUnit->getParent();


$datetime= explode(" ",$model->created_at);  
$date= $datetime[0]; 
?>

<style>
body {font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td {
	text-align: left;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}


</style>


<table width="100%"><tr>
<td width="50%" style="text-align: left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td width="50%" style="text-align: right;"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>
</tr></table>

<br />

<table width="100%" style="font-family: sans;"><tr>
 
 <?php if($parent!=null && $parent->getLevel()->level_code !='O') :?>
 
  <td width="100%" style="text-align: left">
     <span style="font-weight: bold; font-size: 14pt;"><?=$parent->getLevel()->level_name?> :</span>
      </span>  <span style="font-weight: bold; font-size: 12pt;"> <?=$parent->unit_name?></span>
     </td>
     </tr>
 <?php endif?>

 <tr>
 <td width="100%" style="text-align: left">
     <span style="font-weight: bold; font-size: 14pt;"><?=$userUnit->getLevel()->level_name?> : </span>
     </span>  <span style="font-weight: bold; font-size: 12pt;"><?=$userUnit->unit_name?></span>
     </td>

</tr>

<tr>
 <td width="100%" style="text-align: left">
     <span style="font-weight: bold; font-size: 14pt;">Date : </span>  <span style="font-weight: bold; font-size: 12pt;"><?=$date?></span>
     </td>

</tr>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>

<td colspan="2" width="100%"><span style="font-weight: bold; font-size: 14pt;text-align:left">MEMO </span></td>

</tr>
</thead>
<tbody>
 <tr>
<td width="50%"><span style="font-size: 7pt; color: #555555; font-family: sans;">SOLD TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>

<td width="50%"><span style="font-size: 7pt; color: #555555; font-family: sans;">SHIP TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
</tr>   
</tbody>

</table>













