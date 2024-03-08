
<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use common\models\User;
use common\models\UserHelper;
use common\models\UnitHelper;
use common\models\ErpOrgUnits;
use common\models\UserRoles;

use common\models\GroupsAccessList;
use common\models\UsersAccessList;
use common\models\RolesAccessList;
use common\models\Tblacls;
use common\models\Tblgroups;
use yii\bootstrap4\LinkPager2;
use frontend\components\DocVersionsLinkPager ;
use yii\widgets\Pjax;


use  frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);


?>

<style>
     
     .doc-meta{color: #6c757d;
   }
   .vclass{
       
      display: inline;
      padding-left: 10px;
   }
   .version-pager{
       
       text-align:center;
   }
  
 </style>


         
         <?php foreach ($contentmodels as $content) :?>
 
           <?php Pjax::begin(['id' => 'contents']) ?>
  
                  <?php
                  if($doc->status){
                      $status="Checked-Out";
                      $class="badge badge-warning";
                      $ic_class="fa fa-arrow-circle-up";
                  }else{$status="Checked-In";
                       $class="badge badge-primary";
                        $ic_class="fa fa-arrow-circle-down";
                  }
           $user=UserHelper::getUserInfo($doc->owner) ;
   
           $pos=UserHelper::getPositionInfo($doc->owner);
  
           $author=$user['first_name']." ".$user['last_name']." / ".$pos['position']; 
                  ?>
             
         
                    
                    
                    <div class="row">
     
     
     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
         <div class="card">
          <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i>Summary</strong>
                   <p>
                   <span class="doc-meta">Name :</span> <?php echo $doc->name ?></br>
                   <span class="doc-meta">Author :</span> <?php echo  $author?></br>
                   <span class="doc-meta">Last Modified :</span> <?php echo $content->date ?></br>
                   <span class="doc-meta">Status :</span><span class="<?php echo $class ?>"><?= $status?>  <i class="<?php echo  $ic_class?>"></i></span> </br>
                  
                   <span class="doc-meta">Comments :</span> <?php echo $doc->comment ?></br>
</p>
                <hr>

              
                <strong><i class="fas fa-file-alt mr-1"></i>File</strong>
                <p>
                  <span class="doc-meta">File Name :</span>  <?php echo $content->orgFileName ?></br>
                   <span class="doc-meta">File Size :</span> <?php echo $content->getSize() ?></br> 
                   <span class="doc-meta">Version :</span> <?php echo 'v'.$content->version.'.0' ?></br> 
                </p>

                
              <hr>
              
              <strong><i class="fas fa-paperclip mr-1"></i>Attachement(s)</strong>

                <p>
                    <ul class="list-unstyled ">
                
                 <?php $files=$doc->getDocumentFiles();   ?> 
                  
                  <?php if(!empty($files)) : ?>
                  
                  <?php foreach($files as $file) :?>
                
                <li>
                  <a href="<?php echo $file->getPath()  ?>"   class="btn-link text-secondary doc-file">
                      <i class="<?php echo getIconByType($file->fileType) ?>"></i> <?= $file->orgFileName?></a>
                </li>
                
               
                <?php endforeach;?>
                
                 
                
                <?php else : ?>
                
                <p class="btn-link text-secondary">No Attachements Found</p>
                
                <?php endif;?>
              
              </ul> 
                </p>

                <hr>

                <strong><i class="far fa-copy  mr-1"></i>Version(s) History</strong>

                
               <?php if($pages->pageCount==1) :?>
               
                <p class="btn-link text-secondary">No previous Versions</p>
               
               <?php endif;?>
                
                <p>
                    
                 
                  
                   <?php
                 
                   
        echo LinkPager2::widget([
    'pagination' => $pages,
     'prevPageLabel' =>false,   // Set the label for the "previous" page button
        'nextPageLabel' =>false,
          'firstPageLabel'=>false,
          'options'=>['class'=>'version-pager']
           
          //'linkOptions'=>['label'=>'']
        
]);
        
        ?>  
          
                    
                </p>
              </div>
           </div>
                 
              
                   
                   
              
              
        
         </div>
         
         
         
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
              
            
 
 <?php 
    
$full_path=$content->getContentPath();
if($content->fileType!='pdf')
$full_path.='.'.$content->fileType;

$id=$content->id;

                                                   
 
 ?>
 
          <div  id="Contentpage<?php echo $id ?>" style="height: 600px;"></div>
        
       
      
        
         </div>
         
         
        
             
            
       
         
         </div>
                    
 
   <?php

$serverURL=null;
$user_id=Yii::$app->user->identity->user_id;

$q2="SELECT u.first_name,u.last_name,pos.position,pos.position_code,s.signature,r.role_name from user  as u 
        inner join erp_persons_in_position  as pp on pp.person_id=u.user_id 
        inner join erp_org_positions as pos on pos.id=pp.position_id 
        inner join user_roles as r on r.role_id=u.user_level
        left join signature as s on u.user_id=s.user where pp.person_id={$user_id} and pp.status=1 ";
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
$q3="SELECT p.* from erp_org_positions as p inner join erp_persons_in_position as pp on pp.position_id=p.id where pp.person_id={$row1['person_interim_for']} ";
        $com3= Yii::$app->db->createCommand($q3);
        $row2 = $com3->queryOne();
       
        if(!empty($row2) && isset($row2['position_code'])){
            
            $pos_code_int= $row2['position_code'];
        }
}



$script = <<< JS

$(function() {
   
  
var fn="{$fn}";
var ln="{$ln}";
var role="{$role}";
var position="{$position}";
var pos_code_u="{$pos_code_user}";
var pos_code_int="{$pos_code_int}";
var signature="{$signature}";


var user = {fn: fn, ln:ln,role:role, pos:position,pos_code_u:pos_code_u,pos_code_int:pos_code_int,signature: signature};


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'Contentpage{$id}' );

   
});

$('.version-pager .pagination li a').on('click', function (e) {

       e.preventDefault();

        e.stopPropagation();
        
       var url=$(this).attr("href")+"&pajax=1"

        $.get(url)

        .done(function (data) {

       $("#w0-tab0").html(data);

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
        
        return false;
});

JS;
$this->registerJs($script);
?>

<?php Pjax::end() ?>
 <?php endforeach?>
  
    
  
  
   <?php
function getIconByType($type){
    
 $fileTypes=array("pdf"=>"far fa-file-pdf","doc"=>"far fa-file-word","docx"=>"far fa-file-word","ppt"=>"far fa-file-powerpoint","pptx"=>"far fa-file-powerpoint");  
 $fa_icon=null;
 
 foreach($fileTypes as $key=>$ficon){
     
     if($key==$type){
         
        $fa_icon=$ficon;
        break;
     }
     
    if(!$fa_icon){
        
       $fa_icon="far fa-file"  ;
    }
    
    
 }
   
   return $fa_icon; 
}

?>

