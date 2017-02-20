<?php
namespace thread\app\base\controllers;

use Yii;
use yii\base\{
    Exception, Model
};
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\{
    Controller, Response
};
use thread\app\bootstrap\ActiveForm;
//
use thread\actions\{
    AttributeSwitch, CreateWithLang, ListModel, UpdateWithLang, Delete
};
use thread\app\base\models\ActiveRecord;
use thread\modules\user\models\User;

/**
 * Class BackendController
 * Uses for base configuration of backend. All backend controllers methods should extends this one.
 *
 * @package thread\app\base\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class BackendController extends Controller
{
    /**
     * Назва контролера
     * @var string
     */
    public $title = "Base";

    /**
     * Ключ контролера
     * @var string
     */
    public $name;

    /**
     * Базовий layout
     * @var string
     */
    public $layout = "@app/layouts/crud";

    /**
     * action 'list' link status
     * @var string
     */
    public $actionListLinkStatus = "list";

    /**
     * BackendController constructor.
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /**
     *
     */
    public function init()
    {

        if (empty($this->name)) {
            throw new Exception(Yii::t('app', 'attribute name must be set in Controller'));
        }

        /**
         * Set user interface language
         */
        if (!Yii::$app->getUser()->isGuest) {
            /** @var User $user */
            $user = Yii::$app->getUser()->getIdentity();
            Yii::$app->params['themes']['language'] = $user->profile->preferred_language;
        }
        return parent::init();
    }

    /**
     * Базові налаштування доступу до адміністративної частини
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Назва базового методу дії
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * Назва базової моделі
     * @var string
     */
    protected $model = '';

    /**
     * Назва базової моделі мови
     * @var string
     */
    protected $modelLang = '';

    /**
     * @var string|\Closure
     */
    protected $filterModel = '';

    /**
     * Перелік підключених Дій
     * @return array
     */
    public function actions()
    {
        return [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => '@app/layouts/list',
                'filterModel' => $this->filterModel,
            ],
            'trash' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => '@app/layouts/trash',
                'filterModel' => $this->filterModel,
                'methodName' => 'trash',
                'view' => 'trash'
            ],
            'create' => [
                'class' => CreateWithLang::class,
                'layout' => '@app/layouts/create',
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                        'update',
                        'id' => $this->action->getModel()->id
                    ];
                }
            ],
            'update' => [
                'class' => UpdateWithLang::class,
                'layout' => '@app/layouts/update',
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                        'update',
                        'id' => $this->action->getModel()->id
                    ];
                }
            ],
            'published' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'published',
                'redirect' => $this->defaultAction,
            ],
            'intrash' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'deleted',
                'redirect' => $this->defaultAction,
            ],
            'outtrash' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'deleted',
                'redirect' => $this->defaultAction,
            ],
            'delete' => [
                'class' => Delete::class,
                'modelClass' => $this->model,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->actionListLinkStatus = Yii::$app->getSession()->get($this->module->id . "_" . $this->id . "_list",
            'list');
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->action->id === 'list') {
            Yii::$app->getSession()->set($this->module->id . "_" . $this->id . "_list", Url::current());
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Перевірка валідації моделі(-ей)
     * Має бути встановдений у моделі scenario 'backend'
     * @return mixed
     */
    public function actionValidation()
    {
        $models = [];
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        /** @var Model $model */
        $model = ($id > 0) ? $this->findModel($id) : new $this->model;
        $model->setScenario('backend');
        $model->load(Yii::$app->getRequest()->post());
        $models[] = $model;

        /** @var Model $modelLang */
        $modelLang = (class_exists($this->modelLang)) ? ($id) ? $this->findModelLang($id) : new $this->modelLang : null;
        if ($modelLang !== null) {
            $modelLang = new $this->modelLang;
            $modelLang->setScenario('backend');
            $modelLang->load(Yii::$app->getRequest()->post());
            $modelLang->rid = $model->id;
            $modelLang->lang = Yii::$app->language;
            $models[] = $modelLang;
        }

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Пошук моделі по первинному ключу
     * Якщо модель не знайдена, повертається null
     * @param integer|array $id Ідентифікатор моделі
     * @return Model|null Повернення знайденої моделі
     */
    protected function findModel($id)
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->model;
        $keys = $modelClass::primaryKey();
        $model = null;
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }
        return $model;
    }

    /**
     * Пошук мовної моделі по первинному ключу
     * Якщо модель не знайдена, повертається null
     * @param integer $id Ідентифікатор моделі
     * @return Model Lang Повернення знайденої моделі
     */
    protected function findModelLang($id)
    {
        if (!(class_exists($this->modelLang))) {
            return null;
        }
        $model = null;
        /** @var ActiveRecord $m */
        $m = new $this->modelLang;
        if ($id) {
            $model = $m->find()->andWhere(['rid' => $id])->one();
        }
        if ($model === null) {
            $model = $m->loadDefaultValues();
        }
        return $model;
    }

    /**
     * Get the current page i18n title
     * @return string
     */
    public function getTitle()
    {
        return Yii::t($this->module->id, $this->title);
    }
}
