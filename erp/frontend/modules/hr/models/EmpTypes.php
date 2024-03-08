<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_type".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class EmpTypes extends \yii\db\ActiveRecord
{
     const EMP_TYPE_EMP='EMP';
     const EMP_TYPE_INT='INT';
     const EMP_TYPE_CONS='CONS';
     const EMP_TYPE_OJT='OJT';
     const EMP_TYPE_AFSAPU='AFSAPU';
     const EMP_TYPE_AFRIB='AFRIB';
   
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_types';
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
            [['name','code','report_name','category'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['code','category'], 'string', 'max' => 11],
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
                   
                       case  self::EMP_TYPE_EMP :
                          
                          $style='badge badge-success';
                          
                        break;
                         case self::EMP_TYPE_INT :
                         case self::EMP_TYPE_OJT  :
                        
                         $style='badge badge-info';
                        
                         break;
                         case self::EMP_TYPE_CONS  :
                          $style='badge badge-primary';
                         break;
                        case self::EMP_TYPE_AFSAPU  :
                        case self::EMP_TYPE_AFRIB :
                        
                         $style='badge badge-secondary';
                         break;  
                       
                         default:
                         $style='badge badge-warning';
                       
                        
                }
                
                return  $style;
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['employee_type' => 'code']);
    }
    
     public function getCategory0()
    {
        return $this->hasOne(EmpCategories::className(), ['code' => 'category']);
    }
}
