<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use yii\helpers\UserHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\LinkPager;
use yii\db\Query;
?>
<style>
    
   figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  /*border: thin silver solid;*/
  
}

    
</style>

 <?php

      $_user=Yii::$app->user->identity;
      $host=Yii::$app->request->hostInfo;
      $requestUrl=Url::to(['payrolls/pdf-data','id'=>$model->id,"approval_id"=>$approval_id]);
      $full_path=$host.$requestUrl;
     ?>

<?= Html::a('<i class="fas fa-flag text-warning"></i> Hold Payroll', ['copy-previous','id'=>$model->id], 
   ['class' => 'btn  btn-outline-danger btn-sm actiob-create mb-1','title'=>'Hold Payroll']) ?> 

<figure>
  <div style="height: 600px;" id="payroll-pdf-<?php echo $model->id ?>"></div>
  <figcaption><?php echo $model->name ?></figcaption>
 

</figure>






           

  <!--commenting   --> 
  
          <?php
 $serverURL=Url::to(['payroll-approval-annotations/annotations-handler']);
 $filename=$model->name;
 $id=$model->id;

 $position=$_user->findPosition();
 $orgUnit=$_user->findOrgUnit();
 
 $user=array();
 $user['fn']=$_user->first_name;
 $user['ln']=$_user->last_name;
 $user['role']= $_user->role->role_name;
 $user['signature']= $_user->signature->signature;
 $user['pos']= $position->position;
 $user['pos_code_u']= $position->position_code;
 $user['orgUnit']= $orgUnit->unit_name;
 
 $interim=$_user->findInterim();
 if($interim!=null){
    $position=$interim->userOnLeave->findPosition();
    $user['pos_code_int']=$position->position_code;
 }
$userEncoded=json_encode($user);

$script = <<< JS

$(function() {
  var user = $userEncoded;
 
  showViewer("{$full_path}","{$serverURL}","{$id}", user ,"payroll-pdf-{$id}","{$filename}");
});


JS;
$this->registerJs($script);

 ?>
