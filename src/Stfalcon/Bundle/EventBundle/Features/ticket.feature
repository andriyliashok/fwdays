# language: ru

Функционал: Тест екшена генерации и проверки билетов
    Тестируем создание билета с QR-кодом

    Сценарий: Проверяем не созданный или неоплаченный билет
        Допустим я вхожу в учетную запись с именем "user@fwdays.com" и паролем "qwerty"
        Допустим я оплатил билет для "user@fwdays.com"
        И я перехожу на "/event/zend-framework-day-2011/ticket"
        Тогда код ответа сервера должен быть 200
        И это PDF-файл

    Сценарий: Проверяем не созданный или неоплаченный билет
        Допустим я вхожу в учетную запись с именем "user@fwdays.com" и паролем "qwerty"
        Допустим я не оплатил билет для "user@fwdays.com"
        И я перехожу на "/event/zend-framework-day-2011/ticket"
        Тогда код ответа сервера должен быть 402
        И я должен видеть "Вы не оплачивали участие в \"Zend Framework Day\""

    #Тестируем проверку билета с QR-кодом
    Сценарий: Проверяем регистрацию билета в системе не администратором
        Допустим я вхожу в учетную запись с именем "user@fwdays.com" и паролем "qwerty"
        И я перехожу на страницу регистрации билета для пользователя "user@fwdays.com" для события "zend-framework-day-2011"
        Тогда код ответа сервера должен быть 403

    Сценарий: Проверяем регистрацию билета в системе администратором
        Допустим я вхожу в учетную запись с именем "admin@fwdays.com" и паролем "qwerty"
        И я перехожу на страницу регистрации билета для пользователя "user@fwdays.com" для события "zend-framework-day-2011"
        Тогда код ответа сервера должен быть 200
        И я должен видеть "Все ок"
        #Пробуем зарегестрироваться еще раз
        И я перехожу на страницу регистрации билета для пользователя "user@fwdays.com" для события "zend-framework-day-2011"
        Тогда код ответа сервера должен быть 409
        И я должен видеть "был использован"
        #Пробуем зарегестрироваться с неправильным хешем
        И я перехожу на страницу регистрации билета с битым хешем для пользователя "user@fwdays.com" для события "zend-framework-day-2011"
        Тогда код ответа сервера должен быть 403
        И я должен видеть "Невалидный хеш для билета"

    @mink:selenium2
    Сценарий: Selenium
        Допустим я вхожу в учетную запись с именем "peter.parker@fwdays.com" и паролем "qwerty"
        Допустим я на странице "/event/zend-framework-day-2011/pay"
        Тогда я должен видеть "Оплата участия в конференции Zend Framework Day"
#        Тогда я должен видеть "Peter Parker — 100.00 грн." // розкоментировать, цсс бан в фаерфоксе!!!
        И я кликаю по ссылке "Оплатить других участников"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_0_name" значением "jack.sparrow@fwdays.com"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_0_email" значением "jack.sparrow@fwdays.com"
        И я кликаю по ссылке "Еще участники"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_1_name" значением "user@fwdays.com"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_1_email" значением "user@fwdays.com"
        И я кликаю по ссылке "Еще участники"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_2_name" значением "user@fwdays.com"
        Тогда я заполняю поле "stfalcon_event_ticket_participants_2_email" значением "user@fwdays.com"
        И я нажимаю "Закончить список и посчитать сумму"
        И я должен видеть "Peter Parker — 100.00 грн."
        И я должен видеть "Jack Sparrow — 100.00 грн 80.00 грн."
        И я должен видеть "Сумма к оплате: 180.00 грн."
        И я жду
