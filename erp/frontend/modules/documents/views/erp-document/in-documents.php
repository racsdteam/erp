<?php

use yii\helpers\Html;

use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Documents';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 

  .doc-desc{
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}

</style>


<div class="document-sharing-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Share Document', ['create'], ['class' => 'btn btn-success active btn-sm action-add-hotel','title'=>'Share a  New Document']) ?>
    </p>
   
</div>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header">
   <h3 class="card-title"><i class="fa fa-folder-open"></i> Pending Documents</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<?php 

$i=0; 
$q="SELECT f.* FROM erp_document_flow_recipients as f
 where recipient='".Yii::$app->user->identity->user_id."' and f.status='pending' order by timestamp desc  ";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
    
 
   
?>

 <div class="table-responsive">
 <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th align="center">#</th>
                                         <th>Actions</th>
                                        <th>Doc Number</th>
                                        <th>Title</th>
                                        <th>Doc Type</th>
                                     
                                        <th>Description</th>
                                        <th>Submitted</th>
                                        <th>Submitted By</th>
                                        <th>Remark</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                       
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
  $condition = ['and',
    ['=', 'doc.id', $row['document']],
    ['<>', 'status', 'expired']
    
   
]; 
                                    //---------------------------doc latest version info-----------------------------------
                                     $query = new Query;
                                     $query	->select([
                                         'doc.*','doc_type.type','s.severity as severity_name','s.code as s_code'
                                         
                                     ])->from('erp_document as doc ')->join('INNER JOIN', 'erp_document_type as doc_type',
                                         'doc.type=doc_type.id')->join('INNER JOIN', 'erp_document_severity as s',
                                         's.id=doc.severity')->where($condition);
                         
                                     $command = $query->createCommand();
                                     $rows2= $command->queryAll();
                                     $i++;

                                     //----------------------------------------latest version
                                     $row2=$rows2[0];

                                     
                                    if($row2!=null):
                                    ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                          <td>
                                            <?=
                                           $i
                                            
                                           ?>
                                           </td>
                                           <td nowrap> 
                                           
                                                                   <div style="text-align:center;" class="centerBtn">
   
                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-document/pdf-viewer",'id'=>$row2['id'],'flow'=>$row['flow_id']
                                           ])
                                          ,['class'=>'btn btn-info btn-sm ','title'=>'View Document Info'] ); ?> 
                                          
                     <?php if(($row2["status"] !=='approved' && $row2["status"] !=='closed') && $row2["creator"]==Yii::$app->user->identity->user_id ) : ?>
                                            <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-document/update",'id'=>$row2['id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm ','title'=>'Update Document Info','disabled'=>$row["status"]!='drafting'] ); ?> |
                                          
                                         <?php endif; ?> 
                                             <?php
                                          if($row2["status"]=='approved' || $row2["status"]=='processing' || $row2["status"]=='closed'):
                                          ?>
                                           |
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-document/done",'id'=>$row2['id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm  action-archive','title'=>' Document Info']); ?>
                                        <?php 
                                        endif;
                                        ?>
        </div>
                                                 </td>
                                          
                                          
                                         </td> 
                                    <td nowrap><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row2["doc_code"],Url::to(['erp-document/pdf-viewer','id'=>$row2["id"]]), ['class'=>'']) ?></td>
                                    <td>
                                            <?=
                                           $row2["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                            <?php
                                          
                                           echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. $row2["type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                         <td>
                                            <div class="doc-desc"
                                            >
                                       <?php echo $row2["doc_description"]  ;?>
                                                     </div></td>
                                          
                                            <td><?php echo $row["timestamp"] ; ?>
                                        
                                        
                                         </td>
                                           
                                            <td> <?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['sender']."' and pp.status=1 ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name'];
                                           
                                          // echo $row7['position'];
                                           echo  $pos." [ ".$full_name." ]";
                                          
                                            ?> </td>
                                            
                                            <td>
                                                
                                               <div style="overflow: auto;height:150px;width:200px;"><em><?=$row['remark']?></em></div> 
                                             
                                                
                                            </td>

                                            
                                             
                                               <td><?php 
                                               
                                               
                                                $s=$row2["s_code"];
                                             
                                              if( $s=='N'){
                                                 
                                                 $class="label pull-left bg-green";
                                                 
                                             }else if($s=='C'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             else if($s=='U' ){
                                                  
                                                  $class="label pull-left bg-pink";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-orange ";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$row2["severity_name"].'</small>';
                                               
                                               
                                               
                                               
                                               
                                               
                                               ?></td>
                                             <td><?php
                                             
                                              $status=$row2["status"];
                                              
                                               if( $status=='processing' || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='closed'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{
                                                 
                                               $class="label pull-left bg-orange";  
                                                 
                                             }
                                             
            //--------------------------------------------CHECK STATUS FOR PAA--------------------------------------------------------------//
             $q7=" SELECT p.position,p.report_to, up.position_level FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where pp.person_id='".Yii::$app->user->identity->user_id."'  ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


if($row7['position_level']=='pa'){
    
 //----------------find who he reports to------------------------------------------------------
 $q8=" SELECT u.user_id FROM user u 
inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
where pp.position_id={$row7['report_to']}";

$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();

//----------------------get status--------------------------------------------
  $q="SELECT f.* FROM erp_document_flow_recipients as f
 where recipient={$row8['user_id']}  and f.document={$row2['id']} order by timestamp desc  ";
     $com = Yii::$app->db->createCommand($q);
     $rows2 = $com->queryAll(); 
    
    
    if(!empty($rows2)){
        $r2=$rows2[0];
        
        
        if($r2['status']=='pending'){
        
        $status='Waiting for Approval';
        $class="label pull-left bg-pink";
    }
    elseif($r2['status']=='done'){
        
        $status='Done';
        $class="label pull-left bg-green";
    }
    else if($r2['status']=='archived'){
        
        $status='Archived';
        $class="label pull-left bg-orange";
        
    }
        
    }
    

}
                
   
                                            
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                              ?>
                                              
                                              
                                              </td>
                                             
      
                                             
                                            
                                            
                                        </tr>

                                      <?php endif;?>
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>

                                 </div>
 </div>

 </div>
 
 
 </div>

</div>
 


        <?php
   
$script = <<< JS

 $('.action-archive').on('click',function () {

  var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Document will be archived !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, archive  it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
 
});
  }
})

    return false;

});

JS;
$this->registerJs($script);



?>



