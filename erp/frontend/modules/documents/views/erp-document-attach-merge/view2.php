



<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\LinkPager;
use yii\base\View;


use frontend\assets\PdfTronAsset;
PdfTronAsset::register($this);


use frontend\assets\PdfTronAsset2;
PdfTronAsset2::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attachments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<p>


<?php

                                            
/*
$ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$doc->doc_upload;
$full_path=$ser_domain.$doc_path;
$id=$doc->id;*/

?>




</p>
 
 
 <?php
foreach ($models as $model) { 


$query3 = new Query;
                                                        $query3	->select([
                                                            'attch_ver_upload.*'
                                                            
                                                        ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
                                                            'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$model->attachement])->orderBy([
                                                                'version_number' => SORT_DESC,
                                                                
                                                              ]);	
                                            
                                                        $command3 = $query3->createCommand();
                                                        $rows3= $command3->queryAll();
                                                        
                                                        $ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$rows3[0]['attach_upload'];
$full_path=$ser_domain.$doc_path;
$id=$model->attachement;
                                                      

?>

<div id="content">

<div style="height: 600px;" id="vcontainer"></div>
 
 

<?php 

echo LinkPager::widget([
    'pagination' => $pages,
]);

}?>

</div>

 
  <?php

$serverURL=Url::to(['erp-document-annotations/annotations-handler']);
$lib='https://rac.co.rw/erp/lib';

$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.* from erp_persons_in_position as pp inner join user as 
        u on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id where pp.person_id={$user_id} ";
        $com2 = Yii::$app->db->createCommand($q2);
         $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
         $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
 
 
  $this->registerJs(
    "showViewer( '{$full_path}','{$serverURL}','{$id}','{ $author}','vcontainer' );",
    $this::POS_READY,
    'viewer'
);


$script = <<< JS


 /*viewerElement.addEventListener('ready', function(e) {
  var viewerInstance = myWebViewer.getInstance();
 
});*/

$('#content .pagination li a').on('click', function (e) {

   e.preventDefault();

        e.stopPropagation();

        $.get($(this).attr("href"))

        .done(function (data) {

            //$("#pgmProductList").html(data);
            //console.log(data);
           $('#modal-action')
   .find('.modal-body')
   .html(data);

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
});
JS;
$this->registerJs($script);
?>


