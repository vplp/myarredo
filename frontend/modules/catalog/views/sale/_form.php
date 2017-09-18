
<?php

/* !!! */ echo  '<pre style="color:red;">'; print_r($model); echo '</pre>'; /* !!! */
?>
<main>
    <div class="page create-sale">
        <div class="container large-container">
            <h1>Добавить товар в распродажу</h1>
            <div class="column-center">
                <div class="form-horizontal">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        Для загрузки изображений - сначала создайте товар
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Название</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Категория</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите вариант</button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Спальни</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Кухни</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Столовые комнаты</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Предмет*</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите предмет</button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Аксессуары</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Факсессуары для ванной</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">База под раковину</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Фабрика*</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите фабрику</button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Airnova</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Alberta royal</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">ALF</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Фабрика(если нет в списке, добавляются только фабрики Италии)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Стиль</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите вариант</button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Арт деко, гламур</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Барокко, Рококо</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Классический</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Материал</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите вариант</button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Гранит</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">ДСП</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Замша</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Описание</label>
                        <div class="col-sm-9">
                            <textarea name="" id="" cols="20" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Длина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Глубина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Высота</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Диаметр</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Внутренняя длина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Внутренняя глубина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Обьем</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Цена</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="0.00">
                        </div>
                    </div>

                    <div class="form-group row price-row">
                        <label class="col-sm-3 col-form-label">Новая цена*</label>
                        <div class="col-sm-1" style="padding: 0 5px 0 15px;">
                            <input type="text" class="form-control" >
                        </div>
                        <div class="col-sm-1" style="padding: 0 5px 0 5px;">
                            <select class="selectpicker">
                                <option>EUR</option>
                                <option>RUB</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Статус</label>

                        <div class="col-sm-9">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" checked="">
                                <label for="checkbox1">
                                    Активный
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="buttons-cont">
                        <button type="button" class="btn btn-primary btn-lg">Сохранить</button>
                        <button type="button" class="btn btn-primary btn-lg">Отменить</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>