<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_105232_create_table_shop_payment_methods_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_105232_create_table_shop_payment_methods_lang extends Migration
{
    /**
     * @var string
     */
    public $tablePaymentMethods = '{{%shop_payment_methods}}';
    public $tablePaymentMethodsLang = '{{%shop_payment_methods_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePaymentMethodsLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),

        ]);
        $this->createIndex('rid', $this->tablePaymentMethodsLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-shop_payment_methods_lang-rid-shop_payment_methods-id',
            $this->tablePaymentMethodsLang,
            'rid',
            $this->tablePaymentMethods,
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
        $this->dropIndex('rid', $this->tablePaymentMethodsLang);
        $this->dropIndex('fk-shop_payment_methods_lang-rid-shop_payment_methods-id', $this->tablePaymentMethodsLang);
        $this->dropTable($this->tablePaymentMethodsLang);
    }
}
