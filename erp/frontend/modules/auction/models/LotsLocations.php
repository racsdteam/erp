<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "Lots_locations".
 *
 * @property int $id
 * @property string $location
 * @property string $loc_code
 */
class LotsLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lots_locations';
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
            [['location', 'loc_code'], 'required'],
            [['location', 'loc_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location' => 'Location',
            'loc_code' => 'Loc Code',
        ];
    }
}
