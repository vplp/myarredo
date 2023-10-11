<?php

namespace common\modules\sys\modules\configs\components;

use yii\base\Component;
//
use common\modules\sys\modules\configs\models\Params;

/**
 * Class ConfigsParams
 *
 * @package common\modules\sys\modules\configs\components
 */
class ConfigsParams extends Component
{
    /**
     * @var array
     */
    protected $cach = [];

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $value = Params::find()->byID($id)->one();
        return ($value !== null) ? $this->cache($value) : '';
    }

    /**
     * @param $alias
     * @return string
     */
    public function getByName($alias)
    {
        $value = Params::find()->byAlias($alias)->one();
        return ($value !== null) ? $this->cache($value) : '';
    }

    /**
     * @param Params $value
     * @return mixed
     */
    protected function cache(Params $value)
    {
        $id = $value['id'];
        $v = $value['lang']['content'] ?? '';

        if (isset($this->cach[$id])) {
            if ($this->cach[$id] != $v) {
                $this->cach[$id] = $v;
            }
        } else {
            $this->cach[$id] = $v;
        }

        return $this->cach[$id];
    }

}
