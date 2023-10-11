<?php

namespace thread\modules\sys\modules\growl\interfaces;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

interface Bell
{
    /**
     * @return mixed
     */
    public static function getUnreadMessagesCount();

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getUnreadMessages(int $limit);

    /**
     * @return mixed
     */
    public function getLink();

    /**
     * @return bool|string
     */
    public function getDateTime();
}