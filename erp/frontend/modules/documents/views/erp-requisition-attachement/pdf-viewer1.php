<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\ActiveForm;
use yii\bootstrap4\LinkPager;
use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
?>
<style>
    
   figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  border: thin silver solid;
  
}
I 
    
</style>

 <?php
 $ser_domain='https://rac.co.rw';
 $base_url=Yii::$app->request->baseUrl;
 
 foreach ($models as $model) { 
      
      $full_path=$ser_domain.$base_url."/".$model->attach_upload;
   
     ?>

<figure>
  <div style="height: 600px;" id="page4viewer<?php echo $model->id ?>"></div>
  <figcaption><?php echo $model->attach_name?></figcaption>
</figure>



<div class="page-linker" style="background:#f5f5f5;" >
    
 <?php 

echo LinkPager::widget([
    'pagination' => $pages,
    'options'=>['class' => 'pagination page-linker  justify-content-center align-items-center '],
]);

}?>   
</div>


</div>

           

  <!--commenting   --> 
  
          <?php
 $serverURL=Url::to(['erp-requisition-attachement-annotation/annotations-handler']);
 $id=$model->id;
 
$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.*,r.role_name,s.signature from user  as u 
        inner join user_roles as r on r.role_id=u.user_level
        inner join erp_persons_in_position  as 
        pp on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id left join signature as s on u.user_id=s.user where pp.person_id={$user_id} and pp.status=1 ";
        $com2 = Yii::$app->db->createCommand($q2);
        $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
        // $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
         $fn=$row['first_name'];
         $ln=$row['last_name'];
         $position=$row['position'];
         $pos_code_user=isset($row['position_code'])?$row['position_code']:'';
         $signature=$row['signature'];
         $role=$row['role_name'];
          
         
        

  $todate = date('Y-m-d');
  $todate=date('Y-m-d', strtotime($todate));
  //----------------------------check if interim for------------------------------------------>
$q8="SELECT * from erp_person_interim where  person_in_interim={$user_id} 
and date_from <= '$todate' and date_to >= '$todate'";
$command8= Yii::$app->db->createCommand($q8);
$row1 = $command8->queryOne();
$pos_code_int='';
 
if(!empty($row1)){
    
//---------------------get position code---------------------------------------
$q3="SELECT p.* from erp_org_positions as p inner join erp_persons_in_position as pp on pp.position_id=p.id where pp.person_id={$row1['person_interim_for']} and pp.status=1";
        $com3= Yii::$app->db->createCommand($q3);
        $row2 = $com3->queryOne();
       
        if(!empty($row2) && isset($row2['position_code'])){
            
            $pos_code_int= $row2['position_code'];
        }
}

       

$script = <<< JS
var fn="{$fn}";
var ln="{$ln}";
var role="{$role}";
var position="{$position}";
var pos_code_u="{$pos_code_user}";
var pos_code_int="{$pos_code_int}";
var signature="{$signature}";


var user = {fn: fn, ln:ln,role:role, pos:position,pos_code_u:pos_code_u,pos_code_int:pos_code_int,signature: signature};

showViewer( '{$full_path}','{$serverURL}','{$id}', user ,'page4viewer{$id}' );


$('.page-linker .pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();
var url=$(this).attr("href")+'&active-step={$step}'
        $.get(url)

        .done(function (data) {

           $('#step-'+'{$stepcontent}').html(data);
            
           

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});

JS;
$this->registerJs($script);

?>

