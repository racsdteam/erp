<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\ActiveForm;

use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
?>


 <?php
 $ser_domain='https://rac.co.rw';
 

$url=Url::to(['erp-travel-clearance/pdf-data','id'=>$id]);
             $full_path=$ser_domain.$url;
            
             $serverURL=Url::to(['erp-travel-clearance-annotations/annotations-handler']);
 ?>


<div style="height: 600px;" id="tcviewer"></div>



           

  <!--commenting   --> 
  
          <?php

$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.*,s.signature from user  as u inner join erp_persons_in_position  as 
        pp on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id left join signature as s on u.user_id=s.user where pp.person_id={$user_id} ";
        $com2 = Yii::$app->db->createCommand($q2);
        $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
        // $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
         $fn=$row['first_name'];
         $ln=$row['last_name'];
         $position=$row['position'];
         $signature=$row['signature'];
 
       

$script = <<< JS
var user = {fn: "{$fn}", ln:"{$ln}", pos:"{$position}",signature:"{$signature}"};

showViewer( '{$full_path}','{$serverURL}','{$id}', user ,'tcviewer' );
 
JS;
$this->registerJs($script);

?>

