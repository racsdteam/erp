<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "section_settings".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $procurement_categories_code
 * @property string $procurment_methode_code
 * @property int $user_id
 * @property string $timestamp
 */
class SectionSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section_settings';
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
            [['name', 'code', 'envelope_code', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 1000],
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
            'envelope_code' => 'Envelope Code',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
