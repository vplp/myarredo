$(document).ready(function () {
// start main js
    console.time('speed main js');

// function-performer for show message in form
// Функция-отправитель для показа/скрития сообщений в форме обратной связи
// mess - String, текст сообщения который надо показать в форме
// bool - Boolean, значение для указания это сообщения об ошибке или об успехе true - это успешно, false - об ошибке
    function messagesForm(mess, bool) {
        if (bool) {
            $('.form-contacts').find('.messagesbox').removeClass('error').addClass('success').text(mess).slideDown();
        } else {
            $('.form-contacts').find('.messagesbox').removeClass('success').addClass('error').text(mess).slideDown();
        }
        // скрываем сообщение через 8 секунд
        setTimeout(function () {
            $('.form-contacts').find('.messagesbox').removeClass('success error').text('').slideUp();
        }, 8000);
    }

    // for open/close langswitch
    // функционал закрития/открития переключателя языков в шапке сайта
    $('.langswitch').on('click', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).siblings('.langdropbox').slideUp();
        } else {
            $(this).addClass('open');
            $(this).siblings('.langdropbox').slideDown();
        }
    });

    // Smooth scrols (W3C recomended)
    // Функционал плавного скрола по рекомендациям W3C
    // можно добавлять новые ссылки через запятую
    $(".sofa-link, .footer-logo-link").on('click', function (event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 900, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });

    // Переводы для ошибок валидации формы и сообщений формы - Русская и Италлянская версии сайта
    if ($('body').attr('data-langval') == 'ru') {
        var reqNameMess = 'Необходимо заполнить - Имя';
        var shortNameMess = 'Минимум 2 символа';
        var reqEmailMess = 'Необходимо заполнить e-mail';
        var correctEmailMess = 'Неккоректный e-mail адресс';
        var reqRegMess = 'Необходимо заполнить - Регион';
        var reqPhoneMess = 'Необходимо заполнить - Телефон';
        var numberMess = "Не корректный номер";
        var reqSiteMess = 'Необходимо заполнить - Сайт';
        var urlMess = 'Ссылка на сайт не корректная';
        var reqTextareaMess = 'Укажите текст сообщения';
        var succesSubmitMess = 'Сообщение успешно отправлено! Мы ответим в ближайшее время';
        var errorEmtySubmitMess = 'Сообщение не отправлено! Заполнены не все поля!';
        var errorSubmitMess = 'Сообщение не отправлено! Не удалось связаться с сервером!';
    } else if ($('body').attr('data-langval') == 'it') {
        var reqNameMess = 'Richiesto - Nome';
        var shortNameMess = 'Almeno 2 caratteri';
        var reqEmailMess = 'È necessario compilare l e-mail';
        var correctEmailMess = 'Indirizzo e-mail errato';
        var reqRegMess = 'Richiesto - Regione';
        var reqPhoneMess = 'Richiesto - Telefono';
        var numberMess = "Numero non valido";
        var reqSiteMess = 'Richiesto - Sito';
        var urlMess = 'Il link al sito non è corretto';
        var reqTextareaMess = 'Inserisci il testo del messaggio';
        var succesSubmitMess = 'Messaggio inviato con successo! Ti risponderemo al più presto';
        var errorEmtySubmitMess = 'Messaggio non inviato Non tutti i campi sono riempiti!';
        var errorSubmitMess = 'Messaggio non inviato Impossibile contattare il server!';
    }
    else {
        var reqNameMess = 'Required - Name';
        var shortNameMess = 'At least 2 characters';
        var reqEmailMess = 'You need to fill in the email';
        var correctEmailMess = 'Wrong email address';
        var reqRegMess = 'Required - Region';
        var reqPhoneMess = 'Required - Telephone';
        var numberMess = "Invalid number";
        var reqSiteMess = 'Required - Site';
        var urlMess = 'The link to the site is incorrect';
        var reqTextareaMess = 'Enter the message text';
        var succesSubmitMess = 'The message has been successfully sent! We will reply as soon as possible';
        var errorEmtySubmitMess = 'Message not sent Not all fields are filled!';
        var errorSubmitMess = 'Message not sent Unable to contact the server!';
    }

    // Validation and submit form
    // Функционал для валидации и отправки формы
    $(".form-contacts").validate({
        // устанавливаем правила валидации
        rules: {
            namefield: {
                required: true,
                minlength: 2
            },
            emailfield: {
                required: true,
                email: true
            },
            textfield: {
                required: true,
            },
            regionfield: {
                minlength: 2
            },
            phonefield: {
                required: true,
                number: true
            },
            sitefield: {
                url: true
            }
        },
        // устанавливаем сообщения для ошибок
        messages: {
            namefield: {
                required: reqNameMess,
                minlength: shortNameMess
            },
            emailfield: {
                required: reqEmailMess,
                email: correctEmailMess
            },
            textfield: {
                required: reqTextareaMess,
            },
            regionfield: {
                minlength: shortNameMess
            },
            phonefield: {
                required: reqPhoneMess,
                number: numberMess
            },
            sitefield: {
                url: urlMess
            }
        },
        // если валидация пройдена
        submitHandler: function () {
            // получаем нашу форму
            var ourForm = $(".form-contacts");
            // отправляем аякс-пост запрос на сервер и передаем туда данные из формы
            $.ajax({
                type: 'POST',
                url: '/forms/forms/ajax-promo/',
                data: {
                    name: ourForm.find('#name_field').val(),
                    email: ourForm.find('#email_field').val(),
                    textArrea: ourForm.find('#text_field').val()
                },
                success: function (data) {
                    console.log(data)
                    // если сервер сообщает что сообщение отправлено
                    if (data.success) {
                        ourForm[0].reset();
                        messagesForm(succesSubmitMess, true);
                    } else {
                        messagesForm(errorEmtySubmitMess, false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    //messagesForm(errorSubmitMess, false);
                    messagesForm('Error: '+ errorThrown, false);
                    console.log('Error: '+ errorThrown);
                }
            }, 'json');
        }
    });

    // --------------------------------js for calculator------------------------------------
    // Функционал калькулятора - интегрирован с старого лендинга - Myarredo.com
    // open/close controller
    $('.calculator').find('.calculator-triger').on('click', function (etg) {
        if (!$(this).hasClass('open')) {
            $('.calculator').find('.calculator-triger').removeClass('open');
            $(this).addClass('open');
            $('.calculator').find('.calculator-drop').slideUp();
            $(this).siblings('.calculator-drop').slideDown();
        } else {
            $(this).removeClass('open');
            $(this).siblings('.calculator-drop').slideUp();
        }

    });
    // selected controller
    $('.calculator').find('.calculator-list').children('li').on('click', function (etg) {
        var thisText = $(this).html();
        $(this).parent('.calculator-list').children('li').each(function (i, elem) {
            $(elem).removeClass('active');
        });
        $(this).addClass('active');
        $(this).closest('.calculator-drop').siblings('.calculator-triger').children('.for-selected').html(thisText);
        $(this).closest('.calculator-drop').slideUp();
        $(this).closest('.calculator-drop').siblings('.calculator-triger').removeClass('open');

        // calculation functional
        var articulCurent = $('.calculator').find('.calc-articul').find('.calculator-list').children('li.active').attr('id');
        var priceArticul = 0;
        var budgetCurentData = "";
        var detectCurentBudget = /\d+/g;
        var budgetCurent = "";
        var dynamicBudget = 0;
        var curentBudgetVal = "";
        var activeCountry = $('.calculator').find('.calc-country').find('.for-selected').attr('data-country');
        switch (articulCurent) {
            case "artcl_1":
                priceArticul = 1000;
                break;
            case "artcl_2":
                priceArticul = 2000;
                break;
            case "artcl_3":
                priceArticul = 3000;
                break;
            case "artcl_4":
                priceArticul = 4000;
                break;
            case "artcl_5":
                priceArticul = 5000;
                break;
        }
        // for Belarus
        if ($(this).hasClass('s-bel')) {
            $('.calculator').find('.calc-budget').find('.calculator-list').children('li').each(function (i, elem) {
                curentBudgetVal = $(elem).attr('data-budget').match(detectCurentBudget);
                dynamicBudget = (+curentBudgetVal[0] + priceArticul) * 85 / 100;
                $(elem).html(dynamicBudget + " RUB");
            });
            budgetCurentData = $('.calculator').find('.calc-budget').find('.calculator-list').children('li.active').html();
            budgetCurent = budgetCurentData.match(detectCurentBudget);
            $('.calculator').find('.calc-budget').children('.calculator-triger').children('.for-selected').html(budgetCurent[0] + " RUB");
            $(this).closest('.calc-country').find('.for-selected').attr('data-country', '0');
        }
        // for Russia
        else if ($(this).hasClass('s-rus')) {
            $('.calculator').find('.calc-budget').find('.calculator-list').children('li').each(function (i, elem) {
                curentBudgetVal = $(elem).attr('data-budget').match(detectCurentBudget);
                dynamicBudget = +curentBudgetVal[0] + priceArticul;
                $(elem).html(dynamicBudget + " RUB");
            });

            budgetCurentData = $('.calculator').find('.calc-budget').find('.calculator-list').children('li.active').html();
            budgetCurent = budgetCurentData.match(detectCurentBudget);
            $('.calculator').find('.calc-budget').children('.calculator-triger').children('.for-selected').html(budgetCurent[0] + " RUB");
            $(this).closest('.calc-country').find('.for-selected').attr('data-country', '1');
        }
        // change article
        else if ($(this).hasClass('s-articl')) {
            if (activeCountry === '0') {
                $('.calculator').find('.calc-budget').find('.calculator-list').children('li').each(function (i, elem) {
                    curentBudgetVal = $(elem).attr('data-budget').match(detectCurentBudget);
                    dynamicBudget = (+curentBudgetVal[0] + priceArticul) * 85 / 100;
                    $(elem).html(dynamicBudget + " RUB");
                });
            } else if (activeCountry === '1') {
                $('.calculator').find('.calc-budget').find('.calculator-list').children('li').each(function (i, elem) {
                    curentBudgetVal = $(elem).attr('data-budget').match(detectCurentBudget);
                    dynamicBudget = +curentBudgetVal[0] + priceArticul;
                    $(elem).html(dynamicBudget + " RUB");
                });
            }
            budgetCurentData = $('.calculator').find('.calc-budget').find('.calculator-list').children('li.active').html();
            budgetCurent = budgetCurentData.match(detectCurentBudget);
            $('.calculator').find('.calc-budget').children('.calculator-triger').children('.for-selected').html(budgetCurent[0] + " RUB");
        }
        // change Budget
        else if ($(this).hasClass('s-budget')) {
            $('.calculator').find('.calculator-result').find('.result-box').html("");
        }

    });
    // controller recalculate views
    $('.calculator').find('.btn-result').on('click', function (etg) {
        var countryData = $('.calculator').find('.calc-country').find('.for-selected').attr('data-country');
        var articulCurent = $('.calculator').find('.calc-articul').find('.calculator-list').children('li.active').attr('id');
        var articleData = 0;
        var detectCurentBudget = /\d+/g;
        var budgetData = $('.calculator').find('.calc-budget').find('.calculator-list').children('li.active').attr('data-budget').match(detectCurentBudget);
        var viewsResult = 0;

        switch (articulCurent) {
            case "artcl_1":
                articleData = 1000;
                break;
            case "artcl_2":
                articleData = 2000;
                break;
            case "artcl_3":
                articleData = 3000;
                break;
            case "artcl_4":
                articleData = 4000;
                break;
            case "artcl_5":
                articleData = 5000;
                break;
        }

        switch (budgetData[0]) {
            case "24000":
                viewsResult = 1000;
                break;
            case "32000":
                viewsResult = 1400;
                break;
            case "40000":
                viewsResult = 1900;
                break;
            case "48000":
                viewsResult = 2500;
                break;
            case "56000":
                viewsResult = 3100;
                break;
            case "64000":
                viewsResult = 3600;
                break;
            case "72000":
                viewsResult = 4200;
                break;
            case "80000":
                viewsResult = 5000;
                break;
        }
        // if ($('body').hasClass('rulang')) {
        //     $('.calculator').find('.calculator-result').find('.result-box').html('<span class="result">' + viewsResult + '</span>' + 'просмотров');
        // } else {
        //     $('.calculator').find('.calculator-result').find('.result-box').html('<span class="result">' + viewsResult + '</span>' + 'visualizzazioni');
        // }
        $('.calculator').find('.calculator-result').find('.result-box').html('<span class="result">' + viewsResult + '</span>');

    });

    // closing an item when clicking outside its area
    $(document).on('mouseup', function (etg) {
        var calcTrigger = $('.calculator').find('.calculator-triger');
        var calcDrops = $('.calculator').find('.calculator-drop');
        if (!calcTrigger.is(etg.target) && calcTrigger.has(etg.target).length === 0 &&
            !calcDrops.is(etg.target) && calcDrops.has(etg.target).length === 0) {
            calcTrigger.removeClass('open');
            calcDrops.slideUp();
        }
    });
    // ---------------end js for calculator-----------------------------

    console.timeEnd('speed main js');
// end main js
});
