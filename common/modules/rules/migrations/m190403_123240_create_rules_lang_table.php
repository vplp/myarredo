<?php

use yii\db\Migration;
use common\modules\rules\RulesModule;

/**
 * Handles the creation of table `{{%rules_lang}}`.
 */
class m190403_123240_create_rules_lang_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%rules}}';

    /**
     * @var string
     */
    public $tableLang = '{{%rules_lang}}';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->db = RulesModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLang, [
            'rid' => $this->integer(11)->unsigned()->notNull(),
            'lang' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->defaultValue(null),
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-rules_lang-rid-rules-id',
            $this->tableLang,
            'rid',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-rules_lang-rid-rules-id', $this->tableLang);

        $this->dropIndex('rid', $this->tableLang);

        $this->dropTable($this->tableLang);
    }
}
