<?php
    namespace common\models;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\base\Model;
    use common\models\User;
     
    /**
     * Change password form for current user only
     */
    class ApprovalFlowStartForm extends Model
    {
        public $wfModel;
        public $comment;
        public $entityRecord;
        public $entityType;
        public $initiator;
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
               
                [['wfModel','entityRecord','initiator'], 'integer'],
                [['comment','entityType'], 'string'],
               
            ];
        }
       public function attributeLabels()
    {
        return [
            'wfModel' => 'Workflow Model',
            'comment' => 'Comment',
            'entityRecord' => 'Entity Record',
           
            
        ];
    }
        
    }