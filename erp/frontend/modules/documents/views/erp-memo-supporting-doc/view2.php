



<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\LinkPager;
use yii\base\View;

use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
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


 $ser_domain='https://rac.co.rw';
 $doc_path=Yii::$app->request->baseUrl . '/'.$model->doc_upload;
 $full_path=$ser_domain.$doc_path;
 $id=$model->id;
                                                      

?>

<div id="content">

<div style="height: 600px;" id="vcontainer"></div>
 
 



</div>


  <?php

$serverURL=Url::to(['erp-memo-annotations/annotations-handler']);
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


JS;
$this->registerJs($script);
?>


