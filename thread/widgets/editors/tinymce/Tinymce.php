<?php

namespace thread\widgets\editors\tinymce;

use thread\widgets\editors\tinymce\assets\{Asset, AssetLang};
use Yii;
use yii\helpers\{ArrayHelper, Html, Json, Url};
use yii\widgets\InputWidget;

/**
 * Class Tinymce
 *
 * @package admin\extensions\editors\tinymce
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Tinymce extends InputWidget
{

    /**
     * Налаштування редактору
     * @var array {@link http://www.tinymce.com/wiki.php/Configuration redactor options}.
     */
    public $settings = [];

    /**
     * Виклик налаштувань для редактору
     * @var string ''|full|mini
     */
    public $thema = '';

    /**
     * Мова інтерфейсу редатору
     * @var string
     */
    public $language;

    /**
     * Посилання на файл, що містить переводи інтерфейсу мови
     * @var string link
     */
    protected $language_url;

    /**
     * Налаштування редактору за замовчуванням
     * @var array
     */
    protected $_defaultSettings;

    /**
     *
     * @var string
     */
    public $content_css = "/editor.css";

    /**
     * @var \yii\helpers\Html textarea
     */
    private $_textarea;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        switch ($this->thema) {
            case 'mini' :
                $this->getMiniSetting();
                break;
            case 'full' :
                $this->getFullSetting();
                break;
            default :
                $this->getDefaultSetting();
                break;
        }

        //Додаємо поле для редактору та визначаємо ідентифікатор
        if (!isset($this->settings['selector'])) {
            $this->settings['selector'] = '#' . $this->options['id'];

            $this->_textarea = ($this->hasModel()) ?
                Html::activeTextarea($this->model, $this->attribute, $this->options) :
                Html::textarea($this->name, $this->value, $this->options);
        }
        /* Якщо [[options['selector']]] false видаляємо з налаштувань. */
        if (isset($this->settings['selector']) && $this->settings['selector'] === false) {
            unset($this->settings['selector']);
        }

        if (empty($this->language))
            $this->language = Yii::$app->language;

        $this->settings = ArrayHelper::merge($this->_defaultSettings, $this->settings);

        if (isset(Yii::$app->params['tinymce']['init_settings'])) {
            $this->settings = ArrayHelper::merge($this->settings, Yii::$app->params['tinymce']['init_settings']);
        }
        //Image Tools
        $this->settings['images_upload_handler'] = new \yii\web\JsExpression("function(blobInfo, success, failure){
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST','" . Url::toRoute(['/home/image-tools/index']) . "');
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            success(json.location);
        };
        formData = new FormData();
        formData.append('_csrf', '" . Yii::$app->getRequest()->getCsrfToken() . "');
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
        }
        ");
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->_textarea !== null) {
            $this->registerClientScript();
            echo $this->_textarea;
        }
    }

    /**
     * Регистрируем AssetBundle-ы виджета.
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
        //REGISTER TINYMCE
        $assetslang = AssetLang::register($view);
        if (is_file($assetslang->basePath . '/langs/' . $this->language . '.js')) {
            $this->language_url = $assetslang->baseUrl . '/langs/' . $this->language . '.js';
        } else {
            $this->language_url = $assetslang->baseUrl . '/langs/en-EN.js';
        }
        $this->settings['language_url'] = $this->language_url;
        $this->settings['content_css'] = $this->content_css;
        /**/
        //REGISTER TINYMCE filemanager
        $this->settings['external_filemanager_path'] = Url::base(true) . '/js2/filemanager/';
        $this->settings['external_plugins'] = [
            'filemanager' => Url::base(true) . '/js2/filemanager/plugin.min.js',
        ];
        $this->settings['filemanager_title'] = 'File Manager';

        Yii::$app->getSession()->set('TINYMCE_filemanager_ALLOW', true);
        $_SESSION['TINYMCE_filemanager_ALLOW'] = true;
        /**/

        $settings = Json::encode($this->settings);

        $view->registerJs("tinymce.init($settings);");
    }

    /**
     *
     */
    protected function getDefaultSetting()
    {
        $this->_defaultSettings = [
            'language' => $this->language,
            'language_url' => '',
            'relative_urls' => false,
            'height' => '200px',
            'menubar' => true,
            'statusbar' => false,
            //importcss
            'plugins' => ['contextmenu advlist autolink link image lists hr table media textcolor colorpicker'],
            'toolbar' => 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | fontsizeselect | bullist numlist | link unlink image media | hr table blockquote | pagebreak | removeformat | forecolor backcolor '
        ];
    }

    /**
     *
     */
    protected function getMiniSetting()
    {
        $this->_defaultSettings = [
            'language' => $this->language,
            'relative_urls' => false,
            'language_url' => '',
            'height' => '150px',
            'menubar' => false,
            'statusbar' => false,
            //importcss
            'plugins' => ['contextmenu'],
            'toolbar' => 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | hr table | removeformat '
        ];
    }

    /**
     *
     */
    protected function getFullSetting()
    {
        $this->_defaultSettings = [
            'language' => $this->language,
            'relative_urls' => false,
            'language_url' => '',
            'height' => '600px',
            'menubar' => true,
            'statusbar' => true,
            'plugins' => ['contextmenu advlist autolink link image lists hr table pagebreak code media textcolor colorpicker'],
            'toolbar' => 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | fontsizeselect | bullist numlist | link unlink image media | hr table blockquote | pagebreak code | removeformat  | forecolor backcolor '
        ];
    }

}
