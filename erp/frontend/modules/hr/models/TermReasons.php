<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "term_reasons".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class TermReasons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'term_reasons';
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
            [['code'], 'string', 'max' => 11],
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
        ];
    }
     public static  function findByCode($code){
 $query=self::find()->where(['code'=>$code]);
 return $query->one();
 
 }
}
