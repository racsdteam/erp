



<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\LinkPager;
use yii\base\View;
use common\models\ErpDocumentAttachment;

use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attachments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<style>
figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  border: thin silver solid;
  
}
 
    

</style>
 
 
 <?php
foreach ($models as $model) { 

$attach=ErpDocumentAttachment::find()->where(['id'=>$model->attachement])->One();
//--------------------------------att version------------------------------------------
  $q5 = new Query;
                                            
                                           $q5 = new Query;
                                            $q5	->select([
                                                'vers.*'
                                                
                                            ])->from('erp_attachment_version as vers ')->where(['attachment' =>$model->attachement])->orderBy([
  'timestamp' => SORT_DESC,
  
]);
                                
                                            $command5 = $q5->createCommand();
                                            
                                            $row1= $command5->queryAll();

//------------------------------------------------------latest att version  uploads-------------------------------

$query3 = new Query;
                                                        $query3	->select([
                                                            'attch_ver_upload.*'
                                                            
                                                        ])->from('erp_attachment_version_upload as attch_ver_upload ')->join('INNER JOIN', 'erp_attachment_version as attch_ver',
                                                            'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver_upload.attach_version' =>$row1[0]['id']])->orderBy([
                                                                'version_number' => SORT_DESC,
                                                                
                                                              ]);	
                                            
                                                        $command3 = $query3->createCommand();
                                                        $rows3= $command3->queryAll();
                                                        
                                                        $ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$rows3[0]['attach_upload'];
$full_path=$ser_domain.$doc_path;
$id=$attach->id;
                                                      

?>


    
  <figure>
  <div style="height: 600px;" id="viewerpage<?php echo $id ?>"></div>
  <figcaption><?php echo $attach->attach_title ?></figcaption>
</figure> 


 
 
<div id="linker1" style="background:#f5f5f5;" >
 <?php 

echo LinkPager::widget([
    'pagination' => $pages,
]);

}?>   
</div>




 
  <?php

$serverURL=Url::to(['erp-document-annotations/annotations-handler']);


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
var fn="{$fn}";
var ln="{$ln}";

var user = {fn: fn, ln:ln, pos:'{$position}',signature:'{$signature}'};


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'viewerpage{$id}' );

//---------------------------preventing page reload--------------------------------------------

$('#linker1 .pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();
        var step='{$step}'
        var url=$(this).attr("href")+"&active-step="+step
       
        $.get(url)

        .done(function (data) {

            //$("#pgmProductList").html(data);
            console.log(data);
          /* $('#modal-action')
   .find('.modal-body')
   .html(data);*/
   $("#step-2").html(data);

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});
JS;
$this->registerJs($script);
?>


