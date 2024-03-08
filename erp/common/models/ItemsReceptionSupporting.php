<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items_reception_supporting".
 *
 * @property int $id
 * @property int $reception
 * @property string $doc
 * @property string $timestamp
 */
class ItemsReceptionSupporting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public $attach_files;
    public static function tableName()
    {
        return 'items_reception_supporting';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reception', 'doc'], 'required'],
            [['reception'], 'integer'],
            [['doc'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reception' => 'Reception',
            'doc' => 'Doc',
            'timestamp' => 'Timestamp',
        ];
    }
}
