<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "statutory_deductions".
 *
 * @property int $id
 * @property string $description
 * @property string $abbr
 * @property string $calc_basis
 * @property string $ee_contribution
 * @property string $er_contribution
 * @property int $active
 * @property int $user
 * @property string $timestamp
 */
class StatutoryDeductions extends \yii\db\ActiveRecord
{
     public static $calcBasis=array('BP'=>'% of Base Pay','PE'=>'% of Pensionable Pay','GP'=>'% of Gross Pay','formula'=>'Formula');
     public $eeRate=0;
     public $erRate=0;
     
 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statutory_deductions';
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
            [['description', 'abbr', 'calc_basis', 'ee_contribution', 'er_contribution','eeRate','erRate', 'user'], 'required'],
            [['calc_basis'], 'string'],
            [['ee_contribution', 'er_contribution','eeRate','erRate'], 'number'],
            [['active', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['abbr'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'abbr' => 'Abbr',
            'calc_basis' => 'Calc Basis',
            'ee_contribution' => 'Ee Contribution',
            'er_contribution' => 'Er Contribution',
            'active' => 'Active',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
  
   public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
        $this->user=Yii::$app->user->identity->user_id;
        return true;
    }
    return false;
}
   
/*public function afterFind()
 {
      $this->eeRate=floatval($this->ee_contribution)*100;
      $this->erRate=floatval($this->er_contribution)*100;
      return parent::afterFind();
 }*/
    
   /* public function beforeSave($insert) {
    
     $this->ee_contribution=floatval($this->eeRate)/100;
     $this->er_contribution=floatVal($this->erRate)/100;
     return parent::beforeSave($insert);
      
     
    }*/
    
  
}
