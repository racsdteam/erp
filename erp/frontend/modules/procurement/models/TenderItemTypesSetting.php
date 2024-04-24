<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "tender_item_types_setting".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $user_id
 * @property string $timestamp
 */
class TenderItemTypesSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_item_types_setting';
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
            [['name', 'code', 'description', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 256],
            [['code'], 'string', 'max' => 8],
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
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
