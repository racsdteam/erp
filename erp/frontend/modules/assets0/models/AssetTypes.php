<?php

namespace frontend\modules\assets0\models;

use Yii;

/**
 * This is the model class for table "asset_types".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class AssetTypes extends \yii\db\ActiveRecord
{
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_types';
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
            [['name', 'code','color'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code','color'], 'string', 'max' => 11],
           
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
    
public static function findByCode($code){
    
    return self::find()->where(['code'=>$code])->One();
}
}
