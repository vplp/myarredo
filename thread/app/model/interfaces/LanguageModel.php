<?php

namespace thread\app\model\interfaces;

/**
 * interface iLanguages
 *
 * @package thread\app\model\iface
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

interface LanguageModel
{
    /**
     * @return mixed
     */
    public function getLanguages():array;
}