<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_supplements".
 *
 * @property int $id
 * @property int $employee
 * @property int $item
 * @property string $item_code
 * @property string $item_categ
 * @property string $amount
 * @property string $pay_group
 * @property int $active
 * @property int $user
 * @property string $timestamp
 */
class EmpPaySupplements extends \yii\db\ActiveRecord implements WageInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_supplements';
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
            [['employee', 'item', 'item_code', 'item_categ', 'pay_group', 'user'], 'required'],
            [['employee','org_unit', 'position', 'item', 'active', 'user'], 'integer'],
            [['active'], 'default', 'value'=>1],
            [['timestamp'], 'safe'],
            [['item_code', 'item_categ', 'pay_group'], 'string', 'max' => 11],
            [['amount'], 'string', 'max' => 255],
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
            'item' => 'Item',
            'item_code' => 'Item Code',
            'item_categ' => 'Item Categ',
            'amount' => 'Amount',
            'pay_group' => 'Pay Group',
            'active' => 'Active',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
   
        function getEmployee0(){
//------------------------employee----------------------------------------

     return $this->hasOne(Employees::className(), ['id' => 'employee']) ;

} 
         function getSupplType(){
//-----------------------------pay item----------------------------------------

     return $this->hasOne(PayItems::className(), ['id' => 'item']) ;

}

         function getPayGroup0(){
//-----------------------------pay item----------------------------------------

     return $this->hasOne(PayGroups::className(), ['code' => 'pay_group']) ;

}

  public function beforeValidate()
{
    if (parent::beforeValidate()) {
       
         
         if(empty($this->item_code))
          $this->item_code=$this->supplType->code;
         if(empty($this->item_categ))
          $this->item_categ=$this->supplType->category;
         
         if(empty($this->user))
          $this->user=Yii::$app->user->identity->user_id; 
        
        
        return true;
    }
    return false;
}

public function beforeSave($insert) {

     $empl=$this->employee0->employmentDetails;

    if(empty($this->org_unit))
     $this->org_unit=$empl->orgUnitDetails->id;
     
     if(empty($this->position))
     $this->position=$empl->positionDetails->id;

    return parent::beforeSave($insert);
}

public function getWageAmount(){
    
    return $this->amount;
}

public function getWageCode(){
    
   return $this->supplType->code;
}
}
