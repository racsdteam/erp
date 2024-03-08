<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "job_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $code
 */
class CompJobRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comp_job_roles';
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
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
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
            'code' => 'Code',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CompJobRolesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompJobRolesQuery(get_called_class());
    }
}
