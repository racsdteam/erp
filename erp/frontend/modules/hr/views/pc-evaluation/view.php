<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\db\Query;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use common\models\User;
use frontend\modules\hr\models\PcTarget;
use frontend\modules\hr\models\PcTargetAchievedResult;
use frontend\modules\hr\models\PcReportOther;
use frontend\modules\hr\models\PcEvaluationComments;
use dosamigos\tinymce\TinyMce;



$this->title = $model->evaluation_period." created at ".$model->timestamp;
$this->params['breadcrumbs'][] = ['label' => 'Pc Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$current_user_id=Yii::$app->user->identity->user_id;
$comment= new PcEvaluationComments;
//--------------------all Users------------------------------------------------
$users=ArrayHelper::map(User::find()->all(), 'id',function($item){
    return  $item->first_name.' '.$item->last_name;
}) ;
?>
<div class="pc-report-view">
<div class="card card-success card-outline card-tabs">
    <div class="card-header p-0 pt-1">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
 <div class="card-body">
     <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'evaluation_period',
            [
                 'label'=>'IMIHIGO Financial Year',
                 'value'=>call_user_func(function ($data) {
                     
                     
                return $data->financial_year;
            }, $model->pa),
                 
                
                ],
          
            [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>call_user_func(function ($data) {
                     $_status=$data->status;
                     if($_status=='drafting' || $_status=='returned'){$class="badge badge-danger";}else{$class="badge badge-success";}
                     
                     $badge='<small class="'.$class.'" ><i class="far fa-clock"></i> '. $_status.'</small> ';
                    
                return $badge;
            }, $model)
                ],
           
                 [
                 'label'=>'Created By',
                 'value'=>call_user_func(function ($data) {
                     $_user=$data->user;
                return $_user!=null? $_user->first_name ." ".$_user->last_name : '';
            }, $model),
                 
                
                ]
        ],
    ]) ?>
                      

</div>
</div>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
    <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" 
                href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">
                    <i class="fas fa-cubes"></i> Imihigo target Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" 
                role="tab" aria-controls="custom-content-above-profile" aria-selected="false"><i class="fas fa-cubes"></i> None Imihigo Report
                </a>
              </li>
                  
                </ul>
              </div>

 <div class="card-body">
  <div class="tab-content" id="custom-content-above-tabContent">
              <div class="tab-pane fade active show" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
  <?php 
  $targets_acheivement=PcTargetAchievedResult::find()->where(["pc_evaluation_id"=>$model->id])->all(); 
  ?>
                           
                           
                            <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Performance Reports List</h3>
                       </div>
               
           <div class="card-body">
<?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>   
<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1>Imihigo target Report</h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Target report', ['pc-target-achieved-result/create','evaluation_id'=>$model->id], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Report']) ?>
    </p>               
                </div>
     
       
   </div>
<?php endif ?>        
          
   
    <?php 
    
    
   
    ?>
    
  <div class="table-responsive">
      
      <table class="table  table-bordered table-striped">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                              <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
                                        <th align="center">Actions</th>
                                        <?php endif ?>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                        <th>deliverable</th>
                                          <th>	deliverable Indicator</th>
                                           <th>Targert Status</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($targets_acheivement)){
                                    foreach($targets_acheivement as $target_acheivement):
                                    $target=PcTarget::find()->where(["id"=>$target_acheivement->target_id])->one();    
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr>
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                          <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$target_acheivement->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td> 
                                         <?php endif ?>
                                     <td class="bg-<?= $target_acheivement->status ?>">
                                         
                                    <?= $target->output ?> 
                                    </td>    
                                    <td>
                                    <?= $target->indicator ?>
                                    </td>
                                     <td>
                                    <?= $target_acheivement->deliverable ?> 
                                    </td>    
                                    <td>
                                    <?= $target_acheivement->indicator ?>
                                    </td>
                                      <td class="bg-<?= $target_acheivement->status ?>">
                                    <?= $target_acheivement->status ?> 
                                    </td>    
                                   
                                
                                        </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table> 

</div>
</div>
</div>
</div>
                 
                 
              
              <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                  <?php 
  $other_activities=PcReportOther::find()->where(["pc_evaluation_id"=>$model->id])->all(); 
  ?>
                 
                 
                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Performance None Imihigo Reports</h3>
                       </div>
               
           <div class="card-body">
<?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>   
<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1>None Imihigo  Report</h1>
 
 <div class="float-right">
               
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Target report', ['pc-report-other/create','evaluation_id'=>$model->id], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Report']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
     
       
   </div>
