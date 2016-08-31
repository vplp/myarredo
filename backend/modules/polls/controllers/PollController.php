<?php
namespace backend\modules\polls\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\polls\models\{
    Poll, PollLang, search\Poll as filterPollModel
};

/**
 * Class PollController
 *
 * @package backend\modules\polls\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PollController extends BackendController
{
    public $model = Poll::class;
    public $modelLang = PollLang::class;
    public $filterModel = filterPollModel::class;
    public $title = 'Poll';
    public $name = 'poll';
}
