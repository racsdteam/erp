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
class DocumentsSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $required_status;
    public $more_docs_status;
    public $min_docs;
    public $max_docs;

    public static function tableName()
    {
        return 'documents_settings';
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
            [['name', 'code', 'section_code', 'user_id'], 'required'],
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
            'section_code' => 'Section Code',
            'procurement_categories_code' => 'Procurement Categories Code',
            'procurement_methods_code' => 'Procurement Methods Code',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
