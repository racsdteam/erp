<?php
namespace common\models;

use Yii;
use yii\helpers\Url;

class DmsUtils
{
    

public static function getUploadDir(){

$uploadDir=Yii::getAlias(Yii::$app->getModule('racdms')->dataDir);

return $uploadDir;
    
}

public static function getUploadPath(){

$urlBase=Url::base('https');//--https://www.rac.co.rw/erp--

$app=end(explode('/',Yii::getAlias('@app')));//--frontend--

$uploadDir=pathinfo(self::getUploadDir());

$dataDir=end(explode('/',$uploadDir['dirname'])).'/'.$uploadDir['basename'];//--data/dms--

$uploadPath=$urlBase.'/'.$app.'/'.$dataDir;

return $uploadPath; 
    
}



public static function getContentSize($bytes){
    
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $label[$i] );   
    
}

}

?>
