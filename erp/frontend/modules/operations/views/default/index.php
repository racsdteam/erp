<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Passengers Manifeste Informations';


if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

if (Yii::$app->session->hasFlash('failure')){

$msg=  Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  

   }
   
$role=Yii::$app->user->identity->user_level;

?>

<style>
    
    a.div-clickable{ display: block;
       height: 100%;
       width: 100%;
       text-decoration: none;}   
       
       
       
   </style>
<h2>Welcome To Operations Module</h2>
   
 