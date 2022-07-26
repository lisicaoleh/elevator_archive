Административная панель для ведения архива о критических кренах элеватора

Даная програма защищена паролем с md5 хешем, пароль 0000

Основной функционал: 
- Поиск записей начиная с определённой даты.
- Добавление/удаление/скачивание отчётов записи по id.
- Удаление всей записи с базы с защитой от случайного нажатия.
- Показ сообщения в случае добавления записей в базе.
- Система увидомлений для оповещения пользователя при выполнении различных действий.
- Отправка сообщения всем пользователям с установленым андроид приложение.

Для запуска проекта виколните следующий SQL запрос:

CREATE DATABASE elevator;

CREATE TABLE accident (id INT(11) AUTO_INCREMENT, time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));

INSERT INTO `accident` (`id`, `time`) VALUES (NULL, CURRENT_TIMESTAMP), (NULL, CURRENT_TIMESTAMP), (NULL, CURRENT_TIMESTAMP), (NULL, CURRENT_TIMESTAMP);

CREATE TABLE report (accident_id INT(11), path VARCHAR(255), PRIMARY KEY (id));

После добавте связь 1 к 1 между полями id и accident_id

И в файле init.php допишите host, database_name, login, password

В данном проекте использована связь 1 к 1, так как планировалось что б возможно было к одному инциденту добавить несколько отчётов.
