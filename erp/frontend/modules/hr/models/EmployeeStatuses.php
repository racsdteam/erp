<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "employee_statuses".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $payroll_status
 */
class EmployeeStatuses extends \yii\db\ActiveRecord
{
     const STATUS_TYPE_ACT='ACT';//--active
     const STATUS_TYPE_NACT='NACT';//--notactive
     const STATUS_TYPE_TERM='TERM';//--termited
     const STATUS_TYPE_RET='RET';//--retired
     const STATUS_TYPE_RESIG='RESIG';//--resigned
     const STATUS_TYPE_SUSP='SUSP';//--suspended
     const STATUS_TYPE_PROB='PROB';//--probation
     const STATUS_TYPE_OLV='OLV';//--new hire
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_statuses';
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
            [['payroll_status'], 'string'],
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
            'code' => 'Code',
            'description' => 'Description',
            'payroll_status' => 'Payroll Status',
        ];
    }
         public  static function badgeStyle($code){
         $style=''; 
         switch($code){
                   
                       case  self::STATUS_TYPE_ACT:
                          
                          $style='badge badge-success';
                          break;
                        
                         case self::STATUS_TYPE_PROB :
                          $style='badge badge-warning';
                         break;
                         
                         case self::STATUS_TYPE_RET :
                         case self::STATUS_TYPE_RESIG :
                          $style='badge badge-pink';
                         break;
                          
                         case self::STATUS_TYPE_TERM :
                         case self::STATUS_TYPE_SUSP :
                         case self::STATUS_TYPE_NACT :    
                         
                         $style='badge badge-danger';
                        
                         break;
                        
                         default:
                         $style='badge badge-info';
                       
                        
                }
                
                return  $style;
    }
}
