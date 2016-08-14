<?php
namespace backend\widgets\LangSwitch;

use Yii;
//
use thread\app\model\Language;
use thread\app\base\widgets\Widget;

/**
 * Class LangSwitch
 * @package backend\widgets\LangSwitch
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class LangSwitch extends Widget
{

    /**
     * @var string
     */
    public $view = 'LangSwitch';
    /**
     * @var string
     */
    public $name = 'LangSwitch';

    /**
     * @var string
     */
    public $current = '';
    /**
     * @var null
     */
    protected $items = null;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $langModel = new Language;
        $this->items = $langModel->getLanguages();
        $this->current = $langModel->getCurrent()['label'];
    }

    /**
     * @return string
     */
    public function run()
    {
        $items = [];
        $request = Yii::$app->getRequest();
        $baseUrl = $request->getBaseUrl();
        $url = substr($request->getUrl(), strlen($baseUrl));

        foreach ($this->items as $lang) {
            if (!$lang['default']) {
                $items[] = ['label' => $lang['label'], 'url' => $baseUrl . '/' . $lang['alias'] . $url];
            } else {
                $items[] = ['label' => $lang['label'], 'url' => $baseUrl . $url];
            }
        }
        return $this->render($this->view, [
            'models' => $items,
            'current' => $this->current,
        ]);
    }
}
