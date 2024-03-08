<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class Fontawesome5Asset extends AssetBundle
{

    /**
     * @inherit
     */
    public $sourcePath = '@vendor/bower/fontawesome-5.15.4';

    /**
     * @inherit
     */
    public $css = [
     
        'css/all.css'
    ];

    /**
     * Initializes the bundle.
     * Set publish options to copy only necessary files (in this case css and font folders)
     * @codeCoverageIgnore
     */
    public function init()
    {
        parent::init();

        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            return preg_match('%(/|\\\\)(webfonts|css)%', $from);
        };
    }
}