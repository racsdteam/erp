<?php

namespace frontend\modules\assets0\models;

use Yii;

/**
 * This is the model class for table "asset_sec_details".
 *
 * @property int $id
 * @property int $asset
 * @property string $category
 * @property string $product
 * @property string $product_code
 * @property string $vendor
 * @property int $enabled
 * @property string $install_date
 * @property int $up_to_date
 * @property int $user
 * @property string $timestamp
 */
class AssetSecDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_sec_details';
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
            [['asset', 'category', 'product', 'product_code', 'vendor', 'user'], 'required','on'=>['create','update']],
            [['asset', 'enabled', 'up_to_date', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['category'], 'string', 'max' => 11],
            [['product', 'product_code', 'vendor'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset' => 'Asset',
            'category' => 'Category',
            'product' => 'Product',
            'product_code' => 'Product Code',
            'vendor' => 'Vendor',
            'enabled' => 'Enabled',
            'install_date' => 'Install Date',
            'up_to_date' => 'Up To Date',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
     public function getCategory0()
    {
        return $this->hasOne(AssetSecCategories::className(), ['code' => 'category']);
    }
    
}
