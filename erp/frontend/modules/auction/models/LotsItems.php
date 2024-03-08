<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "lots_item_names".
 *
 * @property int $id
 * @property string $item_name
 * @property int $lot
 * @property int $user
 * @property string $timestamp
 */
class LotsItems extends \yii\db\ActiveRecord
{
    
       public $item_images;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lots_items';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db5');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'lot', 'user'], 'required'],
            [['lot', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['item_name','item_image'], 'string', 'max' => 255],
             [['item_images'], 'file', 'extensions'=>'jpg,png','skipOnEmpty'=>true],//validating input file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_name' => 'Item Name',
            'lot' => 'Lot',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
