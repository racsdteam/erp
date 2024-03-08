<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
//use frontend\assets\DataTableAsset;
//DataTableAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Tracking';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('Africa/Cairo');

$user=Yii::$app->user->identity;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
.card{
  color:black;  
    
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-binoculars"></i> LPO History Tracking</h3>
 </div>
 <div class="card-body">

<?php if(Yii::$app->session->hasFlash('error')) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
                <?= Yii::$app->session->getFlash('error') ?>
              </div>
            
            <?php endif?>
            
 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    
<?php 

     $q="SELECT f.*  FROM request_approval_flow  as f where f.request={$id}  order by f.timestamp desc";
     $com = Yii::$app->db1->createCommand($q);
     $rows = $com->queryAll();

     $res=array();
     
     foreach($rows as $row){
       $strtoTime=strtotime($row['timestamp']);
	   $date=date('Y-m-d',  $strtoTime);
	   $res[$date][]=$row;
     }
  
   
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<div id="timeline-1" style="width:100% !important" class="">
		<div class="row">
			<div class="col-xs-12 col-sm-12 ">
			    
			    <?php if(!empty($res)):?>
			    
			           <?php foreach($res as $date=>$data_array):?> 
			     	
			     	<div class="timeline-container">
					
					
					<div class="timeline-label">
						<span class="label label-primary arrowed-in-right label-lg">
						   
						
							<?php 
							
							$diff=dateDiff($date);
							
							if($diff->days==0){
							    
							    $label="Today";
							    
							    
							}
							elseif($diff->days==1){
							    
							   $label='Yesterday'; 
							    
							    
							}
							else{
							    $dateParts=dateParts($date);
							   
							    $label=$dateParts['m'].' '.$dateParts['d'].','.$dateParts['y'];
						
							} 
							?>
							
							  	
								<b><?=$label?></b> 	
							
							
						</span>
					</div>
					
						<div class="timeline-items">
					
					<?php foreach($data_array as $data):?>
					<?php 
				
					$dateParts=dateParts($data['timestamp']);
                    
                
                      $row5=getUserInfo($data['approver'],$data['timestamp']);
                    $row6=getUserInfo($data['originator'],$data['timestamp']);
                   
                    $row7=getUserSendInfo($data['approver'],$data['id'],$data['request']);
                   if(empty($row7))
                   {
			        $today=date("Y-m-d H:i:s");
                   }else{
                       $today=$row7['timestamp']; 
                   }
                   
			        $strtoTime=strtotime($data['timestamp']);
			        $wf_date=date("Y-m-d H:i:s",$strtoTime);
			        
			        $dateTime1 = new DateTime($today);
                    $dateTime2 = new DateTime($wf_date);
                    $diff = $dateTime1->diff($dateTime2);
               
					
					?>
					
					<div class="timeline-item clearfix">
							<div class="timeline-info">
								<img alt="Avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
								<span class="label label-info label-sm"><?= $dateParts['t']?></span>
							</div>

							<div class="widget-box transparent">
								<div class="widget-header widget-header-small">
									<h5 class="widget-title smaller">
										<a href="#" class="blue"><?=$row5['first_name']." ".$row5['last_name']."/".$row5['position'] ?></a>
										<span class="grey"> received Stock Vouchers</span>
									</h5>

									<span class="widget-toolbar no-border">
										<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<?= $dateParts['t']?>
									</span>

								
								</div>

								<div class="widget-body">
									<div class="widget-main">
									    	<h6 class="widget-title smaller">
										<span class="text-warning">Copied ? : </span>
									 <?php if($data['is_copy']) :?>
											    	<span class="text-back">Yes</span>
											    	<?php else :?>
											    	<span class="text-back">No</span>
											     <?php endif;?> 
									</h6>
									  
									<h6 class="widget-title smaller">
										<span class="text-blue">Originator : </span>
										<span class="text-grey"><?=$row6['first_name']." ".$row6['last_name']."/".$row6['position'] ?></span>
									</h6>
										
	                                <h6 class="widget-title smaller">
										<span class="text-blue">Time Elapsed : </span>
										<span class="text-grey"><?php echo $diff->format(' Yrs : %Y , M : %m , Dys : %d , hrs : %h ,min : %i ,sec : %s');
										//00 years 0 months 0 days 08 hours 0 minutes 0 second  ?></span>
									</h6>
									
										<div class="space-6"></div>

										<div class="widget-toolbox clearfix">
											<div class="pull-left">
												<i class="ace-icon fa fa-hand-o-right grey bigger-125"></i>
												<?php if($data['status']=='pending'){$class='bigger-110 text-danger';}
												       elseif($data['status']=='done'){$class='bigger-110 text-success';}
												       elseif($data['status']=='archived'){
												           
												          $class='bigger-110 text-warning'; 
												       }
												?>
												<a href="#" class="<?php echo $class ?>"><?=$data['status']?>…</a>
											     
											</div>

											<div class="pull-right action-buttons">
											

											  <?php if($data['status']!='redirected' &&  $user->user_level==User::ROLE_ADMIN) :?>
												<a href="<?=Url::to(['request-approval/redirect','request_id'=>$id,'f_id'=>$data['id']])?> "  
												class="btn-redirect" title="Redirect Approval" >
													<i class="ace-icon fas fa-share blue bigger-125"></i>
												</a>
												
												<?php endif;?>

												<a href="#">
													<i class="ace-icon fas fa-times text-danger bigger-125"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					<?php endforeach;?>
					
					</div>
			         	</div>    
			    
			          <?php endforeach?>
			    
			    <?php else :?>
			   
			 <div class="alert alert-warning alert-dismissible fade show">
    <button type="button " class="close btn active" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> workflow not yet started !
  </div>
			    <?php endif;?>
			    
			    
			    
			    
			
			</div>
			
			
		</div>
	</div>

 </div>

 </div>
 
 
 </div>

</div>

<?php

function dateParts($datetime){
               
               $strtoTime=strtotime($datetime);
			
               $parts=array();
               $parts['y']=date("Y", $strtoTime) ." "; 
               $parts['m']=date("M", $strtoTime) ." "; 
               $parts['d']=date("d", $strtoTime); 
               $parts['t']=date("H:i A", $strtoTime) ." "; 
               
               return $parts;
}


function dateDiff($mdate){
 
               $strtoTime=strtotime($mdate);
			   
			   $today=date("Y-m-d");
			   $wf_date=date("Y-m-d",$strtoTime);
			   
			   $dateTime1 = new DateTime($today);
               $dateTime2 = new DateTime($wf_date);
             
             //--------------------------------diff in days----------------------------  
               $diff = $dateTime1->diff($dateTime2);
               return $diff;;
              
    
}



function getUserInfo($user,$datetime){
 
   $q6=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
                          inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' and pp.timestamp < '".$datetime."' and pp.status=1 ";
                                           $command6= Yii::$app->db->createCommand($q6);
                                           $row6 = $command6->queryOne();  
                                           
                                           return $row6;
}

function getUserSendInfo($user,$id,$doc){
 
   $q="SELECT f.*  FROM  request_approval_flow as f where f.id > {$id} and 	f.originator={$user} and f.request={$doc}";
     $com = Yii::$app->db1->createCommand($q);
     $row = $com->queryone();
                                           
                                           return $row;
}
?>

   <?php
   
$script = <<< JS

$('.btn-redirect').click(function (e) {
    
    e.preventDefault();
   
var url = $(this).attr('href'); 

$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 

return false;
 
});

JS;
$this->registerJs($script);



?>

