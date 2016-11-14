<?php

use yii\db\Migration;

/**
 * Class m160705_144111_init_table_currency
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_144111_init_table_currency extends Migration
{

    public $table = '{{%location_city}}';

    public function up()
    {
        $this->execute("
            INSERT INTO `fv_location_currency` (`id`, `alias`, `code1`, `code2`, `title`, `created_at`, `updated_at`, `published`, `deleted`, `course`, `currency_symbol`)
            VALUES
                (1,'rossiyskiy-rubl','810','RUB','Российский рубль',0,1466850227,'1','0',72.628,'&#8381;'),
                (2,'dollar-ssha','840','USD','Доллар США',0,1466850235,'1','0',1.108,'&#36;'),
                (3,'evro','978','EUR','Евро',0,1459351606,'1','0',1.000,'&#8364;'),
                (4,'grivna','980','UAH','Гривна',0,1466850257,'1','0',1.679,'&#8372;'),
                (5,'az-manat','031','AZN','',1461138991,1466663172,'1','0',1.735,'AZN');'1','0');
        ");

        $this->execute("

            INSERT INTO `fv_location_currency_lang` (`rid`, `lang`, `title`)
            VALUES
                (1,'en-EN','Russian ruble'),
                (1,'ru-RU','Российский рубль'),
                (2,'en-EN','U.S. dollar'),
                (2,'ru-RU','Доллар США'),
                (3,'en-EN','Euro'),
                (3,'ru-RU','Евро'),
                (4,'en-EN','Grivna'),
                (4,'ru-RU','Гривна'),
                (5,'en-EN','AZN'),
                (5,'ru-RU','Az. манат');
        ");

    }

    public function down()
    {
        $this->delete($this->table);
    }
}
