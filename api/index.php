<!-- 

Website created with php. Includes API for chatting (client: https://github.com/winzmcman/fartuh-chat)
Copyright (C) 2020 Nikita Pavlov
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.
Author's email: nikitafartuh@ukr.net -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h4>fartuh.xyz API Документация</h4>

    <pre>GET https://fartuh.xyz/api/chat?login=ЛогинПользтвателя&password=ПарольПользователя
Выводит последние 10 сообщений ввиде (от самого последнего к предыдущим) json

[{"id":"тут id сообщения1", "text":"текст сообщения1", "sent_at": "время отправки1", "login":"логин отправителя1"}, {"id":"тут id сообщения2", "text":"текст сообщения2", "sent_at": "время отправки2", "login":"логин отправителя2"}...]

GET https://fartuh.xyz/api/chat?id=idНужнооСообщения&login=ЛогинПользтвателя&password=ПарольПользователя
Выводит json в том же формате, что и выше, но только одного сообщения.

{"id":"тут id сообщения1", "text":"текст сообщения1", "sent_at": "время отправки1", "login":"логин отправителя1"}

В случае ошибки возвращает {"result":false, "error":"Текст ошибки", "errorcode": "Код ошибки"}

POST https://fartuh.xyz/api/chat/index.php?login=ЛогинПользтвателя&password=ПарольПользователя&text=ТекстСообщения
Запрос на добавление сообщения

В случае удачи возвращает json с {"result":true}, в случае ошибки возвращает result false, код ошибки и текст ошибки.

GET
https://fartuh.xyz/api/users
Возвращает всех пользователей ввиде json

[{"id":"тут id пользователя1", "login":"тут логин пользователя1", "status":"тут статус пользователя1"}, {"id":"тут id пользователя2", "login":"тут логин пользователя2", "status":"тут статус пользователя2"}...]

GET
https://fartuh.xyz/api/users?id=idПользователя
Возвращает json того де формата о конкретном пользователе

{"id":"тут id пользователя1", "login":"тут логин пользователя1", "status":"тут статус пользователя1"}

POST
https://fartuh.xyz/api/users/index.php?login=ТутЛогин&password=ТутПароль

Возвращает {"result":true} Если такой пользователь есть и данные для авторизации правильные или если такого пользователя не было и он зарегистрирован. В случае ошибки возвращает result false, код ошибки и текст ошибки.


Коды ошибок:
1- Пароль слишком короткий
2- Пользователь уже зарегистрирован
3- Неправильный логин или пароль
4- Такого id не существует
5- Недостаточно информации</pre>
</body>
</html>
