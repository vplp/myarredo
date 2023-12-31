<?php

use yii\db\Migration;

/**
 * Class m160705_110432_init_tale_country
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_110432_init_tale_country extends Migration
{

    public $tablePage = '{{%location_country}}';


    public function up()
    {
        $this->execute("

        INSERT INTO `fv_location_country` (`id`, `alias`, `title`, `alpha2`, `alpha3`, `iso`, `created_at`, `updated_at`, `published`, `deleted`)
        VALUES
            (4,'australia','Австралия','AU','AUS',36,0,1464278369,'1','0'),
            (63,'austria','Австрия','AT','AUT',40,0,1464273929,'1','0'),
            (81,'azerbaijan','Азербайджан','AZ','AZE',31,0,1464273948,'1','0'),
            (173,'anguilla','Ангилья','AI','AIA',660,0,1464278369,'1','0'),
            (177,'argentina','Аргентина','AR','ARG',32,0,1464278369,'1','0'),
            (245,'armenia','Армения','AM','ARM',51,0,1464274009,'1','0'),
            (248,'belarus','Беларусь','BY','BLR',112,0,1464274030,'1','0'),
            (401,'belize','Белиз','BZ','BLZ',84,0,1464274057,'1','0'),
            (404,'belgium','Бельгия','BE','BEL',56,0,1464274081,'1','0'),
            (425,'bermuda','Бермуды','BM','BMU',60,0,1464274105,'1','0'),
            (428,'bulgaria','Болгария','BG','BGR',100,0,1464278369,'1','0'),
            (467,'brazil','Бразилия','BR','BRA',76,0,1464274219,'1','0'),
            (616,'united','Великобритания','GB','GBR',826,0,1464278369,'1','0'),
            (924,'hungary','Венгрия','HU','HUN',348,0,1464274408,'1','0'),
            (971,'viet','Вьетнам','VN','VNM',704,0,1464278369,'1','0'),
            (994,'haiti','Гаити','HT','HTI',332,0,1464278369,'1','0'),
            (1007,'guadeloupe','Гваделупа','GP','GLP',312,0,1464278369,'1','0'),
            (1012,'germany','Германия','DE','DEU',276,0,1464274524,'1','0'),
            (1206,'netherlands','Голландия','NL','NLD',528,0,1464274603,'1','0'),
            (1258,'greece','Греция','GR','GRC',300,0,1464274637,'1','0'),
            (1280,'georgia','Грузия','GE','GEO',268,0,1464274718,'1','0'),
            (1366,'denmark','Дания','DK','DNK',208,0,1464274754,'1','0'),
            (1380,'egypt','Египет','EG','EGY',818,0,1464274981,'1','0'),
            (1393,'israel','Израиль','IL','ISR',376,0,1464278370,'1','0'),
            (1451,'india','Индия','IN','IND',356,0,1464278370,'1','0'),
            (1663,'iran','Иран','IR','IRs',364,0,1463059178,'1','0'),
            (1696,'ireland','Ирландия','IE','IRL',372,0,1464278370,'1','0'),
            (1707,'spain','Испания','ES','ESP',724,0,1464274475,'1','0'),
            (1786,'italy','Италия','IT','ITA',380,0,1464278370,'1','0'),
            (1894,'kazakhstan','Казахстан','KZ','KAZ',398,0,1464274890,'1','0'),
            (2163,'cameroon','Камерун','CM','CMR',120,0,1464276202,'1','0'),
            (2172,'canada','Канада','CA','CAN',124,0,1464274916,'1','0'),
            (2297,'cyprus','Кипр','CY','CYP',196,0,1464275211,'1','0'),
            (2303,'kyrgyzstan','Кыргызстан','KG','KGZ',417,0,1464276276,'1','0'),
            (2374,'china','Китай','CN','CHN',156,0,1464275276,'1','0'),
            (2430,'kosta-rika','Коста-Рика','CR','CRI',188,0,1463062147,'1','0'),
            (2443,'kuwait','Кувейт','KW','KWT',414,0,1464278369,'1','0'),
            (2448,'latvia','Латвия','LV','LVA',428,0,1464275977,'1','0'),
            (2509,'libya','Ливия','LY','LBY',434,0,1464276004,'1','0'),
            (2514,'lithuania','Литва','LT','LTU',440,0,1464276034,'1','0'),
            (2614,'luxembourg','Люксембург','LU','LUX',442,0,1464276154,'1','0'),
            (2617,'mexico','Мексика','MX','MEX',484,0,1464276173,'1','0'),
            (2788,'moldova','Молдова','MD','MDA',498,0,1463059453,'1','0'),
            (2833,'monaco','Монако','MC','MCO',492,0,1464276122,'1','0'),
            (2837,'novaya-zelandiya','Новая Зеландия','NZ','NZL',554,0,1463059503,'1','0'),
            (2880,'norway','Норвегия','NO','NOR',578,0,1464276095,'1','0'),
            (2897,'poland','Польша','PL','POL',616,0,1464275182,'1','0'),
            (3141,'portugal','Португалия','PT','PRT',620,0,1464276067,'1','0'),
            (3156,'reunion','Реюньон','RE','REU',638,0,1464276303,'1','0'),
            (3159,'russia','Россия','RU','RUS',643,0,1464275140,'1','0'),
            (5647,'saljvador','Сальвадор','SV','SLV',222,0,1461754959,'1','0'),
            (5666,'slovakia','Словакия','SK','SVK',703,0,1464278370,'1','0'),
            (5673,'slovenia','Словения','SI','SVN',705,0,1464278370,'1','0'),
            (5678,'surinam','Суринам','SR','SUR',740,0,1461756646,'1','0'),
            (5681,'usa','США','US','USA',0,0,1464278370,'1','0'),
            (9575,'tadjikistan','Таджикистан','TJ','TJK',762,0,1461756702,'1','0'),
            (9638,'turkmenistan','Туркменистан','TM','TKM',795,0,1464278370,'1','0'),
            (9701,'turks-i-keykos','Туркс и Кейкос','','',0,0,1461758093,'1','0'),
            (9705,'turkey','Турция','TR','TUR',792,0,1464278370,'1','0'),
            (9782,'uganda','Уганда','UG','UGA',800,0,1464278370,'1','0'),
            (9787,'uzbekistan','Узбекистан','UZ','UZB',860,0,1464278370,'1','0'),
            (9908,'ukraine','Украина','UA','UKR',804,0,1464278370,'1','0'),
            (10648,'finland','Финляндия','FI','FIN',246,0,1464278370,'1','0'),
            (10668,'france','Франция','FR','FRA',250,0,1464278370,'1','0'),
            (10874,'czech','Чехия','CZ','CZE',203,0,1464338779,'1','0'),
            (10904,'switzerland','Швейцария','CH','CHE',756,0,1464278370,'1','0'),
            (10933,'sweden','Швеция','SE','SWE',752,0,1464278370,'1','0'),
            (10968,'estonia','Эстония','EE','EST',233,0,1464278370,'1','0'),
            (11002,'yugoslaviya','Югославия','','',0,0,1461759244,'1','0'),
            (11014,'yujnaya-koreya','Южная Корея','KR','KOR',410,0,1461759515,'1','0'),
            (11060,'yaponiya','Япония','JP','JPN',392,0,1461759560,'1','0'),
            (277551,'niderlandi','Нидерланды','NL','NLD',528,0,1461753747,'1','0'),
            (277553,'croatia','Хорватия','HR','HRV',191,0,1464278370,'1','0'),
            (277555,'ruminiya','Румыния','RO','ROU',642,0,1461754928,'1','0'),
            (277557,'hong','Гонконг','HK','HKG',344,0,1464278369,'1','0'),
            (277559,'indonesia','Индонезия','ID','IDN',360,0,1464278370,'1','0'),
            (277561,'jordan','Иордания','JO','JOR',400,0,1464278370,'1','0'),
            (277563,'malaysia','Малайзия','MY','MYS',458,0,1464278369,'1','0'),
            (277565,'singapore','Сингапур','SG','SGP',702,0,1464278370,'1','0'),
            (277567,'tayvanj','Тайвань','TW','TWN',158,0,1461757714,'1','0'),
            (277569,'turkmeniya','Туркмения','TM','TKM',795,0,1461758059,'1','0'),
            (582029,'karibi','Карибы','','',0,0,1463061440,'1','0'),
            (582031,'chile','Чили','CL','CHL',152,0,1464278370,'1','0'),
            (582040,'koreya','Корея','KR','KOR',410,0,1463062125,'1','0'),
            (582041,'makedoniya','Македония','MK','MKD',807,0,1463062328,'1','0'),
            (582043,'malta','Мальта','MT','MLT',470,0,1464278369,'1','0'),
            (582044,'pakistan','Пакистан','PK','PAK',586,0,1464278369,'1','0'),
            (582046,'peru','Перу','PE','PER',604,0,1464278369,'1','0'),
            (582050,'tayland','Тайланд','TH','THA',764,0,1461757775,'1','0'),
            (582051,'oae','О.А.Э.','AE','ARE',784,0,1461754210,'1','0'),
            (582060,'lebanon','Ливан','LB','LBN',422,0,1464278369,'1','0'),
            (582064,'ecuador','Эквадор','EC','ECU',218,0,1464278370,'1','0'),
            (582065,'morocco','Марокко','MA','MAR',504,0,1464278369,'1','0'),
            (582067,'siriya','Сирия','SY','SYR',760,0,1461756204,'1','0'),
            (582077,'cuba','Куба','CU','CUB',192,0,1464278369,'1','0'),
            (582082,'mozambique','Мозамбик','MZ','MOZ',508,0,1464278369,'1','0'),
            (582090,'tunisia','Тунис','TN','TUN',788,0,1464278370,'1','0'),
            (582105,'ostrov-men','Остров Мэн','','',0,0,1461754353,'1','0'),
            (582106,'yamayka','Ямайка','JM','JAM',388,0,1461759537,'1','0'),
            (2567393,'honduras','Гондурас','HN','HND',340,0,1464278369,'1','0'),
            (2577958,'dominikanskaya-respublika','Доминиканская республика','DO','DOM',214,0,1463061209,'1','0'),
            (2687701,'mongolia','Монголия','MN','MNG',496,0,1464278369,'1','0'),
            (3410238,'iraq','Ирак','IQ','IRQ',368,0,1464278370,'1','0'),
            (3661568,'yuar','ЮАР','ZA','ZAF',710,0,1461759202,'1','0'),
            (7716093,'aruljko','Арулько','','',0,0,1461744452,'1','0'),
            (7716094,'afghanistan','Афганистан','','',0,0,1464278369,'1','0'),
            (7716095,'albania','Албания','','',0,0,1464278369,'1','0'),
            (7716096,'algeria','Алжир','','',0,0,1464278369,'1','0'),
            (7716097,'andorra','Андорра','','',0,0,1464278369,'1','0'),
            (7716098,'kiribati','Кирибати','','',0,0,1463062008,'1','0'),
            (7716099,'kokosovie-kiling-ostrova','Кокосовые (Килинг) острова','','',0,0,1463062037,'1','0'),
            (7716100,'nauru','Науру','','',0,0,1461753583,'1','0'),
            (7716101,'norfolk-ostrov','Норфолк, остров','','',0,0,1461754127,'1','0'),
            (7716102,'ostrov-rojdestva','Остров Рождества','','',0,0,1461754564,'1','0'),
            (7716103,'tuvalu','Тувалу','','',0,0,1461758004,'1','0'),
            (7716104,'herd-i-makdonaljd-ostrova','Херд и Макдональд, острова','','',0,0,1461758418,'1','0'),
            (7716105,'bagamskie-ostrova','Багамские острова','','',0,0,1461744514,'1','0'),
            (7716106,'bahrain','Бахрейн','','',0,0,1464278369,'1','0'),
            (7716107,'bangladesh','Бангладеш','','',0,0,1464278369,'1','0'),
            (7716108,'barbados','Барбадос','','',0,0,1464278369,'1','0'),
            (7716109,'bermudskie-ostrova','Бермудские острова','','',0,0,1461744867,'1','0'),
            (7716110,'bhutan','Бутан','','',0,0,1464278369,'1','0'),
            (7716111,'bolivia','Боливия','','',0,0,1464278369,'1','0'),
            (7716112,'botswana','Ботсвана','','',0,0,1464278369,'1','0'),
            (7716113,'solomonovi-ostrova','Соломоновы острова','','',0,0,1461756487,'1','0'),
            (7716114,'bruney-darussalam','Бруней Даруссалам','','',0,0,1461745144,'1','0'),
            (7716115,'mjyanma','Мьянма','','',0,0,1461753162,'1','0'),
            (7716116,'burundi','Бурунди','','',0,0,1464278369,'1','0'),
            (7716117,'cambodia','Камбоджа','','',0,0,1464278370,'1','0'),
            (7716118,'kabo-verde','Кабо-Верде','','',0,0,1463061388,'1','0'),
            (7716119,'kaymanovi-ostrova','Каймановы острова','','',0,0,1463061408,'1','0'),
            (7716120,'shri-lanka','Шри-Ланка','','',0,0,1461759002,'1','0'),
            (7716121,'colombia','Колумбия','','',0,0,1464278370,'1','0'),
            (7716122,'komorskie-ostrova','Коморские острова','','',0,0,1463062074,'1','0'),
            (7716124,'greenland','Гренландия','','',0,0,1464278370,'1','0'),
            (7716125,'farerskie-ostrova','Фарерские острова','','',0,0,1461758235,'1','0'),
            (7716126,'efiopiya','Эфиопия','','',0,0,1461759174,'1','0'),
            (7716127,'eritrea','Эритрея','','',0,0,1464278370,'1','0'),
            (7716128,'folklendskie-maljvinskie-ostrova','Фолклендские (Мальвинские) острова','','',0,0,1461758321,'1','0'),
            (7716129,'fiji','Фиджи','','',0,0,1464278370,'1','0'),
            (7716130,'djibuti','Джибути','','',0,0,1463061188,'1','0'),
            (7716131,'gambia','Гамбия','','',0,0,1464278369,'1','0'),
            (7716132,'ghana','Гана','','',0,0,1464278369,'1','0'),
            (7716133,'gibraltar','Гибралтар','','',0,0,1463059935,'1','0'),
            (7716134,'guatemala','Гватемала','','',0,0,1464278369,'1','0'),
            (7716135,'guinea','Гвинея','','',0,0,1464278369,'1','0'),
            (7716136,'gayana','Гайана','','',0,0,1461747043,'1','0'),
            (7716137,'iceland','Исландия','','',0,0,1464278370,'1','0'),
            (7716139,'vostochniy-timor','Восточный Тимор','','',0,0,1461745590,'1','0'),
            (7716140,'iran-islamskaya-respublika','Иран (Исламская Республика)','','',0,0,1463061326,'1','0'),
            (7716141,'kenya','Кения','','',0,0,1464278370,'1','0'),
            (7716142,'koreya-demokraticheskaya-narodnaya-respublika','Корея, демократическая народная республика','','',0,0,1463062137,'1','0'),
            (7716143,'koreya-respublika','Корея, республика','','',0,0,1461749515,'1','0'),
            (7716144,'kirgiziya','Киргизия','','',0,0,1463061996,'1','0'),
            (7716145,'laos-narodnaya-demokraticheskaya-respublika','Лаос, народная демократическая республика','','',0,0,1463062179,'1','0'),
            (7716146,'lesoto','Лесото','','',0,0,1463062198,'1','0'),
            (7716147,'liberia','Либерия','','',0,0,1464278369,'1','0'),
            (7716148,'liviyskaya-arabskaya-djamahiriya','Ливийская Арабская Джамахирия','','',0,0,1463062228,'1','0'),
            (7716149,'makao','Макао','','',0,0,1463062311,'1','0'),
            (7716150,'madagascar','Мадагаскар','','',0,0,1464278369,'1','0'),
            (7716151,'malawi','Малави','','',0,0,1464278369,'1','0'),
            (7716152,'maldives','Мальдивы','','',0,0,1464278369,'1','0'),
            (7716153,'mauritania','Мавритания','','',0,0,1464278369,'1','0'),
            (7716154,'mauritius','Маврикий','','',0,0,1464278369,'1','0'),
            (7716155,'zapadnaya-sahara','Западная Сахара','','',0,0,1463061238,'1','0'),
            (7716156,'oman','Оман','','',0,0,1461754273,'1','0'),
            (7716157,'namibia','Намибия','','',0,0,1464278369,'1','0'),
            (7716158,'nepal','Непал','','',0,0,1461753614,'1','0'),
            (7716159,'niderlandskie-antiljskie-ostrova','Нидерландские Антильские острова','','',0,0,1461753728,'1','0'),
            (7716160,'aruba','Аруба','','',0,0,1464278369,'1','0'),
            (7716161,'vanuatu','Вануату','','',0,0,1461745296,'1','0'),
            (7716162,'niue','Ниуэ','','',0,0,1461754019,'1','0'),
            (7716163,'ostrova-kuka','Острова Кука','','',0,0,1461754629,'1','0'),
            (7716164,'pitkern','Питкерн','','',0,0,1461754814,'1','0'),
            (7716165,'tokelau','Токелау','','',0,0,1461757941,'1','0'),
            (7716166,'nikaragua','Никарагуа','','',0,0,1461753765,'1','0'),
            (7716167,'nigeria','Нигерия','','',0,0,1464278369,'1','0'),
            (7716168,'buve-ostrov','Буве, остров','','',0,0,1461745181,'1','0'),
            (7716169,'svaljbard-i-yan-mayen-ostrova','Свальбард и Ян Майен, острова','','',0,0,1461755171,'1','0'),
            (7716170,'panama','Панама','','',0,0,1464278369,'1','0'),
            (7716171,'papua-novaya-gvineya','Папуа-Новая Гвинея','','',0,0,1461754751,'1','0'),
            (7716172,'paraguay','Парагвай','','',0,0,1464278369,'1','0'),
            (7716173,'philippines','Филиппины','','',0,0,1464278370,'1','0'),
            (7716174,'gvineya-bisau','Гвинея-Бисау','','',0,0,1463059614,'1','0'),
            (7716176,'qatar','Катар','','',0,0,1464278370,'1','0'),
            (7716177,'ruanda','Руанда','','',0,0,1461754902,'1','0'),
            (7716178,'ostrov-svyatoy-eleni','Остров Святой Елены','','',0,0,1461754606,'1','0'),
            (7716179,'san-tome-i-prinsipi','Сан-Томе и Принсипи','','',0,0,1461755071,'1','0'),
            (7716180,'saudovskaya-araviya','Саудовская Аравия','','',0,0,1461755089,'1','0'),
            (7716181,'seysheljskie-ostrova','Сейшельские Острова','','',0,0,1461755498,'1','0'),
            (7716182,'sjerra-leone','Сьерра-Леоне','','',0,0,1461756685,'1','0'),
            (7716183,'somalia','Сомали','','',0,0,1464278370,'1','0'),
            (7716186,'yujnaya-afrika','Южная Африка','','',0,0,1461759308,'1','0'),
            (7716187,'zimbabwe','Зимбабве','','',0,0,1464278370,'1','0'),
            (7716188,'sudan','Судан','','',0,0,1464278370,'1','0'),
            (7716189,'svazilend','Свазиленд','','',0,0,1461755126,'1','0'),
            (7716190,'liechtenstein','Лихтенштейн','','',0,0,1464278369,'1','0'),
            (7716191,'siriyskaya-arabskaya-respublika','Сирийская Арабская Республика','','',0,0,1461756179,'1','0'),
            (7716192,'thailand','Таиланд','','',0,0,1464278370,'1','0'),
            (7716193,'tonga','Тонга','','',0,0,1461757965,'1','0'),
            (7716194,'trinidad-i-tobago','Тринидад и Тобаго','','',0,0,1461757987,'1','0'),
            (7716195,'obyedinennie-arabskie-emirati-oae','Объединенные Арабские Эмираты (ОАЭ)','','',0,0,1461754228,'1','0'),
            (7716196,'soedinennoe-korolevstvo-velikobritaniya','Соединенное королевство (Великобритания)','','',0,0,1461756452,'1','0'),
            (7716197,'tanzaniya-edinaya-respublika','Танзания, единая республика','','',0,0,1461757810,'1','0'),
            (7716198,'amerikanskoe-samoa','Американское Самоа','','',0,0,1461743841,'1','0'),
            (7716199,'britanskaya-territoriya-v-indiyskom-okeane','Британская территория в Индийском океане','','',0,0,1461745118,'1','0'),
            (7716200,'virginskie-ostrova-britanskie','Виргинские острова (Британские)','','',0,0,1461745518,'1','0'),
            (7716201,'virginskie-ostrova-ssha','Виргинские острова (США)','','',0,0,1461745571,'1','0'),
            (7716202,'guam','Гуам','','',0,0,1463061172,'1','0'),
            (7716203,'malie-tihookeanskie-otdalennie-ostrova-ssha','Малые Тихоокеанские Отдаленные острова США','','',0,0,1461750080,'1','0'),
            (7716204,'marshallovi-ostrova','Маршалловы острова','','',0,0,1463062437,'1','0'),
            (7716205,'mikroneziya','Микронезия','','',0,0,1463062667,'1','0'),
            (7716206,'palau','Палау','','',0,0,1461754680,'1','0'),
            (7716208,'puerto-riko','Пуэрто-Рико','','',0,0,1461754879,'1','0'),
            (7716209,'severnie-marianskie-ostrova','Северные Марианские острова','','',0,0,1461755403,'1','0'),
            (7716210,'soedinennie-shtati-ameriki-ssha','Соединенные Штаты Америки (США)','','',0,0,1461756469,'1','0'),
            (7716211,'terks-i-kaykos-ostrova','Теркс и Кайкос, острова','','',0,0,1461757841,'1','0'),
            (7716212,'uruguay','Уругвай','','',0,0,1464278370,'1','0'),
            (7716213,'venezuela','Венесуэла','','',0,0,1464278369,'1','0'),
            (7716214,'samoa','Самоа','','',0,0,1461754973,'1','0'),
            (7716215,'yemen','Йемен','','',0,0,1463061374,'1','0'),
            (7716216,'zambia','Замбия','','',0,0,1464278370,'1','0'),
            (7716217,'tayvanj-provintsiya-kitaya','Тайвань, провинция Китая','','',0,0,1461757744,'1','0'),
            (7716218,'gabon','Габон','','',0,0,1464278369,'1','0'),
            (7716219,'kongo','Конго','','',0,0,1463062087,'1','0'),
            (7716220,'tsentraljno-afrikanskaya-respublika','Центрально-африканская Республика','','',0,0,1461758503,'1','0'),
            (7716221,'chad','Чад','','',0,0,1464278370,'1','0'),
            (7716222,'ekvatorialjnaya-gvineya','Экваториальная Гвинея','','',0,0,1461759125,'1','0'),
            (7716223,'antigua-i-barbuda','Антигуа и Барбуда','','',0,0,1461744037,'1','0'),
            (7716224,'grenada','Гренада','','',0,0,1463061101,'1','0'),
            (7716225,'dominica','Доминика','','',0,0,1464278370,'1','0'),
            (7716226,'monserrat','Монсеррат','','',0,0,1461753144,'1','0'),
            (7716227,'sent-vinsent-i-grenadini','Сент-Винсент и Гренадины','','',0,0,1461755915,'1','0'),
            (7716228,'sent-kits-i-nevis','Сент-Китс и Невис','','',0,0,1461755943,'1','0'),
            (7716229,'sent-lyusiya','Сент-Люсия','','',0,0,1461756039,'1','0'),
            (7716230,'benin','Бенин','','',0,0,1464278369,'1','0'),
            (7716231,'burkina-faso','Буркина-Фасо','','',0,0,1461745200,'1','0'),
            (7716233,'mali','Мали','','',0,0,1464278369,'1','0'),
            (7716234,'niger','Нигер','','',0,0,1464278369,'1','0'),
            (7716235,'senegal','Сенегал','','',0,0,1461755664,'1','0'),
            (7716236,'togo','Того','','',0,0,1461757915,'1','0'),
            (7716237,'frantsuzskaya-polineziya','Французская Полинезия','','',0,0,1461758378,'1','0'),
            (7716238,'novaya-kaledoniya','Новая Каледония','','',0,0,1461754071,'1','0'),
            (7716239,'uollis-i-futuna-ostrova','Уоллис и Футуна, острова','','',0,0,1461758201,'1','0'),
            (7716240,'mejdunarodniy-valyutniy-fond','Международный валютный фонд','','',0,0,1463062649,'1','0'),
            (7716241,'angola','Ангола','','',0,0,1464278369,'1','0'),
            (7716242,'kongo-demokraticheskaya-respublika','Конго, демократическая республика','','',0,0,1463062116,'1','0'),
            (7716243,'bosniya-i-gertsegovina','Босния и Герцеговина','','',0,0,1461744942,'1','0'),
            (7716245,'vatikan-gorod-gosudarstvo','Ватикан, город-государство','','',0,0,1461745441,'1','0'),
            (7716246,'martinika','Мартиника','','',0,0,1463062419,'1','0'),
            (7716247,'san-marino','Сан-Марино','','',0,0,1461755052,'1','0'),
            (7716248,'sen-pjer-i-mikelon','Сен-Пьер и Микелон','','',0,0,1461755588,'1','0'),
            (7716249,'frantsuzskaya-gviana','Французская Гвиана','','',0,0,1461758358,'1','0'),
            (7716250,'frantsuzskie-yujnie-territorii','Французские Южные территории','','',0,0,1461758394,'1','0');
    ");

    }

    public function down()
    {
        $this->delete($this->tablePage);
    }

}
