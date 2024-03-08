<?php

namespace frontend\modules\hr\models;

use Yii;
use NXP\MathExecutor;
/**
 * This is the model class for table "pay_structures".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class PayTemplates extends \yii\db\ActiveRecord
{
  
   
 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_templates';
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
            [['name','code','pay_group'], 'required'],
            [['description'], 'string'],
           [['code'], 'string', 'max' => 11],
          [['name'], 'string', 'max' => 255],
           [['pay_group'], 'integer']
        
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
    

public function removeItems($deletedIDs){
    
     PayTemplateItems::deleteAll(['id' =>$deletedIDs]);
}

public function getEmpGroup()
{
    return $this->hasOne(PayGroups::className(), ['id'=>'pay_group']);
}


public function getLineItems()
{
 return $this->hasMany(PayTemplateItems::className(), ['tmpl' => 'id'])->orderBy([
    'display_order' => SORT_ASC     
    ]);
}

public function earningsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->earnings()->fixed();
    }
])->orderBy([
    'display_order' => SORT_ASC    
])->where(['tmpl'=>$this->id])->all();

return $itemLines;

}

public function regularEarningsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->regular()->earnings();
    }
])->orderBy([
    'display_order' => SORT_ASC    
])->where(['tmpl'=>$this->id])->all();

return $itemLines;

}
public function deductionsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->deductions()->fixed();
    }
])->orderBy([
    'display_order' => SORT_ASC //specify sort order ASC for ascending DESC for descending      
])->where(['tmpl'=>$this->id])->all();

return $itemLines;

}

public function regularDeductionsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->regular()->deductions();
    }
])->orderBy([
    'display_order' => SORT_ASC //specify sort order ASC for ascending DESC for descending      
])->where(['tmpl'=>$this->id])->all();

return $itemLines;

}

public function supEarningsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->supplement()->earnings();
    }
])->orderBy([
    'display_order' => SORT_ASC    
])->where(['tmpl'=>$this->id,'calc_type'=>'fixed'])->all();

return $itemLines;

}
public function supDeductionsLines()
{
$itemLines= PayTemplateItems::find()->innerJoinWith([
    'payItem' => function($q) {
        $q->supplement()->deductions();
    }
])->orderBy([
    'display_order' => SORT_ASC    
])->where(['tmpl'=>$this->id,'calc_type'=>'fixed'])->all();

return $itemLines;

}

public function getBaseLineItem(){
    
 return $this
       ->hasOne(PayItems::className(), ['id' => 'item'])
       ->viaTable('pay_template_items', ['tmpl' => 'id'])->onCondition(['category'=>'BASE']);   
}
public function basePay()
{
$basePay= PayTemplateItems::find()->where(['category'=>'BASE'])->One();

return $basePay;

}

public function gross()
{
$gross= PayTemplateItems::find()->where(['category'=>'G'])->One();

return $gross;

}

    
    public function setPayItems($payItems){
       
     
         foreach($payItems  as $payLine){
       
                    $item = new PayTemplateItems();
                    $item->attributes=$payLine->attributes;
                    $item->isNewRecord=true;
                    $item->id=null;
                    $item->tmpl = $this->id;
                    $item->user=Yii::$app->user->identity->user_id;
                    $this->link('lineItems', $item);
       
   }
     return 1;
     
    }


}
