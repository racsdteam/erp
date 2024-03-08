<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Home';


if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

if (Yii::$app->session->hasFlash('failure')){

$msg=  Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  

   }
$role=Yii::$app->user->identity->user_level;


    
    
    
  //-------------------pending documents-------------------------------------------------------------------------
      $q=" SELECT count(*) as tot FROM erp_document_flow_recipients where  recipient='". Yii::$app->user->identity->user_id."' and is_new=1";
      $com = Yii::$app->db->createCommand($q);
            $r = $com->queryall(); 
       
       
       //-------------------pending request------------------------------------------------------------------------
 $q0=" SELECT count(*) as tot FROM erp_document_request_for_action where  action_handler='". Yii::$app->user->identity->user_id."' and is_new='1'";
 $com0 = Yii::$app->db->createCommand($q0);
       $r0 = $com0->queryall(); 
   
 //----------------------- my documents-----------------------------------------------------------------------------------------------------

$q3=" SELECT count(*) as tot FROM erp_document where  creator='". Yii::$app->user->identity->user_id."' and is_new=1 ";
$com3 = Yii::$app->db->createCommand($q3);
      $r3 = $com3->queryall(); 

      
      
 //-------------------pending users-------------------------------------------------------------------------
 $q2=" SELECT count(*) as tot FROM user where  approved=0  ";
 $com2 = Yii::$app->db->createCommand($q2);
       $r2 = $com2->queryall(); 
       
        //------------------------------------pending memos-------------------------------------------------
   $q40=" SELECT count(*) as tot FROM erp_memo_flow_recipients where  recipient='". Yii::$app->user->identity->user_id."' and is_new='1' ";
$com40 = Yii::$app->db->createCommand($q40);
      $r40 = $com40->queryall();  
      
      
      //-------------------------------pending requisition----------------------------------
 $q41=" SELECT count(*) as tot FROM erp_requisition_flow_recipients as r inner join  erp_requisition_flow as f on f.id=r.flow_id
where r.recipient='".Yii::$app->user->identity->user_id."' and r.is_new='1' ";
 $com41 = Yii::$app->db->createCommand($q41);
 $r41 = $com41->queryall();
 
 //----------------------------approved requisition-------------------------------------------------------------------------
 
  function getApprovedRequisition(){
  
   
    $q10=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command01 = Yii::$app->db->createCommand($q10);
    $r_MD = $command01->queryOne(); 
  
    $approved=0; 
    
 if(!empty($r_MD)) {
     
      $q42=" SELECT count(*) as tot FROM erp_requisition_approval as req_ap inner join erp_requisition  as req on req.id=req_ap.requisition_id
 where req.requested_by='".Yii::$app->user->identity->user_id."' and req_ap.approval_status='approved' and req_ap.approved_by={$r_MD['person_id']} and req_ap.is_new='1' ";
 $com42 = Yii::$app->db->createCommand($q42);
 $r42= $com42->queryAll();
 $approved=$r42[0]['tot'];
 }
 return $approved;
     
 }
 
 //----------------------------------------pending lpos requests--------------------------------------------------
  $q44=" SELECT count(*) as tot FROM erp_lpo_request_flow_recipients as r inner join  erp_lpo_request as f on f.id=r.flow_id
where r.recipient='".Yii::$app->user->identity->user_id."' and r.is_new='1' ";
 $com44 = Yii::$app->db->createCommand($q44);
 $r44 = $com44->queryall();
      //----------------------------------------------------memos----------------------------------------------------------------
  
  
 
 //---------------------------------------------------------drafting memos-------------------------------------------------------  
    $q30=" SELECT count(*) as tot FROM erp_memo where  created_by='". Yii::$app->user->identity->user_id."' and status='drafting' ";
