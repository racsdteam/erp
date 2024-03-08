<?php

namespace frontend\modules\assets0\models;

use Yii;

/**
 * This is the model class for table "asset_conditions".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class AssetConditions extends \yii\db\ActiveRecord
{
     const COND_TYPE_EXCELLENT='E';
     const COND_TYPE_FAIR='F';
     const COND_TYPE_GOOD='G';
     const COND_TYPE_POOR='P';
     const COND_TYPE_SCRAP='S';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_conditions';
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
                   
                       case  self::COND_TYPE_EXCELLENT :
                          
                          $style='badge badge-success';
                          
                        break;
                         case self::COND_TYPE_GOOD :
                         
                         $style='badge badge-info';
                        
                         break;
                        
                       case self::COND_TYPE_FAIR :
                      
                        
                         $style='badge badge-warning';
                         break;
                         
                         
                          case self::COND_TYPE_POOR :
                      
                        
                         $style='badge badge-danger';
                         break;
                         
                          case self::COND_TYPE_SCRAP :
                      
                        
                         $style='badge badge-danger';
                         break;
                         
                         default:
                         $style='badge badge-secondary';
                       
                        
                }
                
                return  $style;
    }
}
