<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
//use frontend\assets\PdfTronAsset;
//PdfTronAsset::register($this);


//use frontend\assets\PdfTronAsset2;
//PdfTronAsset2::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>


<?php

                                            

$ser_domain='https://rac.co.rw';
$doc_path=Yii::$app->request->baseUrl . '/'.$doc->doc_upload;
$full_path=$ser_domain.$doc_path;
$id=$doc->id;
//var_dump($full_path);
?>



</p>
 <div style="height: 600px;" id="viewer"></div>
 
  <?php

$serverURL=Url::to(['erp-document-annotations/annotations-handler']);
$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.* from erp_persons_in_position as pp inner join user as 
        u on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id where pp.person_id={$user_id} ";
        $com2 = Yii::$app->db->createCommand($q2);
         $row = $com2->queryOne();
         $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
$script = <<< JS


mine();
	
/*
var myObj = {
  author:'{$author}'
};
var viewerElement = document.getElementById('viewer');

  
  var myWebViewer = new PDFTron.WebViewer({
    path: 'https://rac.co.rw/erp/lib',
    l: 'Rwanda Airports Company(rac.co.rw):ENTERP:RAC ERP::B+:AMS(20200310):A2A591AD0457A60A3360B13AC9A2737820616F996CB37A0595857BAA1AE768AE62B431F5C7',
    initialDoc:'{$full_path}',
    custom: JSON.stringify(myObj),
    config: "https://rac.co.rw/erp/lib/config.js",
    serverUrl: '{$serverURL}',
    documentId: '{$id}'
    // replace with your own PDF file
    // optionally use WebViewer Server backend, demo.pdftron.com would later need to be replaced with your own server
    // pdftronServer: 'https://demo.pdftron.com'
  }, viewerElement);
 
*/
 /*viewerElement.addEventListener('ready', function(e) {
  var viewerInstance = myWebViewer.getInstance();
 
});*/
JS;
$this->registerJs($script);
?>
