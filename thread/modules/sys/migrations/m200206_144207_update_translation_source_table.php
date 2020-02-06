<?php

use yii\db\Migration;

/**
 * Class m200206_144207_update_translation_source_table
 */
class m200206_144207_update_translation_source_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%translation_source}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropIndex('translation_key', $this->table);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->createIndex('translation_key', $this->table, 'key');
    }
}
