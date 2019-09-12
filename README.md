CMS CORE
========

Инсталяция.

1. Создаем пустой реапозиторий
    git init

2. Создаем подключение к удаленному реапозиторию CMS CORE
    git remote add core [ url ]

3. Загружаем данные из реапозитария CMS CORE
    git pull core master

4. Инициализация системы
    php init
    
    4.1 Выполняем 
    composer install

5. Создание подключений к БД. Редактируем файл
    /common/config/db.php

6. Загрузка миграций
    php yii migrate

Дополнительная документация
    /thread/doc
    
=======
    
7. CRON Example
/opt/php71/bin/php /var/www/www-root/data/www/myarredo.ru/yii cron/index
