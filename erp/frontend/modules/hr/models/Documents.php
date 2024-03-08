<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $name
 * @property string $details
 * @property string $created
 * @property string $updated
 *
 * @property EmpDocuments[] $empDocuments
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
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
            [['details'], 'string'],
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 100],
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
            'details' => 'Details',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpDocuments()
    {
        return $this->hasMany(EmpDocuments::className(), ['document' => 'id']);
    }
}
