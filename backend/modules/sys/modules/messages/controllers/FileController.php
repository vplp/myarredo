<?php
namespace backend\modules\sys\modules\messages\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url, FileHelper
};
//
use thread\app\base\controllers\BackendController;
use thread\modules\sys\modules\messages\helpers\{
    FileList, FillDataToBase
};
//
use backend\modules\sys\modules\messages\models\{
    MessagesFile, MessagesFileLang, search\MessagesFile as filterMessagesFileModel,
    Messages as mMessages
};

/**
 * Class FileController
 *
 * @package backend\modules\sys\modules\messages\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FileController extends BackendController
{
    public $model = MessagesFile::class;
    public $modelLang = MessagesFileLang::class;
    public $filterModel = filterMessagesFileModel::class;
    public $title = 'Messages';
    public $name = 'fileofmessages';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'crud'
            ],
        ]);
    }

    /**
     * @return mixed
     */
    public function actionFill()
    {
        $fl = new FileList();
        $fl->fillToBase();

        $fdb = new FillDataToBase();
        $fdb->fill();

        return $this->redirect(Url::toRoute(['list']));
    }

    /**
     * @return mixed
     */
    public function actionUpdatefiles()
    {

        $rootPath = Yii::getAlias('@root');
        $saveAppLanguage = Yii::$app->language;
        //
        $langs = Yii::$app->languages->getAll();
//        var_dump($langs);
        //
        $list = MessagesFile::find()->all();

        foreach ($list as $file) {
            foreach ($langs as $lang) {
                if ($lang['local'] !== $this->module->defaultLang) {
                    Yii::$app->language = $lang['local'];
                    $info = mMessages::find()->innerJoinWith(['lang'])->group_id($file['id'])->all();
                    if (count($info)) {
//                        echo $lang['local'] . count($info) . $file['messagefilepath'];

                        $targetfile = str_replace('/ru/', '/' . mb_substr($lang['local'], 0, 2) . '/', $file['messagefilepath']);
//                        echo $rootPath . $targetfile;

                        $toFile = '<?php return[' . PHP_EOL;

                        foreach ($info as $infoItem) {
                            $arrkey = str_replace('\'', '\\\'', $infoItem['arraykey']);
                            $arrvalue = str_replace('\'', '\\\'', $infoItem['lang']['title']);
                            //
                            $toFile .= "'{$arrkey}'=>''{$arrvalue}''," . PHP_EOL;
                        }
                        $toFile .= '];' . PHP_EOL;
                        FileHelper::createDirectory(dirname($rootPath . $targetfile));
                        file_put_contents($rootPath . $targetfile, $toFile);
                    }
                }
            }
        }
        Yii::$app->language = $saveAppLanguage;
        return $this->redirect(Url::toRoute(['list']));
    }
}
