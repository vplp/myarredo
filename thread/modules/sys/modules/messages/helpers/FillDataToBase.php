<?php
namespace thread\modules\sys\modules\messages\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\{
    Component
};
//
use thread\modules\sys\modules\messages\models\{
    MessagesFile, Messages, MessagesLang
};

/**
 * Class FillDataToBase
 *
 * @package thread\modules\messages\helpers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FillDataToBase extends Component
{

    public $lang = '';
    protected $module = null;
    protected $rootPath = '';
    //
    protected $datafile = [];
    protected $database = [];
//    protected $file = '';
    protected $group_id = 0;

    /**
     *
     */
    public function init()
    {
        $this->module = Yii::$app->getModule('sys/messages');
        $this->lang = $this->module->defaultLang;
        $rootPath = Yii::getAlias('@root');
        $this->rootPath = $rootPath;
    }

    /**
     *
     */
    public function fill()
    {
        $list = MessagesFile::find()->all();
        foreach ($list as $item) {
            $this->getDataFromFile($item['messagefilepath'])->getDataFromBase($item['messagefilepath'])->fillData();
        }
    }

    /**
     * @param $messagefilepath
     */
    public function getDataFromFile($messagefilepath)
    {
        if (is_file($this->rootPath . $messagefilepath)) {
            $this->datafile = require_once($this->rootPath . $messagefilepath);
        }
        return $this;
    }

    /**
     * @param string $messagefilepath
     * @return $this
     */
    public function getDataFromBase(string $messagefilepath)
    {
        $mf = MessagesFile::findByFilePath($messagefilepath);
        if ($mf !== null) {
            $this->database = ArrayHelper::map(Messages::findAllByGroupId($mf['id']), 'arraykey', 'lang.title');
            $this->group_id = $mf['id'];
        }
        return $this;
    }

    /**
     *
     */
    public function fillData()
    {
        $dataToBase = array_diff_assoc($this->datafile, $this->database);
        $this->datafile = $this->database = [];
        foreach ($dataToBase as $key => $value) {
            $this->addDataCellToBase($key, $value);
        }
        return $this;
    }

    /**
     * @param $group_id
     * @param $key
     * @param $lang
     * @param $value
     */
    public function addDataCellToBase($key, $value)
    {
        if (Messages::findByArrayKey($key, $this->group_id) === null) {
            $md = new Messages([
                'group_id' => $this->group_id,
                'alias' => Messages::getKey($key),
                'arraykey' => $key,
                'on_default_lang' => $value,
            ]);
            if ($md->save(false)) {
                $mdl = new MessagesLang([
                    'rid' => $md['id'],
                    'lang' => $this->lang,
                    'title' => $value,
                ]);
                $mdl->save(false);
            }
        }
    }
}