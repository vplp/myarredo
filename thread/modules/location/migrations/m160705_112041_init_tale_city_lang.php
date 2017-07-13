<?php

use yii\db\Migration;

/**
 * Class m160705_112041_init_tale_city_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_112041_init_tale_city_lang extends Migration
{
    public $table = '{{%location_city}}';

    public function up()
    {
        $this->execute("


        INSERT INTO `fv_location_city_lang` (`rid`, `lang`, `title`)
        VALUES
            (1,'en-EN','Karlovy Vary'),
            (1,'ru-RU','Карловы Вары'),
            (8,'en-EN','Podebrady'),
            (8,'ru-RU','Марианские Лазни'),
            (9,'en-EN','Jachymov'),
            (9,'ru-RU','Подебрады'),
            (10,'en-EN','Marianske Lazne'),
            (10,'ru-RU','Яхимов'),
            (13,'en-EN','Yessentuki'),
            (13,'ru-RU','Ессентуки'),
            (14,'en-EN','Kislovodsk'),
            (14,'ru-RU','Кисловодск'),
            (15,'en-EN','Zheleznovodsk'),
            (15,'ru-RU','Железноводск'),
            (16,'en-EN','Pyatigorsk'),
            (16,'ru-RU','Пятигорск'),
            (20,'en-EN','Riga'),
            (20,'ru-RU','Рига'),
            (21,'en-EN','Jurmala'),
            (21,'ru-RU','Юрмала'),
            (22,'en-EN','Velingrad'),
            (22,'ru-RU','Велинград'),
            (23,'en-EN','Rogaška Slatina'),
            (23,'ru-RU','Рогашка Слатина'),
            (24,'en-EN','Truskavets'),
            (24,'ru-RU','Трускавец'),
            (25,'en-EN','Heviz'),
            (25,'ru-RU','Хевиз'),
            (26,'en-EN','Piestany'),
            (26,'ru-RU','Пиештяны'),
            (27,'en-EN','Bardejovske Kupele'),
            (27,'ru-RU','Бардеевские купели'),
            (28,'en-EN','Rajecke Teplice'),
            (28,'ru-RU','Райецке Теплице'),
            (29,'en-EN','Abano Terme'),
            (29,'ru-RU','Абано-Терме'),
            (30,'en-EN','Druskininkai'),
            (30,'ru-RU','Друскининкай'),
            (31,'en-EN','Bratislava'),
            (31,'ru-RU','Братислава '),
            (32,'en-EN','Stavropol'),
            (32,'ru-RU','Ставрополь'),
            (33,'en-EN','Bardeev'),
            (33,'ru-RU','Бардеев'),
            (34,'en-EN','Teplice'),
            (34,'ru-RU','Теплице'),
            (35,'en-EN','Frantiskovy Lazne'),
            (35,'ru-RU','Франтишковы Лазни'),
            (36,'en-EN','Konstantinovy Lazne'),
            (36,'ru-RU','Константиновы Лазни'),
            (37,'en-EN','Luhacovice'),
            (37,'ru-RU','Лугачовице'),
            (38,'en-EN','Budapest'),
            (38,'ru-RU','Будапешт'),
            (39,'en-EN','Palanga'),
            (39,'ru-RU','Паланга'),
            (40,'en-EN','Hajdúszoboszló'),
            (40,'ru-RU','Хайдусобосло'),
            (41,'en-EN','Smrdaky'),
            (41,'ru-RU','Смрдаки'),
            (42,'en-EN','Nakhchivan'),
            (42,'ru-RU','Нахичевань'),
            (43,'en-EN','Naftalan'),
            (43,'ru-RU','Нафталан'),
            (44,'en-EN','Melbourne'),
            (44,'ru-RU','Мельбурн');

        ");

    }

    public function down()
    {
        $this->delete($this->table);
    }
}
