<?php

namespace thread\app\model\interfaces;

/**
 * interface Languages
 *
 * @package thread\app\model\iface
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
interface Languages
{
    /**
     * @param string $lang
     * @return string
     */
    public function isExistsByAlias(string $lang);

    /**
     * @return string
     */
    public function getDefault():array;

    /**
     * @param string|string $lang
     * @return string|string
     */
    public function getLangByAlias(string $lang):array;

    /**
     * @param string|string $lang
     * @return string|string
     */
    public function getLangByLocal(string $lang):array;

    /**
     * @return mixed
     */
    public function getAll():array;
}