
<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\ErpOrgLevels;
use yii\db\Query;
$user=Yii::$app->user->identity;

 
?>

<?php $this->beginContent('@frontend/views/layouts/main-modules.php') ?>

      
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <?php
      
      
      
     
      $query = new Query;
                                     $query	->select([
                                         'p.*',
                                         
                                     ])->from('erp_org_positions as p ')->join('INNER JOIN', 'erp_persons_in_position as pp',
                                         'p.id=pp.position_id')->where(['person_id'=>$user->user_id]);
                         
                                     $command = $query->createCommand();
                                     $row= $command->queryOne();
       
      //-------------------pending documents-------------------------------------------------------------------------
      $q=" SELECT count(*) as tot FROM erp_document_flow_recipients where  recipient='". Yii::$app->user->identity->user_id."' and is_new=1";
      $com = Yii::$app->db->createCommand($q);
            $r = $com->queryall(); 
            

//----------------------- my documents-----------------------------------------------------------------------------------------------------

$q3=" SELECT count(*) as tot FROM erp_document where  creator='". Yii::$app->user->identity->user_id."' and is_new=1 ";
$com3 = Yii::$app->db->createCommand($q3);
      $r3 = $com3->queryall(); 

 //-------------------pending request------------------------------------------------------------------------
 $q0=" SELECT count(*) as tot FROM erp_document_request_for_action where  action_handler='". Yii::$app->user->identity->user_id."' and is_new='1'";
 $com0 = Yii::$app->db->createCommand($q0);
       $r0 = $com0->queryall(); 



 //-------------------pending users-------------------------------------------------------------------------
 $q2=" SELECT count(*) as tot FROM user where  approved=0  ";
 $com2 = Yii::$app->db->createCommand($q2);
       $r2 = $com2->queryall(); 
       
 //--------------------------------my  memos----------------------------------------------------------------      
       
   $q30=" SELECT count(*) as tot FROM erp_memo where  created_by='". Yii::$app->user->identity->user_id."' ";
$com30 = Yii::$app->db->createCommand($q30);
      $r30 = $com30->queryall();     
   
 //---------------------------------------my requisirions-----------------------------------------------------------------------
  $q32=" SELECT count(*) as tot FROM erp_requisition where  requested_by='". Yii::$app->user->identity->user_id."' and is_new='1' ";
$com32 = Yii::$app->db->createCommand($q32);
      $r32 = $com32->queryall(); 
   //------------------------------------pending memos-------------------------------------------------
   $q40=" SELECT count(*) as tot FROM erp_memo_flow_recipients where  recipient='". Yii::$app->user->identity->user_id."' and status='processing' ";
$com40 = Yii::$app->db->createCommand($q40);
      $r40 = $com40->queryall();
      
      
 //-------------------------------pending requisition----------------------------------
 $q41=" SELECT count(*) as tot FROM erp_requisition_flow_recipients as r inner join  erp_requisition_flow as f on f.id=r.flow_id
where r.recipient='".Yii::$app->user->identity->user_id."' and r.is_new='1' ";
 $com41 = Yii::$app->db->createCommand($q41);
 $r41 = $com41->queryall();  
 
 //---------------------------------------pending lpos requests-----------------------------------------------------------
 
 $q44=" SELECT count(*) as tot FROM erp_lpo_request_flow_recipients as r inner join  erp_lpo_request as f on f.id=r.flow_id
where r.recipient='".Yii::$app->user->identity->user_id."' and r.is_new='1' ";
 $com44 = Yii::$app->db->createCommand($q44);
 $r44 = $com44->queryall();
      //--------------------------------my  interims----------------------------------------------------------------      
       
   $q31=" SELECT count(*) as tot FROM erp_person_interim  where  person_interim_for='". Yii::$app->user->identity->user_id."' and status='active' ";
