<?php

namespace thread\modules\menu;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Menu
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends aModule
{
    public $name = 'menu';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @var array
     */
    public $internal_sources = [];
    public $internal_sources_list = [];
    public $permanent_link = [];


    /**
     * Db connection
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */

    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->setInternalSourse();
    }

    /**
     *
     */
    public function setInternalSourse()
    {
        if (!empty($this->internal_sources)) {
            foreach ($this->internal_sources as $key => $data) {
                foreach ($data as $data_key => $item) {
                    $set_key = $key . "_" . $data_key;
                    $this->internal_sources_list[$set_key] = $item;
                    $this->internal_sources_list[$set_key]['key'] = $set_key;
                }
            }
        }
    }

}
