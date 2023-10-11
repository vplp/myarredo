<?php

use yii\db\Migration;
use common\modules\rules\RulesModule;

/**
 * Handles the creation of table `{{%promotion_package_lang}}`.
 */
class m190924_123240_create_promotion_package_lang_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%promotion_package}}';

    /**
     * @var string
     */
    public $tableLang = '{{%promotion_package_lang}}';

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
            'description' => $this->string(1024)->defaultValue(null),
            'content' => $this->text()->defaultValue(null),
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-promotion_package_lang-rid-promotion_package-id',
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
        $this->dropForeignKey('fk-promotion_package_lang-rid-promotion_package-id', $this->tableLang);

        $this->dropIndex('rid', $this->tableLang);

        $this->dropTable($this->tableLang);
    }
}
