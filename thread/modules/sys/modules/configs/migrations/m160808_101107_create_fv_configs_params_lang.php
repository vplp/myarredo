<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160808_101107_create_fv_configs_params_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160808_101107_create_fv_configs_params_lang extends Migration
{
    /**
     * @var string
     */
    public $tableConfigsParams = '{{%configs_params}}';

    /**
     * @var string
     */
    public $tableConfigsParamsLang = '{{%configs_params_lang}}';

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
        $this->createTable($this->tableConfigsParamsLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableConfigsParamsLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-configs_params_lang-rid-configs-params-id',
            $this->tableConfigsParamsLang,
            'rid',
            $this->tableConfigsParams,
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
        $this->dropForeignKey('fk-configs_params_lang-rid-configs-params-id', $this->tableConfigsParamsLang);
        $this->dropIndex('rid', $this->tableConfigsParamsLang);
        $this->dropTable($this->tableConfigsParamsLang);
    }
}
