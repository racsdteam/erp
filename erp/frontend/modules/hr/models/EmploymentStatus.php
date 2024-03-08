<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "employment_status".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class EmploymentStatus extends \yii\db\ActiveRecord
{
     const STATUS_TYPE_AE='AE';//--active
     const STATUS_TYPE_NAE='NAE';//--notactive employee
     const STATUS_TYPE_NA='NA';//--notactive
     const STATUS_TYPE_NH='NH';//--new hire
     const STATUS_TYPE_TE='TE';//--termited
     const STATUS_TYPE_RE='RE';//--retired
     const STATUS_TYPE_SUSP='SUSP';//--laid off
     const STATUS_TYPE_PROB='PROB';//--probation
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employment_status';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
             [['code'], 'string', 'max' => 11],
            [['description'], 'string', 'max' => 400],
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
            'description' => 'Description',
        ];
    }
     public  static function badgeStyle($code){
         $style=''; 
         switch($code){
                   
                       case  self::STATUS_TYPE_AE:
                          
                          $style='badge badge-success';
                          break;
                         case self::STATUS_TYPE_NH :
                          $style='badge badge-warning';
                         break;
                       
                         case self::STATUS_TYPE_PROB :
                          $style='badge badge-info';
                         break;
                          
                         case self::STATUS_TYPE_TE :
                         case self::STATUS_TYPE_SUSP :
                         
                         $style='badge badge-danger';
                        
                         break;
                        
                         default:
                         $style='badge badge-secondary';
                       
                        
                }
                
                return  $style;
    }
}
