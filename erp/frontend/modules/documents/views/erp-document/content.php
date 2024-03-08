



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

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attachments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

 

 <?php foreach ($models as $model) :?>
 
 <?php 
                                                        
                                                        $ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$model->attach_upload;
$full_path=$ser_domain.$doc_path;
$id=$model->id;
 
 ?>
 
<div class="d-flex flex-sm-row flex-column">
  <div class="p-2 bg-info col-md-9">
  
  
  <div class="d-flex flex-column">
      
      <!--  ----------------viewer------------------------------>
 <div  id="viewerpage<?php echo $id ?>" style="height: 600px;"></div>
  
  
  <!--  -----------------pagination------------------------------>
  <div class="p-2 bg-warning">
      
     <div class="page-linker bg-warning" style="background:#f5f5f5;text-align:center" >
    
 <?php 

echo LinkPager::widget([
    'pagination' => $pages,
     'prevPageLabel' => 'Previous',   // Set the label for the “previous” page button
        'nextPageLabel' => 'Next',
        'options'=>['class'=>'d-flex justify-content-center']
]);

?>   
</div> 
  </div>
  
  
  
</div>
  
  
  </div>
  
  <div class="p-2 bg-warning col-md-3 " style=" overflow:auto;height:653px;" >
  
  <div class="qa-message-list " id="wallmessages" >
    				
    	 <?php   
        
        $query = new Query;
        $query	->select([
            'f.*',
            
        ])->from('erp_document_flow_recipients as f ')->where(['f.document' =>$model->document])->orderBy([
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
where pp.person_id='".$row['sender']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

$q8=" SELECT u.first_name,u.last_name,u.user_image,p.position
FROM user as u inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
inner join  erp_org_positions as p  on p.id=pp.position_id
where pp.person_id='".$row['recipient']."' ";
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




<?php endforeach; ?>
 
   <?php

$serverURL=Url::to(['erp-document-annotations/annotations-handler']);


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


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'viewerpage{$id}' );

//---------------------------preventing page reload--------------------------------------------

$('.page-linker .pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();

        $.get($(this).attr("href"))

        .done(function (data) {

   $("#step-1").html(data);

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});
JS;
$this->registerJs($script);
?>

