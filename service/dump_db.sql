-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 14 2020 г., 05:24
-- Версия сервера: 8.0.20-0ubuntu0.20.04.1
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `host1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
DROP TABLE `users`;
CREATE TABLE `users`
(
    `id`           int UNSIGNED NOT NULL,
    `nickname`     varchar(32)  NOT NULL,
    `email`        varchar(32)  NOT NULL,
    `password`     varchar(256) NOT NULL,
    `reg_time`     int          NOT NULL,
    `confirm_key`  varchar(32)  NOT NULL,
    `recovery_key` varchar(32)  NOT NULL DEFAULT '',
    `inviter_id`   int          NOT NULL DEFAULT '0',
    `confirmed`    tinyint(1)   NOT NULL DEFAULT '0',
    `balance`      bigint       NOT NULL DEFAULT '0',
    `webmoney`     varchar(13)  NOT NULL DEFAULT '',
    `qiwi`         varchar(16)  NOT NULL DEFAULT '',
    `yandex`       varchar(20)  NOT NULL DEFAULT '',
    `card`         varchar(19)  NOT NULL DEFAULT ''
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `reg_time`, `confirm_key`, `recovery_key`, `inviter_id`,
                     `confirmed`, `balance`, `webmoney`, `qiwi`, `yandex`, `card`)
VALUES (1, 'MarkMain', 'g5056866@gmail.com',
        'c05498693e6675d7627b15ad3a325de7083817168db79b2aa1e7033b736ac7edb5a7be41724ecfb16a26dd145e684c34fbb7fb51e5c0b90ca1d6d4ec532c6374',
        1592067725, '', '', 0, 1, 0, 'Z000000000000', '+375299194099', '7966173409123', '1234123412341234');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `users_nickname_unique` (`nickname`),
    ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;