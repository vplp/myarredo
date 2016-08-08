<?php

namespace thread\modules\configs\components;

use Yii;
use yii\base\Component;
//
use thread\modules\configs\models\Params;

class ConfigsParams extends Component
{
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
        $value = Params::find()->alias($alias)->one();
        return ($value !== null) ? $this->cache($value) : '';
    }

    /**
     * @param Params $value
     * @return mixed
     */
    protected function cache(Params $value)
    {
        $id = $value['id'];
        $v = $value['value'];

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