<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "employement_type".
 *
 * @property int $id
 * @property string $name
 */
class EmploymentType extends \yii\db\ActiveRecord
{
     const EMPL_TYPE_PERM='PERM';
     const EMPL_TYPE_SEC='SEC';
     const EMPL_TYPE_ACT='ACT';
     const EMPL_TYPE_FTC='FTC';
     const EMPL_TYPE_CONS='CONS';
     const EMPL_TYPE_INT='INT';
     const EMPL_TYPE_OJT='OJT';
     const EMPL_TYPE_AFSAPU='SAP';
     const EMPL_TYPE_AFRIB='RIB';
    
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employment_type';
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
            [['name'], 'string', 'max' => 250],
             [['code'], 'string', 'max' => 11],
              [['description'], 'string'],
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
        ];
    }
   public  static function badgeStyle($code){
         $style=''; 
         switch($code){
                   
                       case  self::EMPL_TYPE_PERM :
                          
                          $style='badge badge-success';
                          
                          break;
                        
                         case self::EMPL_TYPE_FTC  :
                         case self::EMPL_TYPE_SEC :
                          $style='badge badge-info';
                         break;
                          
                          case self::EMPL_TYPE_CONS  :
                          $style='badge badge-primary';
                         break;
                         case self::EMPL_TYPE_INT :
                         case self::EMPL_TYPE_OJT  :
                        
                         $style='badge badge-secondary';
                        
                         break;
                        
                        case self::EMPL_TYPE_AFSAPU  :
                        case self::EMPL_TYPE_AFRIB :
                        case self::EMPL_TYPE_ACT :
                         $style='badge badge-warning';
                         break;  
                       
                         default:
                         $style='badge badge-secondary';
                       
                        
                }
                
                return  $style;
    }
    
 public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['id' => 'employee'])->viaTable('emp_employment', ['employment_type' => 'code']);
    }   
}
