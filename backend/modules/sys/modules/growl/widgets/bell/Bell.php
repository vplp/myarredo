<?php

namespace backend\modules\sys\modules\growl\widgets\bell;

use Yii;
use yii\helpers\Url;
//
use thread\app\base\widgets\Widget;
//
use backend\modules\sys\modules\growl\models\search\Bell as BellModel;

/**
 * Class Bell
 *
 * @package backend\modules\sys\modules\growl\widgets\bell
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Bell extends Widget
{

    public $view = 'bell';
    public $limit = 3;
    protected $messageCounter = 0;
    protected $messages = [];
    protected $growlLink;

    public $translationsBasePath = __DIR__.'/messages';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->growlLink = Url::toRoute(['/sys/growl/growl/list']);
        $this->messageCounter = BellModel::getUnreadMessagesCount();
        if ($this->messageCounter > 0) {
            $this->messages = BellModel::getUnreadMessages($this->limit)??[];
        }

    }

    /**
     * @return string
     */
    public function run()
    {


        return $this->render($this->view, [
            'counter' => $this->messageCounter,
            'models' => $this->messages,
            'growlLink' => $this->growlLink,
        ]);
    }
}