$com30 = Yii::$app->db->createCommand($q30);
      $r30 = $com30->queryall();
      
  //---------------------------------------------------------approved memos-------------------------------------------------------    
   

 
 function getApprovedMemos(){
  $approved=0; 
   
    $q10=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command01 = Yii::$app->db->createCommand($q10);
    $r_MD = $command01->queryOne();
    
   if(!empty($r_MD)){
       
       $q43=" SELECT count(*) as tot FROM erp_memo_approval as m_ap inner join erp_memo  as m on m.id=m_ap.memo_id
 where m.created_by='".Yii::$app->user->identity->user_id."' and m_ap.approval_status='approved' and m_ap.approved_by={$r_MD['person_id']} and m_ap.is_new='1'";
 $com43 = Yii::$app->db->createCommand($q43);
 $r43= $com43->queryAll(); 
 
 $approved=$r43[0]['tot'];  
   }
     
      
 
 return $approved;
     
 }
 //------------------------------------------Pending Travel Clearances--------------------------------------------------------------

  
   
  $q52=" SELECT count(*) as tot from erp_travel_clearance as t inner join erp_travel_clearance_flow as f on t.id=f.travel_clearance
 inner join erp_travel_clearance_flow_recipients as r on f.id= r.flow_id  where r.recipient=".Yii::$app->user->identity->user_id." and r.is_forwarded=0 ";
 $com52 = Yii::$app->db->createCommand($q52);
 $r52= $com52->queryAll(); 
 
 
 
    //------------------------------------------Approved Travel Clearances--------------------------------------------------------------

 
 
 function getApprovedTravelClearance(){
   
   
   $q10=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command01 = Yii::$app->db->createCommand($q10);
    $r_MD = $command01->queryOne();
    
    $approved=0;
    
 if(!empty($r_MD)) {
     
      $q53=" SELECT count(*) as tot FROM erp_travel_clearance_approval as t_ap inner join erp_travel_clearance  as t  on t.id=t_ap.travel_clearance where
 t_ap.approval_status='approved' and t_ap.approved_by={$r_MD['person_id']} and t_ap.is_new='1'";
 $com53 = Yii::$app->db->createCommand($q53);
 $r53= $com53->queryAll(); 
 
 $approved=$r53[0]['tot'];
 }
 return $approved;
     
 }
 
 //------------------------------------------approved lpo--------------------------------------------------------------

 $q45=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Director Finance Unit '";
    $com45 = Yii::$app->db->createCommand($q45);
    $r_DAF = $com45->queryOne();
    

 
 function getApprovedLPO(){
  $approved=0; 
   
   $q45=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Director Finance Unit '";
    $com45 = Yii::$app->db->createCommand($q45);
    $r_DAF = $com45->queryOne();
    
 if(!empty($r_DAF)) {
     
      $q46=" SELECT  count(*) as tot FROM erp_lpo_request_approval as lpo_ap inner join erp_lpo_request  as req on req.id=lpo_ap.lpo_request
 where req.requested_by='".Yii::$app->user->identity->user_id."' and  req.status='approved' and  lpo_ap.approved_by={$r_DAF['person_id']}";
 $com46 = Yii::$app->db->createCommand($q46);
 $r46= $com46->queryAll();
 $approved=$r46[0]['tot'];
 }
 return $approved;
     
 }

?>

<style>
    
    a.div-clickable{ display: block;
       height: 100%;
       width: 100%;
       text-decoration: none;}   
       
       
       
   </style>
   
   

<!-- Info boxes -->
<div class="row">
       
         <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $r3[0]['tot']?></h3>

              <p>My Document(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-document/my-documents'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
        <!-- /.col -->
         <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r[0]['tot']?></h3>

              <p>Pending Documents</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-document/in-documents']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
     
 <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo   $r0[0]['tot'] ?></h3>

              <p>Document Request(s) For Action</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-document/docs-requested-for-action']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>

         <?php if($role==User::ROLE_ADMIN):?>
          
           <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php echo   $r2[0]['tot'] ?></h3>

              <p>Pending Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
           <a href="<?=Url::to(['user/users-pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
          

          <?php endif?>
          
            
          <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r30[0]['tot']?></h3>

              <p>My Memo(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-memo/my-memos']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
          <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r40[0]['tot']?></h3>

              <p>Pending Memo(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-memo/pending-memos']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
          <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo getApprovedMemos()?></h3>

              <p>Approved Memo(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-memo/approved-memos']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
           <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r41[0]['tot']?></h3>

              <p>Pending Requisition(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-requisition/pending-requisitions']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
           <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo getApprovedRequisition()?></h3>

              <p>Approved Requisition(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-requisition/approved-requisitions']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
             <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r44[0]['tot']?></h3>

              <p>Pending LPO requests(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-lpo-request/pending-requests']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo getApprovedLPO();?></h3>

              <p>Approved LPO requests(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-lpo-request/approved-lpo']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
            <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $r52[0]['tot']?></h3>

              <p>Pending Travel Clearance(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-travel-clearance/pending']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
             <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo getApprovedTravelClearance()?></h3>

              <p>Approved Travel Clearance(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['erp-travel-clearance/approved']) ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        
        <!-- /.col -->
      </div>