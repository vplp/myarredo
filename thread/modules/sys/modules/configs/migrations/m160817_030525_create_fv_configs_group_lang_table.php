<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160817_030525_create_fv_configs_group_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160817_030525_create_fv_configs_group_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tableConfigsGroup = '{{%configs_group}}';

    /**
     * @var string
     */
    public $tableConfigsGroupLang = '{{%configs_group_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ConfigsModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableConfigsGroupLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableConfigsGroupLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-configs_group_lang-rid-configs_group-id',
            $this->tableConfigsGroupLang,
            'rid',
            $this->tableConfigsGroup,
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
        $this->dropForeignKey('fk-configs_group_lang-rid-configs_group-id', $this->tableConfigsGroupLang);
        $this->dropIndex('rid', $this->tableConfigsGroupLang);
        $this->dropTable($this->tableConfigsGroupLang);
    }
}
