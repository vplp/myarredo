<?php

namespace thread\app\base\db\mysql;

/**
 * Trait MySqlExtraTypesTrait
 *
 * @package thread\app\base\i18n
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
trait ThreadMySqlExtraTypesTrait
{
    /**
     * @return mixed
     */
    protected abstract function getDb();

    /**
     * @param int $length
     * @return mixed
     */
    public function t_default_title($length = 255)
    {
        return $this->string($length)->defaultValue('')->comment('Default title');
    }

    /**
     * @return mixed
     */
    public function t_created_at()
    {
        return $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time');
    }

    /**
     * @return mixed
     */
    public function t_updated_at()
    {
        return $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time');
    }

    /**
     * @return mixed
     */
    public function t_rid()
    {
        return $this->integer()->unsigned()->notNull()->comment('Related model ID');
    }

    /**
     * @return mixed
     */
    public function t_lang()
    {
        return $this->string(5)->notNull()->comment('Language');
    }

    /**
     * @return mixed
     */
    public function t_position()
    {
        return $this->integer()->defaultValue(0)->unsigned()->notNull()->comment('position');
    }
}