<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pay_component_types".
 *
 * @property int $id
 * @property string $name
 */
class PayItemCategories extends \yii\db\ActiveRecord
{
    const CAT_B='BASE';
    const CAT_E='E';
    const CAT_D='D';
    const CAT_SD='SD';
    const CAT_SC='SC';
    const CAT_N='N';
    const CAT_G='G';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_item_categories';
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
            [['name','code'], 'required'],
            [['name','code'], 'string', 'max' => 255],
            [['code'], 'unique'],
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


  
    public  function  getPayItems(){
    
     return $this->hasMany(PayItems::className(), ['category' => 'id']);
         
        
    }
    
 
}
