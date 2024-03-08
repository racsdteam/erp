<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "signature".
 *
 * @property int $id
 * @property int $user
 * @property string $signature
 * @property string $timestamp
 */
class Signature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $position;
    public $signature_uploaded_file;
    public static function tableName()
    {
        return 'signature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'signature'], 'required'],
            [['user','position'], 'integer'],
            [['signature'], 'string', 'max' => 256],
            [['signature_uploaded_file'], 'file', 'extensions'=>'jpg,png','skipOnEmpty'=>false],//validating input file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'signature' => 'Signature',
        ];
    }
}
