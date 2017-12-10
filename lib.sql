-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 10 2017 г., 21:25
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lib`
--

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT 'название книги'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id`, `name`) VALUES
(1, 'Пикник на обочине'),
(8, 'Гарри Поттер и философский камень'),
(18, 'Понедельник начинается в субботу'),
(19, 'Гарри Поттер и тайная комната'),
(20, 'Хоббит'),
(21, 'Обитаемый остров');

-- --------------------------------------------------------

--
-- Структура таблицы `book_genre`
--

CREATE TABLE `book_genre` (
  `book_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book_genre`
--

INSERT INTO `book_genre` (`book_id`, `genre_id`) VALUES
(1, 1),
(8, 1),
(18, 1),
(19, 1),
(21, 1),
(8, 3),
(19, 3),
(20, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `book_vote`
--

CREATE TABLE `book_vote` (
  `id` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL COMMENT 'оценка',
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book_vote`
--

INSERT INTO `book_vote` (`id`, `value`, `book_id`, `user_id`) VALUES
(30, 1, 1, 1),
(31, -1, 1, 2),
(32, 1, 18, 2),
(39, 1, 8, 1),
(40, 1, 20, 2),
(41, 1, 20, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `book_writer`
--

CREATE TABLE `book_writer` (
  `book_id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book_writer`
--

INSERT INTO `book_writer` (`book_id`, `writer_id`) VALUES
(1, 1),
(18, 1),
(21, 1),
(1, 2),
(18, 2),
(21, 2),
(8, 3),
(19, 3),
(20, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL COMMENT 'название жанра'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'фантастика'),
(3, 'фэнтези');

-- --------------------------------------------------------

--
-- Структура таблицы `genre_vote`
--

CREATE TABLE `genre_vote` (
  `id` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL COMMENT 'оценка',
  `genre_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre_vote`
--

INSERT INTO `genre_vote` (`id`, `value`, `genre_id`, `user_id`) VALUES
(1, 1, 3, 1),
(2, -1, 1, 1),
(3, 1, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'user', 'rgtTudcbExKOfUQHp-30s1sCisfja85M', '$2y$13$2ooLGBdSp2n3eZrg9XX/GOQYEKKRAPdVvLc4f3PolQ2UZ.VmaXuC2', NULL, 'aachekalov@gmail.com', 10, 1512286156, 1512286156),
(2, 'user2', '5KVImj8xJcdmWphPAE_4JZA3eb72vNQ2', '$2y$13$klIY8b.mc2.S3jxBdGCZXOhrZ/tfCbqxbM0b/Rbjc334XXrcnvynC', NULL, 'aachekalov2@gmail.com', 10, 1512802598, 1512802598);

-- --------------------------------------------------------

--
-- Структура таблицы `writer`
--

CREATE TABLE `writer` (
  `id` int(11) NOT NULL,
  `surname` varchar(128) NOT NULL COMMENT 'фамилия',
  `name` varchar(128) NOT NULL COMMENT 'имя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `writer`
--

INSERT INTO `writer` (`id`, `surname`, `name`) VALUES
(1, 'Стругацкий', 'Аркадий'),
(2, 'Стругацкий', 'Борис'),
(3, 'Роулинг', 'Джоан'),
(4, 'Толкин', 'Джон');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`book_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `book_vote`
--
ALTER TABLE `book_vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Индексы таблицы `book_writer`
--
ALTER TABLE `book_writer`
  ADD PRIMARY KEY (`book_id`,`writer_id`),
  ADD KEY `writer_id` (`writer_id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `genre_vote`
--
ALTER TABLE `genre_vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Индексы таблицы `writer`
--
ALTER TABLE `writer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `book_vote`
--
ALTER TABLE `book_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `genre_vote`
--
ALTER TABLE `genre_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `writer`
--
ALTER TABLE `writer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book_genre`
--
ALTER TABLE `book_genre`
  ADD CONSTRAINT `book_genre_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Ограничения внешнего ключа таблицы `book_vote`
--
ALTER TABLE `book_vote`
  ADD CONSTRAINT `book_vote_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `book_writer`
--
ALTER TABLE `book_writer`
  ADD CONSTRAINT `book_writer_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_writer_ibfk_2` FOREIGN KEY (`writer_id`) REFERENCES `writer` (`id`);

--
-- Ограничения внешнего ключа таблицы `genre_vote`
--
ALTER TABLE `genre_vote`
  ADD CONSTRAINT `genre_vote_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genre_vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
