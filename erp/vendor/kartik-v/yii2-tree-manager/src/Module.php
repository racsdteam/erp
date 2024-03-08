<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2019
 * @package   yii2-tree
 * @version   1.1.3
 */

namespace kartik\tree;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * The tree management module for Yii Framework 2.0.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class Module extends \kartik\base\Module
{
    /**
     * The module name for Krajee treeview
     */
    const MODULE = 'treemanager';
    /**
     * Manage node action
     */
     
    const NODE_MANAGE = 'manage';
    
     /**
     * Create node action
     */
    const NODE_CREATE = 'create';
     /**
     * View node action
     */
    const NODE_VIEW= 'view';
    /**
     * Remove node action
     */
    const NODE_REMOVE = 'remove';
    /**
     * Move node action
     */
    const NODE_MOVE = 'move';
    /**
     * Save node action
     */
    const NODE_SAVE = 'save';
    
     /**
     * Save node action
     */
    const NODE_UPDATE = 'update';
   
    /**
     * Tree details form view - Section Part 1
     */
    const VIEW_PART_1 = 1;
    /**
     * Tree details form view - Section Part 2
     */
    const VIEW_PART_2 = 2;
    /**
     * Tree details form view - Section Part 3
     */
    const VIEW_PART_3 = 3;
    /**
     * Tree details form view - Section Part 4
     */
    const VIEW_PART_4 = 4;
    /**
     * Tree details form view - Section Part 5
     */
    const VIEW_PART_5 = 5;

    /**
     * @var array the configuration of nested set attributes structure
     */
    public $treeStructure = [];

    /**
     * @var array the configuration of additional data attributes for the tree
     */
    public $dataStructure = [];

    /**
     * @var string the name to identify the nested set behavior name in the [[\kartik\tree\models\Tree]] model.
     */
    public $treeBehaviorName = 'tree';

    /**
     * @var array the default configuration settings for the tree view widget
     */
    public $treeViewSettings = [
        //'nodeView' => '@kvtree/views/_form',
        'nodeView'=>'@frontend/modules/racdms/views/tblfolders/view',
        'nodeAddlViews' => [
            self::VIEW_PART_1 => '',
            self::VIEW_PART_2 => '',
            self::VIEW_PART_3 => '',
            self::VIEW_PART_4 => '',
            self::VIEW_PART_5 => '',
        ]
    ];

    /**
     * @var array the list of asset bundles that would be unset when rendering the node detail form via ajax
     */
    public $unsetAjaxBundles = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset'
    ];

    /**
     * @var string a random salt that will be used to generate a hash signature for tree configuration.
     */
    public $treeEncryptSalt = 'SET_A_SALT_FOR_YII2_TREE_MANAGER';

    /**
     * @inheritdoc
     */
    public function init()
    {
        
        /**
     * @ prevents yii2 defaults assets conflicting tree assets(bootstrap 4)
     */
        
             \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
        'css' => []
    ];
    
     \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
        'js' => []
    ];
    
    
        $this->_msgCat = 'kvtree';
        parent::init();
        $this->treeStructure += [
            'treeAttribute' => 'root',
            'leftAttribute' => 'lft',
            'rightAttribute' => 'rgt',
            'depthAttribute' => 'lvl',
        ];
        $this->dataStructure += [
            'keyAttribute' => 'id',
            'nameAttribute' => 'name',
            'iconAttribute' => 'icon',
            'iconTypeAttribute' => 'icon_type'
        ];
        $nodeActions = ArrayHelper::getValue($this->treeViewSettings, 'nodeActions', []);
        $nodeActions += [
            //self::NODE_MANAGE => Url::to(['/treemanager/node/manage']),
            //self::NODE_SAVE => Url::to(['/treemanager/node/save']),
            //self::NODE_REMOVE => Url::to(['/treemanager/node/remove']),
            //self::NODE_MOVE => Url::to(['/treemanager/node/move']),

            self::NODE_MANAGE => Url::to(['/racdms/tblfolders/manage']),
            self::NODE_SAVE => Url::to(['/racdms/tblfolders/save']),
            self::NODE_REMOVE => Url::to(['/racdms/tblfolders/remove']),
            self::NODE_MOVE => Url::to(['/racdms/tblfolders/move']),
            self::NODE_CREATE => Url::to(['/racdms/tblfolders/create']),
            self::NODE_VIEW => Url::to(['/racdms/tblfolders/view']),
            self::NODE_UPDATE => Url::to(['/racdms/tblfolders/update'])
        ];
        $this->treeViewSettings['nodeActions'] = $nodeActions;
    }
}
