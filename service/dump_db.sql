-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 30 2020 г., 13:20
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `invest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actives`
--

CREATE TABLE `actives` (
  `id` int NOT NULL,
  `quantity` int NOT NULL,
  `type_id` int NOT NULL,
  `owner_id` int NOT NULL,
  `update_time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `actives`
--

INSERT INTO `actives` (`id`, `quantity`, `type_id`, `owner_id`, `update_time`) VALUES
(9, 1, 1, 17, 1588031071),
(10, 1, 1, 18, 1587688404);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reg_time` int NOT NULL,
  `confirmed` int NOT NULL,
  `confirm_key` varchar(255) NOT NULL,
  `inviter` int NOT NULL DEFAULT '0',
  `recover_key` varchar(255) NOT NULL,
  `balance` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `reg_time`, `confirmed`, `confirm_key`, `inviter`, `recover_key`, `balance`) VALUES
(17, 'markus', 'b0412597dcea813655574dc54a5b74967cf85317f0332a2591be7953a016f8de56200eb37d5ba593b1e4aa27cea5ca27100f94dccd5b04bae5cadd4454dba67d', 'g5056866@gmail.com', 1587531430, 1, '', 0, '', 115657618),
(18, 'ewgenitne85', '23ddb29e3dbc8dec3a67b9ce55f99ab174215d38faf824f911dcb650c336a8c5fb149bb694aa481d188b7f3cfa7f5c28b6806f9285a5dc48bb728a7579fbb652', 'most@narco.net.ua', 1587688403, 0, '7277076f94e7e9021532655de9345f47', 0, '', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actives`
--
ALTER TABLE `actives`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actives`
--
ALTER TABLE `actives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
