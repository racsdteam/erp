<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
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

 
 foreach ($models as $model) { 
     
   $url=Url::to(['erp-travel-clearance/pdf-data','id'=>$model->id]);
             $full_path=$ser_domain.$url; 
             
$q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$model->employee."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();
     ?>

 <div class="v-content" >
     
     <div class="v-left-side">
<figure>
  <div style="height: 600px;" id="viewerpage2<?php echo $model->id ?>"></div>
  <figcaption>For <?php echo $row7['first_name']." ".$row7['last_name'] ?></figcaption>
</figure>
<div style="background:#f5f5f5;" >
    
 <?php 

echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
 
</div>
</div>


<div class="v-right-side">
  
    <div class="qa-message-list" id="wallmessages">
    				
    	 <?php   
        
        $query = new Query;
        $query	->select([
            'f.*',
            
        ])->from('erp_travel_request_approval_flow as f ')->where(['f.tr_id' =>$model->	tr_id])->orderBy([
                'timestamp' => SORT_DESC,
                
              ]);

        $command = $query->createCommand();
        $rows= $command->queryAll();
        
        $count=0;

        ?> 	
        <?php if(!empty($rows)) : ?> 
 
       <?php foreach($rows as $row):?>
       
        <?php 

$q7=" SELECT u.first_name,u.last_name,u.user_image,p.position
FROM user as u inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
inner join  erp_org_positions as p  on p.id=pp.position_id
where pp.person_id='".$row['originator']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

$q8=" SELECT u.first_name,u.last_name,u.user_image,p.position
FROM user as u inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
inner join  erp_org_positions as p  on p.id=pp.position_id
where pp.person_id='".$row['approver']."' ";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();


$dateValue = strtotime($row['timestamp']);                     
$yr = date("Y",$dateValue) ." "; 
$mon = date("M",$dateValue)." "; 
$date = date("d",$dateValue);   
$time=date("H:i A",$dateValue);

$baseurl=Yii::$app->request->baseUrl;
if($row7['user_mage']!=''){
    
 $user_image=$baseurl.'/'.$row['user_image'];
}else{
  $user_image=$baseurl.'/img/avatar-user.png';
}

?> 

                   <?php  if($row['remark'] !=''):?>
					
					<div class="message-item" id="m2">
						<div class="message-inner">
							<div class="message-head clearfix">
								<div class="timeline1 avatar pull-left"><a href="#"><img src="<?=$user_image?>"></a></div>
								<div class="user-detail">
									<h5 class="handle"><?php echo $row7['first_name'];  ?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?=$mon?> <?=$date?>, <?=$yr?></span>
											</span>
											<span class="qa-message-who">
												<span class="qa-message-who-pad">To </span>
												<span class="qa-message-who-data"><a href="#"><?=$row8['first_name']?></a></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-v-content">
							<?php echo $row['remark'];$count++; ?>
							</div>
					</div></div>
					
				
				
					
						<?php  endif;?>	
					
					<?php endforeach; ?>
					
				
					
				
					
			<?php  endif;?>	
			
		     	<?php  if($count==0) :?>
					
					<div class="message-item" id="m2">
						<div class="message-inner">
						
							<div class="qa-message-v-content">
						     <em>No Comments/Remarks</em>
							</div>
					</div></div>
					
					<?php endif;?>
					
				</div>

  
</div>
  
</div>

  <!--commenting   --> 
  
          <?php
  $serverURL=Url::to(['erp-travel-clearance-annotations/annotations-handler']);
 $id=$model->id;
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
$q3="SELECT p.* from erp_org_positions as p inner join erp_persons_in_position as pp on pp.position_id=p.id where pp.person_id={$row1['person_interim_for']} ";
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


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'viewerpage2{$model->id}' );







$('.pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();
        var url=$(this).attr("href")+'&active-step={$step}'
        $.get(url)

        .done(function (data) {

            $('#step-2').html(data);
            
            console.log('step is {$container}');

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});

JS;
$this->registerJs($script);

?>
<?php
}

?>  
