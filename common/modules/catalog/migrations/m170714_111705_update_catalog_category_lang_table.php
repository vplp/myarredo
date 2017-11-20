<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170714_111705_update_catalog_category_lang_table
 */
class m170714_111705_update_catalog_category_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%catalog_group_lang}}';

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

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->tableLang, 'full_title', $this->string(255)->defaultValue(null)->after('title'));

        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
