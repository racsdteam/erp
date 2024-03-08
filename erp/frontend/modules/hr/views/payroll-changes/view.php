<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
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
</table>

<h2 class="text-center" style="text-align: center;"><b><u><?= $model->title ?></u></b></h2>
<!--memo description  -->
<?=$model->description ?><br><br>

