<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_statutory_details".
 *
 * @property int $id
 * @property int $employee
 * @property string $med_scheme
 * @property string $rama_no
 * @property string $mmi_no
 * @property string $emp_pension_no
 */
class EmpStatutoryDetails extends \yii\db\ActiveRecord
{
    public const MED_SCHEME_RAMA='RAMA';
    public const MED_SCHEME_MMI='MMI';
       
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_statutory_details';
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
            
            [['employee', 'emp_pension_no'], 'required', 'on'=>['create','update']],
            [['employee'], 'integer'],
            [['med_scheme'], 'string'],
            [['emp_med_no', 'emp_pension_no'], 'string', 'max' => 255],
            //[['emp_med_no','emp_pension_no'], 'unique'], //unique constraint temporary removed
            
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'med_scheme' => 'Med Scheme',
            'rama_no' => 'Rama No',
            'mmi_no' => 'Mmi No',
            'emp_pension_no' => 'Pension No',
        ];
    }
    
      public function getEmployee0(){
    
      return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
    
    public static function findByEmp($e){
        
        return self::find()->where(['employee'=>$e])->one();
    }
}
