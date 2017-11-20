<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170718_160158_update_catalog_factory_lang_table
 */
class m170718_160158_update_catalog_factory_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%factory_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableLang, 'full_title');

        $this->renameColumn($this->tableLang, 'language_code', 'lang');

        $this->alterColumn($this->tableLang, 'lang', $this->string(5)->notNull()->comment('Language'));

        $this->renameColumn($this->tableLang, 'text', 'content');

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);

        $this->renameTable('factory_lang', 'catalog_factory_lang');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_factory_lang', 'factory_lang');

        $this->renameColumn($this->tableLang, 'content', 'text');

        $this->addColumn($this->tableLang, 'full_title', $this->string(255)->defaultValue(null)->after('title'));

        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
