<?php

namespace thread\app\model\interfaces;

/**
 * interface iLanguages
 *
 * @package thread\app\model\interfaces
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface LanguageModel
{
    /**
     * @return array
     */
    public function getLanguages(): array;

    /**
     * @return array
     */
    public function getCurrent(): array;
}
