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
      $requestUrl=Url::to(['payroll-run-reports/pdf-data','id'=>$model->id,'wf'=>$wf,'approval_id'=>$approval_id]);
      $full_path=$host.$requestUrl;
      $attachments =$model->attachments;
    
     ?>



<figure>
  <div style="height: 600px;" id="prl-rpt-<?php echo $model->id ?>"></div>
  <figcaption><?php echo $model->rpt_desc?></figcaption>
 

</figure>


<div class="card-header with-border">
                            <h3 class="card-title"><i class="fas fa-book"></i> File Attachments</h3>
                     
                       </div>        
    <div class="table-responsive">
                  <table id="tbl-attach" class="table">
                    <thead>
                    <tr>
                        <th>Attached File(s)</th>
                          <th>Title</th>
                         
                     
                       
                 </tr>
                    
                    </thead>
                    <tbody>
                    <?php if(!empty($attachments)) foreach($attachments as $attachment):  ?> 
                  
                    <tr>
                        
                        <td>
                            
                         <?php
                         
                          $icon =Html::tag('i',null,
           ['class'=>"far fa-fw fa-file-pdf text-red "]);       
            
          echo $icon.Html::a( $attachment->fileName,['payroll-run-report-attachments/pdf','id'=>$attachment->id],
           ['class'=>'text-dark action-modal']);
            
                         ?>
                            
                            
                        </td>
                     
                   
                     <td nowrap><?= $attachment->title?></td>
              
                
                  
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div> 






           

  <!--commenting   --> 
  
          <?php
 $serverURL=Url::to(['payroll-reps-approval-annotations/annotations-handler']);
 $filename=$model->rpt_desc;
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
 
  showViewer('{$full_path}','{$serverURL}','{$id}', user ,'prl-rpt-{$id}','{$filename}');
  
  
      $('#tbl-attach').DataTable( {
      destroy: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      //autoWidth: true,
      // responsive: true,
      language: {
      emptyTable: " "
    }
       
     /*language : {
        "zeroRecords": " "             
    },*/
     
		
	
	} );
});



JS;
$this->registerJs($script);

 ?>

