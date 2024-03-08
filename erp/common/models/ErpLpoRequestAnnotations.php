<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_request_annotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $annotation
 * @property int $author
 * @property string $timestamp
 */
class ErpLpoRequestAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request_annotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc', 'annotation'], 'required'],
            [['doc', 'author'], 'integer'],
            [['annotation'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc' => 'Doc',
            'annotation' => 'Annotation',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
