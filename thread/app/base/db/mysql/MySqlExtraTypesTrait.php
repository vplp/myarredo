<?php

namespace thread\app\base\db\mysql;

/**
 * Trait MySqlExtraTypesTrait
 *
 * @package thread\app\base\i18n
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
trait MySqlExtraTypesTrait
{
    /**
     * @return mixed
     */
    protected abstract function getDb();

    /**
     * @return mixed
     */
    public function mediumText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext');
    }

    /**
     * @return mixed
     */
    public function longText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext');
    }

    /**
     * @return mixed
     */
    public function tinyText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('tinytext');
    }

    /**
     * @param array $values
     * @return mixed
     */
    public function enum(array $values, $defaultValue)
    {
        $values = \array_map(function ($value) {
            return "'" . (string)$value . "'";
        }, $values);
        $values = \implode(',', $values);
        $defaultValue = (string)$defaultValue;
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('enum(' . $values . ')')
            ->notNull()->defaultValue($defaultValue);
    }
}