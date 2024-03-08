<?php

namespace frontend\modules\assets0\models;

use Yii;

/**
 * This is the model class for table "asset_statuses".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class AssetStatuses extends \yii\db\ActiveRecord
{
     const STATUS_TYPE_DISPOSED='DSPL';
     const STATUS_TYPE_IN_STORAGE='STG';
     const STATUS_TYPE_IN_SERVICE='IS';
     const STATUS_TYPE_IN_REPAIR='IR';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_statuses';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db7');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
        ];
    }
    
       
     public  static function badgeStyle($code){
         $style=''; 
         switch($code){
                   
                       case  self::STATUS_TYPE_IN_SERVICE :
                          
                          $style='badge badge-success';
                          
                        break;
                         case self::STATUS_TYPE_IN_STORAGE :
                         
                         $style='badge badge-info';
                        
                         break;
                       
                        case self::STATUS_TYPE_DISPOSED :
                      
                        
                         $style='badge badge-danger';
                         break;  
                       
                         case self::STATUS_TYPE_IN_REPAIR :
                      
                        
                         $style='badge badge-warning';
                         break;
                         
                         default:
                         $style='badge badge-secondary';
                       
                        
                }
                
                return  $style;
    }
    
}
