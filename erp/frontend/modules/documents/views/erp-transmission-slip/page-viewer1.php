<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;
use yii\db\Query;
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


     
    $url=Url::to(['erp-transmission-slip/pdf-data','id'=>$model->id]);
    $full_path=$ser_domain.$url; 
  
  $q1=" SELECT tr_t.type as t_type FROM erp_transmission_slip_type as tr_t
 inner join erp_transmission_slip as tr_s  on tr_s.type=tr_t.code where tr_s.id={$model->id} ";
     $com1 = Yii::$app->db->createCommand($q1);
     $row = $com1->queryOne();
     ?>
     
   <div class="d-flex flex-sm-row flex-column">
 
 <!------------------------view--------------------------------------------> 
  <div class="p-2 bg-info col-md-9">
  
  
  <div class="d-flex flex-column">
     
     <figure>
  <div style="height: 600px;" id="trslip<?php echo $model->id ?>"></div>
  <figcaption> <?php echo  $row['t_type'] ?></figcaption>
  </figure>
  
  
</div>
  
  
  </div>
  
 <!------------------------comments--------------------------------------------> 
  <div class="p-2 bg-warning col-md-3 " style=" overflow:auto;height:653px;"> 
    <div class="qa-message-list" id="wallmessages" >
    				
    	 <?php   
        
        $query = new Query;
        $query	->select([
            'f.*',
            
        ])->from('erp_lpo_request_approval_flow as f ')->where(['f.lpo_request' =>$model->type_id])->orderBy([
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
$serverURL=Url::to(['erp-lpo-request-annotations/annotations-handler']);
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
         $signature=$row['signature'];
 
       

$script = <<< JS
var user = {fn: "{$fn}", ln:"{$ln}", pos:'{$position}',signature:'{$signature}'};
/*
 var viewerElement  = document.getElementById('tcviewer');
  var viewer= new PDFTron.WebViewer({
    path: '/erp/lib',
    l:'Rwanda Airports Company(rac.co.rw):ENTERP:RAC ERP::B+:AMS(20200310):A2A591AD0457A60A3360B13AC9A2737820616F996CB37A0595857BAA1AE768AE62B431F5C7',
    initialDoc:'{$full_path}',
    documentType: 'pdf',
    custom: JSON.stringify(user),
    config: "/erp/lib/config.js",
    serverUrl: '{$serverURL}',
    documentId:'{$id}'
    // replace with your own PDF file
    // optionally use WebViewer Server backend, demo.pdftron.com would later need to be replaced with your own server
    // pdftronServer: 'https://demo.pdftron.com'
  }, viewerElement );
  
  viewerElement.addEventListener('ready', () => {
  const viewerInstance = viewer.getInstance();
 
});*/

/*
 $('.pagination li a').on('click', function(e) {
     
     e.preventDefault();

        e.stopPropagation();
    viewer.loadDocument('https://rac.co.rw/erp/doc/erp-travel-clearance/pdf-data?id=33', { documentId: 'id2' });
     $(this).closest('li').addClass('active');
  });
  
  */

showViewer( '{$full_path}','{$serverURL}','{$id}', user ,'trslip{$id}' );
/*var viewerElement = document.getElementById('tcviewer');
 var myWebViewer = new PDFTron.WebViewer({ ... }
, viewerElement);
*/


JS;
$this->registerJs($script);

?>

