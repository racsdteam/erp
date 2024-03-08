<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;

/*
use frontend\assets\PdfTronAsset;
PdfTronAsset::register($this);


use frontend\assets\PdfTronAsset2;
PdfTronAsset2::register($this);

use frontend\assets\PdfViewerAsset;
PdfViewerAsset::register($this);*/

use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);


use common\models\ErpAttachmentVersionUpload;
/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>


<?php

$model=ErpAttachmentVersionUpload::find()->where(['id'=>$attach])->One();

$ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$model->attach_upload;
$full_path=$ser_domain.$doc_path;

//var_dump($full_path);
?>



</p>
 <div style="height: 600px;" id="attachview"></div>
 
  <?php
$serverURL=Url::to(['erp-document-annotations/annotations-handler']);
$id=$model->id;
$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.* from erp_persons_in_position as pp inner join user as 
        u on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id where pp.person_id={$user_id} ";
        $com2 = Yii::$app->db->createCommand($q2);
         $row = $com2->queryOne();
         $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
$script = <<< JS
showViewer( '{$full_path}','{$serverURL}','{$id}',"$author",'attachview' );
JS;
$this->registerJs($script);
?>