<?php endif ?>
   
    <?php 
    
    
   
    ?>
    
  <div class="table-responsive">
      
      <table class="table  table-bordered table-striped">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                              <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
                                        <th align="center">Actions</th>
                                        <?php endif ?>
                                           <th align="center">Project Name</th>
                                           <th >Start Date</th>
                                           <th >End Date</th>
                                             <th align="center">Project Description</th>
                                        <th>Completed Work</th>
                                           <th>Project Status</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($other_activities)){
                                    foreach($other_activities as $other_activitie):
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr>
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                          <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["pc-target/delete",'id'=>$other_activitie->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Target'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td> 
                                        <?php endif ?> 
                                     <td class="bg-<?= $other_activitie->status ?>">
                                    <?= $other_activitie->project_name ?> 
                                    </td>    
                                    <td>
                                    <?= $other_activitie->start_date ?>
                                    </td>
                                     <td>
                                    <?= $other_activitie->end_date ?>
                                    </td>
                                    <td>
                                    <?= $other_activitie->project_description ?>
                                    </td>
                                     <td>
                                    <?= $other_activitie->completed_work ?> 
                                    </td>    
                                    <td class="bg-<?= $other_activitie->status ?>" > 
                                    <?= $other_activitie->status ?>
                                    </td>
                                    
                                        </tr>
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table> 

</div>
</div>
</div>
              </div>
             
            </div>
                
             

          
</div>
</div>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class="card card-success card-outline card-tabs">
    <div class="card-header p-0 pt-1">
    <h3>Submition And  Comment Panel</h3>
</div>
 <div class="card-body">
<div class="row">
    
     <div class="p-2 bg-warning col-md-12 " >
  
  <div class="qa-message-list " id="wallmessages" >
  <?php   
        
        $query = new Query;
        $query	->select([
            'e.*',
            
        ])->from('pc_evaluation_comments as e ')->where(['e.pc_evaluation_id' =>$model->id])->orderBy([
                'timestamp' => SORT_DESC,
                
              ]);

       // $command = $query->createCommand();
        $rows= $query->all(Yii::$app->db4);
        
        $count=0;

        ?> 	
        <?php if(!empty($rows)) : ?> 
 
       <?php foreach($rows as $row):?>
       
        <?php 

$q7=" SELECT u.first_name,u.last_name,u.user_image,p.position
FROM user as u inner join erp_persons_in_position as pp on pp.person_id=u.user_id 
inner join  erp_org_positions as p  on p.id=pp.position_id
where pp.person_id='".$row['user_id']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


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

                   <?php  if($row['comment'] !=''):?>
					
					<div class="message-item" id="m2">
						<div class="message-inner">
							<div class="message-head clearfix">
								<div class="timeline1 avatar pull-left"><a href="#"><img src="<?=$user_image?>"></a></div>
								<div class="user-detail">
									<h5 class="handle"><?php echo $row7['first_name'];  ?> <?php echo $row7['last_name'];  ?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?=$mon?> <?=$date?>, <?=$yr?></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-v-content">
							<?php echo $row['comment'];$count++; ?>
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
  
     
      <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                               'action' => ["pc-evaluation-comments/create?evaluation_id=".$model->id],
                               'method' => 'post',
                              
                               ]); ?>

    <?= $form->field($comment, 'comment')->widget(TinyMce::className(), [
    'options' => ['rows' => 5],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]); ?>

 
    <div class="form-group">
        <?= Html::submitButton('Send Comment', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

     
     
     </div> 
      <div class="card-footer">
     
     <div class="float-right">
         <?php if($current_user_id==$model->user_id && $model->status!="submitted"): ?>
      <p>
         <?= Html::a('<i class="fas fa-paper-plane"></i> Submit Report', ['pc-evaluation/submit','id'=>$model->id], ['class' => 'btn btn-outline-primary btn-lg submit','title'=>'submit Report']) ?>
      </p>  
      <?php endif; ?>
      
   </div>
     
     
     </div>  
     </div>  
      </div>  
</div>

</div>
<?php
$script = <<< JS

$(document).ready(function(){
  $(".select2").select2({width:'100%',theme: 'bootstrap4'});
 
 $('.submit').on('click',function (e) {
         
 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This report will be submit for review!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Submit it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
    if(data.flag==true){
        
        Swal.fire(
  'Success!',
  data.msg,
  'success'
)
    }else{
        
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: data.msg,

})  
    }
});
  }
})
    
    return false;

});  





 });
                          


JS;
$this->registerJs($script);

?>


