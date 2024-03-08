<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "comp_business_names".
 *
 * @property int $id
 * @property string $table_name
 * @property string $name_name
 * @property string $name_class
 * @property string $reporting_name
 * @property string $code
 * @property int $active
 */
class CompBusinessEntities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comp_business_entities';
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
            [['name', 'reporting_name','class_name'], 'required'],
            [['active'], 'integer'],
            [['name','class_name'], 'string', 'max' => 255],
            [['reporting_name'], 'string', 'max' => 2555],
           
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
           
            'reporting_name' => 'Reporting Name',
            
            'active' => 'Active',
        ];
    }
}
