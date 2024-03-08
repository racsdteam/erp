<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "bid_documents_setting".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $procurement_categories_code
 * @property string $procurment_methode_code
 * @property string $description
 * @property int $is_madatory
 * @property int $user_id
 * @property string $timestamp
 */
class BidDocumentsSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bid_documents_setting';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'code', 'procurement_categories_code', 'procurment_methode_code', 'description', 'is_madatory', 'user_id'], 'required'],
            [['id', 'is_madatory', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 1000],
            [['code', 'procurement_categories_code', 'procurment_methode_code'], 'string', 'max' => 8],
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
            'procurement_categories_code' => 'Procurement Categories Code',
            'procurment_methode_code' => 'Procurment Methode Code',
            'description' => 'Description',
            'is_madatory' => 'Is Madatory',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