$com31 = Yii::$app->db->createCommand($q31);
      $r31 = $com31->queryall();
  
  
  //----------------------------------------------------approved memos----------------------------------------------------------------
 
  function getApprovedMemos1(){
  $approved=0; 
   
  //--------------------------------------------MD------------------------------------------------------------------
     $q11=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command11 = Yii::$app->db->createCommand($q11);
    $r_MD = $command11->queryOne();
    
 if(!empty($r_MD)) {
     
      $q43=" SELECT count(*) as tot FROM erp_memo_approval as m_ap inner join erp_memo  as m on m.id=m_ap.memo_id
 where m.created_by='".Yii::$app->user->identity->user_id."' and m_ap.approval_status='approved' and m_ap.approved_by={$r_MD['person_id']} and m_ap.is_new='1'";
 $com43 = Yii::$app->db->createCommand($q43);
 $r43= $com43->queryAll(); 
 
 $approved=$r43[0]['tot'];
 }
 return $approved;
     
 }

 //------------------------------------------approved requisitions--------------------------------------------------------------

  
    
 
  function getApprovedRequisition1(){
  $approved=0; 
   
  //--------------------------------------------MD------------------------------------------------------------------
     $q11=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command11 = Yii::$app->db->createCommand($q11);
    $r_MD = $command11->queryOne();
    
 if(!empty($r_MD)) {
     
        
  $q42=" SELECT count(*) as tot FROM erp_requisition_approval as req_ap inner join erp_requisition  as req on req.id=req_ap.requisition_id
 where req.requested_by='".Yii::$app->user->identity->user_id."' and req.approve_status='approved' and req_ap.approval_status='approved' and req_ap.approved_by={$r_MD['person_id']} and req_ap.is_new='1'";
 $com42 = Yii::$app->db->createCommand($q42);
 $r42= $com42->queryAll();
 $approved=$r42[0]['tot'];
 }
 return $approved;
     
 }
 
 //------------------------------------------approved lpo--------------------------------------------------------------

 $q45=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Director Finance Unit '";
    $com45 = Yii::$app->db->createCommand($q45);
    $r_DAF = $com45->queryOne();
    if(!empty($r_DAF)){
        
        
        $q46=" SELECT  count(*) as tot FROM erp_lpo_request_approval as lpo_ap inner join erp_lpo_request  as req on req.id=lpo_ap.lpo_request
 where req.requested_by='".Yii::$app->user->identity->user_id."' and  req.status='approved' and  lpo_ap.approved_by={$r_DAF['person_id']}";
 $com46 = Yii::$app->db->createCommand($q46);
 $r46= $com46->queryAll();
    }
  function getApprovedLPO1(){
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
 
  //------------------------------------------Travel Clearances--------------------------------------------------------------

  
   
  $q51=" SELECT count(*) as tot FROM erp_travel_clearance ";
 $com51 = Yii::$app->db->createCommand($q51);
 $r51= $com51->queryAll();
   
   
   
 
  //------------------------------------------Pending Travel Clearances--------------------------------------------------------------

  
   
  $q52=" SELECT count(*) as tot from erp_travel_clearance as t inner join erp_travel_clearance_flow as f on t.id=f.travel_clearance
 inner join erp_travel_clearance_flow_recipients as r on f.id= r.flow_id  where r.recipient=".Yii::$app->user->identity->user_id." and r.is_forwarded=0 ";
 $com52 = Yii::$app->db->createCommand($q52);
 $r52= $com52->queryAll();   
 
 //------------------------------------------my travel clearances----------------------------------------------------------------
 
  $q54=" SELECT count(*) as tot FROM erp_travel_clearance where created_by=".Yii::$app->user->identity->user_id;
 $com54= Yii::$app->db->createCommand($q54);
 $r54= $com54->queryAll();
 
   //------------------------------------------Approved Travel Clearances--------------------------------------------------------------
 
 
  function getApprovedTravelClearance1(){
  $approved=0; 
   
  //--------------------------------------------MD------------------------------------------------------------------
     $q11=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command11 = Yii::$app->db->createCommand($q11);
    $r_MD = $command11->queryOne();
    
 if(!empty($r_MD)) {
     
  $q53=" SELECT count(*) as tot FROM erp_travel_clearance_approval as t_ap inner join erp_travel_clearance  as t  on t.id=t_ap.travel_clearance where
 t_ap.approval_status='approved' and t_ap.approved_by={$r_MD['person_id']} and t_ap.is_new='1'";
 $com53 = Yii::$app->db->createCommand($q53);
 $r53= $com53->queryAll();
 
 $approved=$r53[0]['tot'];
 }
 return $approved;
     
 }
 
 ?>
 
 <!---------------------------------------------------doc custom left side---------------------------------------------------------------------
 
 <?php $this->beginBlock('sidebar-menu') ?>
 
 <?php
   
    //------------levels dynamically-------------------------------
    $levels=ErpOrgLevels::find()->all();
    $orgUnits=array();
    if(!empty($levels)){

        foreach($levels as $level){

            $orgUnits[]= [
                'label' => $level->level_name."(s)",
                'icon' => 'fa fa-leaf',
                'url' =>Url::to(['erp-org-units/index','level'=>$level->id]),
               
              'active' => $this->context->route == strtolower('erp-org-units/'.$level->level_name)."s"
            ];
        }

        
    }

    $orgUnits[]=[
        'label' => 'Add Organizational Unit',
        'icon' => 'fa fa-leaf',
        'url' => Url::to(['erp-org-units/create']),
        'active' => $this->context->route == 'erp-org-units/create'
    ];
      
      $items=[
        ['label' => 'Menu', 'options' => ['class' => 'header']],
        ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard', 
            'url' => ['#'], 'active' => $this->context->route == 'site/index',
           
        ],
        [
            'label' => 'Manage Documents',
            'icon' => 'fa fa-folder-open',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
                [
                    'label' => 'Share Document',
                    'icon' => 'fa fa-file-pdf-o',
                    'url' =>Url::to(['erp-document/create']),
                   
    'active' => $this->context->route == 'erp-document/create'
                ],
                [
                    'label' => 'pending Document(s)'.Html::tag('span',$r[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-document/in-documents']),
                   
    'active' => $this->context->route == 'erp-document/in-documents'
                ], 
                [
                    'label' => 'My Document(s)'.Html::tag('span',$r3[0]['tot']." New", ['class' => 'badge bg-green']),
                    'icon' => 'fa  fa-folder-open-o',
                    'url' => Url::to(['erp-document/my-documents']),
                   
    'active' => $this->context->route == 'erp-document/my-documents'
                ],

                [
                    'label' => 'Request For Action'.Html::tag('span',$r0[0]['tot']." New", ['class' => 'badge bg-pink']),
                    'icon' => 'fa fa-hourglass-3',
                    'url' => Url::to(['erp-document/docs-requested-for-action']),
                   
    'active' => $this->context->route == 'erp-document/docs-requested-for-action'
                ],
                [
                    'label' => 'All Documents',
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-document/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
                   
    'active' => $this->context->route == 'erp-document/index'
                ],
                [
                    'label' => 'Add Document Type',
                    'icon' => 'fa fa-folder-open',
                    'url' => Url::to(['erp-document-type/create']),
                   
    'active' => $this->context->route == 'erp-document-type/create'
                ],
               


            ]
        ],

 //-----------------------------------------------manage memos-------------------------------------------------------
  [
            'label' => 'Manage Memo(s)',
            'icon' => 'fa fa-clipboard',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
                [
                    'label' => 'Create Memo',
                    'icon' => 'fa  fa-file-text-o',
                    'url' =>Url::to(['erp-memo/create']),
                   
    'active' => $this->context->route == 'erp-memo/create'
                ],
                 [
                    'label' => 'My Memo(s)'.Html::tag('span',$r30[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-memo/my-memos']),
                   
    'active' => $this->context->route == 'erp-memo/my-memos'
                ],
                [
                    'label' => 'Pending Memo(s)'.Html::tag('span',$r40[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-memo/pending-memos']),
                   
    'active' => $this->context->route == 'erp-memo/pending-memos'
                ],
                
                [
                    'label' => 'Approved Memo(s)'.Html::tag('span',getApprovedMemos1()." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-check-square-o',
                    'url' => Url::to(['erp-memo/approved-memos']),
                   
            'active' => $this->context->route == 'erp-memo/approved-memos'
                ],
                
                [
                    'label' => 'All Memo(s)',
                    'icon' => 'fa fa-recycle',
                    'url' => Url::to(['erp-memo/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
                   
    'active' => $this->context->route == 'erp-memo/index'
                ],
                
                [
                    'label' => 'Add Memo Request Category',
                    'icon' => 'fa fa-folder-open',
                    'url' => Url::to(['erp-memo-categ/create']),
                   
    'active' => $this->context->route == 'erp-memo-categ/create'
                ],
               


            ]
        ],
        
//-----------------------------------------------manage Travel Clearance-------------------------------------------------------
  [
            'label' => 'Manage <br>Travel Clearance(s)',
            'icon' => 'fa fa-clipboard',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
                  [
                    'label' => 'My Travel Clearance(s)'.Html::tag('span',$r54[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-travel-clearance/my-travel-clearances']),
                   
    'active' => $this->context->route == 'erp-travel-clearance/my-travel-clearances'
                ],
               
                 [
                    'label' => 'Pending <br> Travel Clearance(s)'.Html::tag('span',$r52[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-travel-clearance/pending']),
                   
    'active' => $this->context->route == 'erp-travel-clearance/pending'
                ],
            [
                    'label' => 'Approved <br> Travel Clearance(s)'.Html::tag('span',getApprovedTravelClearance1()." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-travel-clearance/approved']),
                   
    'active' => $this->context->route == 'erp-travel-clearance/approved'
                ],
                
                [
                    'label' => 'All Travel Clearance(s)'.Html::tag('span',$r51[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-travel-clearance/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
    'active' => $this->context->route == 'erp-travel-clearance/index'
                ],
            ]
        ],
        
//-----------------------------------------------manage Claim form-------------------------------------------------------
  [
            'label' => 'Manage <br>Claim Form(s)',
            'icon' => 'fa fa-clipboard',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
               [
                    'label' => 'Create Claim form',
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-claim-form/create']),
    'active' => $this->context->route == 'erp-claim-form/create'
                ],
              
                
                    [
                    'label' => 'My Draft <br> Claim Form'.Html::tag('span',$r52[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-claim-form/draft']),
                   
    'active' => $this->context->route == 'erp-claim-form/draft'
                ],
                       [
                    'label' => 'Pending <br> Claim Form'.Html::tag('span',$r52[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-claim-form/pending']),
                   
    'active' => $this->context->route == 'erp-claim-form/pending'
                ],
            [
                    'label' => 'Approved <br> Claim Form(s)'.Html::tag('span',$r53[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-claim-form/approved']),
                   
    'active' => $this->context->route == 'erp-claim-form/approved'
                ],
                   [
                    'label' => 'All Claim Form'.Html::tag('span',$r52[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-claim-form/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
                   
    'active' => $this->context->route == 'erp-claim-form/index'
                ],
            ]
        ],
 //-----------------------------------------------manage requisition-------------------------------------------------------
  [
            'label' => 'Manage  Requisition(s)',
            'icon' => 'fa fa-cart-plus',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
               /* [
                    'label' => 'Create Requisition',
                    'icon' => 'fa  fa-file-text-o',
                    'url' =>Url::to(['erp-memo/create']),
                   
    'active' => $this->context->route == 'erp-memo/create'
                ],*/
                 [
                    'label' => 'My Requisition(s)'.Html::tag('span',$r32[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-requisition/my-requisitions']),
                   
    'active' => $this->context->route == 'erp-requisition/my-requisitions'
                ],
                [
                    'label' => 'Pending Requisition(s)'.Html::tag('span',$r41[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-requisition/pending-requisitions']),
                   
    'active' => $this->context->route == 'erp-requisition/pending-requisitions'
                ],
                 [
                    'label' => 'Approved Requisition(s)'.Html::tag('span',getApprovedRequisition1()." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-requisition/approved-requisitions']),
                   
    'active' => $this->context->route == 'erp-requisition/approved-requisitions'
                ],
            
                [
                    'label' => 'All Requisition(s)',
                    'icon' => 'fa fa-recycle',
                    'url' => Url::to(['erp-requisition/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
                   
    'active' => $this->context->route == 'erp-requisition/index'
                ],

            ]
        ],
  //------------------------------manage lpo-------------------------------------------------------------
  [
            'label' => 'Manage  LPO(s)',
            'icon' => 'fa fa-opencart',
            'url' => '#',
           
            'options'=>['class'=>'treeview'],
            'items' => [
               /* [
                    'label' => 'Create Requisition',
                    'icon' => 'fa  fa-file-text-o',
                    'url' =>Url::to(['erp-memo/create']),
                   
    'active' => $this->context->route == 'erp-memo/create'
                ],*/
                 [
                    'label' => 'My Requests(s)'.Html::tag('span',$r30[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-database',
                    'url' => Url::to(['erp-lpo-request/my-requests']),
                   
    'active' => $this->context->route == 'erp-lpo-request/my-requests'
                ],
                [
                    'label' => 'Pending Request(s)'.Html::tag('span',$r44[0]['tot']." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-lpo-request/pending-requests']),
                   
    'active' => $this->context->route == 'erp-lpo-request/pending-requests'
                ],
                 [
                    'label' => 'Approved Request(s)'.Html::tag('span',getApprovedLPO1()." New", ['class' => 'badge bg-blue']),
                    'icon' => 'fa fa-share-square-o',
                    'url' => Url::to(['erp-lpo-request/approved-lpo']),
                   
    'active' => $this->context->route == 'erp-lpo-request/approved-lpo'
                ],
                
              

                [
                    'label' => 'All LPO Request(s)',
                    'icon' => 'fa fa-recycle',
                    'url' => Url::to(['erp-lpo-request/index']),
                    'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
                   
    'active' => $this->context->route == 'erp-lpo-request/index'
                ],

            ]
        ],
        
 //-----------------------------Finance pax------------------------------------------------------------
 [
    'label' => 'Finance PAX',
    'icon' => 'fa  fa-user',
    'url' => '#',
    //'visible'=>$user->user_level==User::ROLE_ADMIN,
   
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'View Manifest',
    'icon' => 'fa fa-retweet',
    'url' =>Url::to(['passenger-manifest/index']),
    
    'active' => $this->context->route == 'passenger-manifest/index'
    ],
   
    ]
    ],
 //-----------------------------manage interim------------------------------------------------------------
 [
    'label' => 'Manage Interims',
    'icon' => 'fa  fa-retweet',
    'url' => '#',
    //'visible'=>$user->user_level==User::ROLE_ADMIN,
   
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Add interim',
    'icon' => 'fa fa-retweet',
    'url' =>Url::to(['erp-person-interim/create']),
    
    'active' => $this->context->route == 'erp-person-interim/create'
    ],
    [
    'label' => 'My Interim(s) '.Html::tag('span',$r31[0]['tot']." Pending", ['class' => 'badge bg-green']),
    'icon' => 'fa fa-database',
    'url' => Url::to(['erp-person-interim/index']),
    'active' => $this->context->route == 'erp-person-interim/my-interims'
    ],
   
    ]
    ],
      
//----------------------------------------------------basic app -settings----------------------------------------------
[
'label' => 'Organization Settings',
'icon' => 'fa fa-gear ',
'url' => '#',
'visible'=>$user->user_level==User::ROLE_ADMIN || $user->user_level==User::ROLE_MD,
'options'=>['class'=>'treeview'],
'items' => [

 //-------------------------------------------item  1 start-------------------------------   
[
'label' => 'Organization Profile',
'icon' => 'fa fa-university',
'url' =>'#',
'options'=>['class'=>'treeview'],
'items' => [
    [
        'label' => 'View Organization Profile',
        'icon' => 'fa fa-database',
        'url' => Url::to(['erp-organization/index']),
        'active' => $this->context->route == 'erp-organization/index'
    ],
    [
        'label' => 'Create Organization Profile',
        'icon' => 'fa fa-university',
        'url' => Url::to(['erp-organization/create']),
        'active' => $this->context->route == 'erp-organization/create'
        ],
        

],
  

], 
[
        'label' => 'Organizational Chart',
        'icon' => 'fa fa-cubes',
        'url' => Url::to(['erp-organization/display-org-chart']),
        'active' => $this->context->route == 'erp-organization/display-org-chart',
        'options'=>['class'=>'view-chart-action'],
    ],

[
    'label' => ' Organizational Units',
    'icon' => 'fa fa-share',
    'url' => '#',
    //'visible'=>User::isAdminUser() || User::isManagerUser(),
    'options'=>['class'=>'treeview'],
    'items' => $orgUnits
      
    

    


    ],

    [
        'label' => 'Org Hierarchy Levels',
        'icon' => 'fa fa-share',
        'url' =>'#',
        'options'=>['class'=>'treeview'],
        'items' => [
            [
                'label' => 'Level(s) List',
                'icon' => 'fa fa-database',
                'url' => Url::to(['erp-org-levels/index']),
                'active' => $this->context->route == 'erp-org-levels/index'
            ],
            [
                'label' => 'Add New Level',
                'icon' => 'fa  fa-level-down',
            'url' => Url::to(['erp-org-levels/create']),
            'active' => $this->context->route == 'erp-org-levels/create'
            ],
        
        ],
        
        
        ],

   

//---------------------------------------positions------------------------------------
[
    'label' => 'Position(s)',
    'icon' => 'fa  fa-briefcase',
    'url' => '#',
    //'visible'=>User::isAdminUser() || User::isManagerUser(),
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Position(s) List',
    'icon' => 'fa fa-database',
    'url' =>Url::to(['erp-org-positions/index']),
    
    'active' => $this->context->route == 'erp-org-positions/index'
    ],
    [
    'label' => 'Add Position',
    'icon' => 'fa fa-university',
    'url' => Url::to(['erp-org-positions/create']),
    'active' => $this->context->route == 'erp-org-positions/create'
    ]
    ]
    ],

    

],



],

 
//-----------------------------------------manage users---------------------------------------------------------
[
    'label' => 'Manage Users accounts',
    'icon' => 'fa fa-database',
    'url' => '#',
    'visible'=>$user->user_level==User::ROLE_ADMIN,
   
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'users accounts',
    'icon' => 'fa fa-database',
    'url' =>Url::to(['user/users-list']),
    
    'active' => $this->context->route == 'user/users-list'
    ],
    [
    'label' => 'Users Pending '.Html::tag('span',$r2[0]['tot']." Pending", ['class' => 'badge bg-green']),
    'icon' => 'fa fa-user-plus',
    'url' => Url::to(['user/users-pending']),
    'active' => $this->context->route == 'user/users-pending'
    ],
    [
    'label' => 'Signature',
    'icon' => 'fa fa-user-plus',
    'url' => Url::to(['signature/index']),
    'active' => $this->context->route == 'signature/index'
    ],
    ]
    ],
        
        //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
        //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],

      /*  [
            'label' => 'Select Your Hotel',
            'icon' => 'fa fa-hotel',
            'url' => Url::to(['site/user-select-hotel']),
            'visible'=>User::isTempUser() ,
            'active' => $this->context->route == 'site/user-select-hotel'
        ]*/
    ]
      
      ?>
      <?=
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree','data-widget'=>'tree'],
                    'items' =>$items,'encodeLabels' => false//to be able to display badge 
                ]
        )
        ?>
  
  
   <?php $this->endBlock() ?>

    <?= $content ?>
  
  <?php $this->endContent() ?>
