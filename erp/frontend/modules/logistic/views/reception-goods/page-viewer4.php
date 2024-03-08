



<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
//use yii\widgets\LinkPager;
use yii\bootstrap4\LinkPager;
use yii\base\View;
use common\models\ErpDocumentAttachment;


?>

 


 <?php 
   //var_dump($model); die();                                                     
$ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$model->delivery_notes;
$full_path=$ser_domain.$doc_path;
$id=$model->id;
 
 ?>
 
<div class="d-flex flex-sm-row flex-column">
  <div class="p-2 bg-info col-md-12">
  
  
  <div class="d-flex flex-column">
      
      <!--  ----------------viewer------------------------------>
 <div  id="viewerpagelpo<?php echo $id ?>" style="height: 600px;"></div>
  
  
  <!--  -----------------pagination------------------------------>

  
  
  
</div>
  
  
  </div>
  
  
</div>





 
   <?php

 $serverURL=Url::to(['reception-supporting-annotations/annotations-handler']);


$user_id=Yii::$app->user->identity->user_id;

$q2="SELECT u.*,pos.*,s.signature from user  as u inner join erp_persons_in_position  as 
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

var user = {fn: fn, ln:ln, pos:'{$position}',pos_code_u:'{$pos_code_user}',pos_code_int:'{$pos_code_int}',signature:'{$signature}'};


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'viewerpagelpo{$id}' );

//---------------------------preventing page reload--------------------------------------------

$('.page-linker .pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();

        $.get($(this).attr("href"))

        .done(function (data) {

   $("#step-2").html(data);

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});
JS;
$this->registerJs($script);
?>


