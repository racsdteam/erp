<?php

namespace frontend\modules\racdms\models;

use Yii;

/**
 * This is the model class for table "tblorgpositions".
 *
 * @property int $id
 * @property string $name
 * @property int $org
 */
class Tblorgpositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblorgpositions';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'name', 'org','user'], 'required'],
            [['org','user'], 'integer'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'org' => 'Organisation',
        ];
    }
     
     
     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                
                $this->user=Yii::$app->user->identity->user_id;
               
            }
            return true;
        } else {
            return false;
        }
    }
}
