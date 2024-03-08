<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "employee_docs_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class EmployeeDocsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_docs_categories';
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
            [['name', 'code', 'description', 'user_id'], 'required'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
