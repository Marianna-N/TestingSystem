-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 09 2017 г., 23:33
-- Версия сервера: 5.7.18-log
-- Версия PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testing_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answer`
--

CREATE TABLE `answer` (
  `a_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `a_text` text NOT NULL COMMENT 'Text of answer',
  `a_correct_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Answer : true or false',
  `a_question` int(10) UNSIGNED DEFAULT NULL COMMENT 'Link to question where picture use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answer`
--

INSERT INTO `answer` (`a_id`, `a_text`, `a_correct_answer`, `a_question`) VALUES
(26, '16', 1, 22),
(27, '20', 0, 22),
(28, '25', 0, 22),
(95, '3', 0, 39),
(96, '4', 1, 39),
(97, '0', 0, 39),
(98, '6', 0, 40),
(99, '7', 0, 40),
(100, '8', 0, 40),
(101, '9', 1, 40),
(102, '0', 0, 41),
(103, '1', 0, 41),
(104, '2', 0, 41),
(105, '3', 1, 41),
(125, 'kitchen', 1, 52),
(126, 'garden', 0, 52),
(137, 'flower', 1, 58),
(138, 'cat', 0, 58);

-- --------------------------------------------------------

--
-- Структура таблицы `assigned_tests`
--

CREATE TABLE `assigned_tests` (
  `at_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `at_user` int(10) UNSIGNED NOT NULL COMMENT 'Link to user id',
  `at_test` int(10) UNSIGNED NOT NULL COMMENT 'Link to test id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `assigned_tests`
--

INSERT INTO `assigned_tests` (`at_id`, `at_user`, `at_test`) VALUES
(2, 6, 13),
(4, 6, 14),
(6, 6, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `formed_test`
--

CREATE TABLE `formed_test` (
  `f_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `f_test` int(10) UNSIGNED NOT NULL COMMENT 'Link to test name',
  `f_question` int(10) UNSIGNED NOT NULL COMMENT 'Link to question'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `formed_test`
--

INSERT INTO `formed_test` (`f_id`, `f_test`, `f_question`) VALUES
(3, 13, 22),
(4, 13, 39),
(5, 13, 41),
(6, 14, 22),
(7, 14, 39),
(8, 14, 40),
(9, 14, 41),
(13, 16, 52),
(14, 16, 58);

-- --------------------------------------------------------

--
-- Структура таблицы `guest`
--

CREATE TABLE `guest` (
  `g_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `g_key` char(31) NOT NULL COMMENT 'Key, which allow to pass the test.',
  `g_test` int(10) UNSIGNED NOT NULL COMMENT 'Link to test name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `label`
--

CREATE TABLE `label` (
  `l_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `l_name` varchar(100) NOT NULL COMMENT 'Label name',
  `l_value` varchar(255) NOT NULL COMMENT 'Label value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `label`
--

INSERT INTO `label` (`l_id`, `l_name`, `l_value`) VALUES
(1, 'test_name', 'test_value'),
(2, 'test_name', 'test_value');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `m_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `m_name` varchar(100) NOT NULL COMMENT 'Message name',
  `m_value` text NOT NULL COMMENT 'Message value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`m_id`, `m_name`, `m_value`) VALUES
(1, 'msg_wrong_password_or_username', 'Wrong login or password!'),
(2, 'msg_login_exists', 'Login already exists!'),
(3, 'msg_email_exists', 'E-mail already exists!'),
(4, 'msg_login_email_exist', 'Login and e-mail already exists!'),
(5, 'msg_reg_successful', 'Registration was successful! Please,log in!'),
(6, 'msg_error_login', 'Login name doesn\'t exist!'),
(7, 'msg_error_test', 'Test name doesn\'t exist!'),
(8, 'msg_error_assign', 'Test and name doesn\'t exist!'),
(9, 'msg_error_key', 'Key doesn\'t exist!');

-- --------------------------------------------------------

--
-- Структура таблицы `picture`
--

CREATE TABLE `picture` (
  `p_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `p_name` varchar(150) NOT NULL COMMENT 'Picture''s name',
  `p_question` int(10) UNSIGNED NOT NULL COMMENT 'Link to question where picture use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `picture`
--

INSERT INTO `picture` (`p_id`, `p_name`, `p_question`) VALUES
(4, '1.jpg', 52),
(10, 'flr.jpg', 58);

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE `question` (
  `q_id` int(10) UNSIGNED NOT NULL COMMENT 'Question''s primary key',
  `q_title` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`q_id`, `q_title`) VALUES
(22, '4*4?'),
(39, '2*2?'),
(40, '3*3?'),
(41, '1+2?'),
(52, 'What is on picture?'),
(58, 'What is it?');

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `t_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `t_name` varchar(100) NOT NULL,
  `t_passes` int(11) DEFAULT NULL COMMENT 'Number of test passes',
  `t_average_pct` float DEFAULT NULL COMMENT 'Average percent of passes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`t_id`, `t_name`, `t_passes`, `t_average_pct`) VALUES
(13, 'Test1', 11, 10.1156),
(14, 'Test2', 1, 25),
(16, 'Test3', 1, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `u_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `u_login` varchar(100) NOT NULL COMMENT 'User''s login',
  `u_password` char(40) NOT NULL COMMENT 'Password as hash',
  `u_name` varchar(150) NOT NULL COMMENT 'User''s name',
  `u_lastname` varchar(200) NOT NULL COMMENT 'User''s lastname',
  `u_training` varchar(20) DEFAULT NULL COMMENT 'User''s training number',
  `u_email` varchar(100) NOT NULL COMMENT 'User''s email.',
  `u_remember` char(40) DEFAULT NULL COMMENT 'hash for cookie',
  `u_permission` int(11) NOT NULL COMMENT 'Separate to admin and listeners'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`u_id`, `u_login`, `u_password`, `u_name`, `u_lastname`, `u_training`, `u_email`, `u_remember`, `u_permission`) VALUES
(1, 'admin1', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'Marianna', 'Vinogradova', 'admin', 'marianna.s.vinogradova@gmail.com', 'IIuIyyUKJrALJUhbzf7ZQg2ynZNw9BW18lMQjd5r', 1),
(6, 'Olga_V', '761ee866d554db1c7582326a910fac8b9764c345', 'Olga', 'Victorovich', 'PHP01', 'ol_v@tt.com', NULL, 0),
(7, 'Serg', '3b236d275e19323e81ce3bca7030380f4ce139cd', 'Sergey', 'Petrov', 'JS03', 'serg_p@gmail.com', NULL, 0),
(8, 'Petya', '5b9fe558f673d63309beb13bfa5da6c30a3ca1bf', 'Petr', 'Volkov', 'PHP01', 'volkov_p@gmail.com', NULL, 0),
(9, 'NLO', '5b323595fb95aceca69cd542a1595430249ae694', 'Nina', 'Lopunchik', 'Java03', 'nlo@tut.by', NULL, 1),
(10, 'Test', '22067cb54a7b24764186f1e48cb4586772733cd7', 'Test Name', 'Test', 'Test_Training', 'test@test.com', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_statistics`
--

CREATE TABLE `user_statistics` (
  `us_id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key',
  `us_user` int(10) UNSIGNED NOT NULL COMMENT 'Link to user id',
  `us_test` int(10) UNSIGNED NOT NULL COMMENT 'Link to passed test',
  `us_percent` float UNSIGNED NOT NULL COMMENT 'Percent, with which user passed the test.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_statistics`
--

INSERT INTO `user_statistics` (`us_id`, `us_user`, `us_test`, `us_percent`) VALUES
(1, 6, 13, 100),
(2, 6, 13, 100),
(3, 6, 13, 100),
(4, 6, 13, 33),
(5, 6, 13, 34),
(7, 6, 13, 100),
(8, 6, 13, 100),
(9, 6, 13, 100),
(10, 6, 13, 100),
(11, 6, 13, 100),
(12, 6, 14, 25),
(13, 6, 16, 100);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `a_question` (`a_question`);

--
-- Индексы таблицы `assigned_tests`
--
ALTER TABLE `assigned_tests`
  ADD PRIMARY KEY (`at_id`),
  ADD KEY `at_test` (`at_test`),
  ADD KEY `at_user` (`at_user`);

--
-- Индексы таблицы `formed_test`
--
ALTER TABLE `formed_test`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_question` (`f_question`),
  ADD KEY `f_test` (`f_test`);

--
-- Индексы таблицы `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`g_id`),
  ADD UNIQUE KEY `UQ_guest_g_key` (`g_key`),
  ADD KEY `g_test` (`g_test`);

--
-- Индексы таблицы `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`l_id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`m_id`);

--
-- Индексы таблицы `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_question` (`p_question`);

--
-- Индексы таблицы `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`t_id`),
  ADD UNIQUE KEY `UQ_test_t_name` (`t_name`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `UQ_user_u_email` (`u_email`),
  ADD UNIQUE KEY `UQ_user_u_login` (`u_login`),
  ADD UNIQUE KEY `UQ_user_u_remember` (`u_remember`);

--
-- Индексы таблицы `user_statistics`
--
ALTER TABLE `user_statistics`
  ADD PRIMARY KEY (`us_id`),
  ADD KEY `us_test` (`us_test`),
  ADD KEY `us_user` (`us_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answer`
--
ALTER TABLE `answer`
  MODIFY `a_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT для таблицы `assigned_tests`
--
ALTER TABLE `assigned_tests`
  MODIFY `at_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `formed_test`
--
ALTER TABLE `formed_test`
  MODIFY `f_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `guest`
--
ALTER TABLE `guest`
  MODIFY `g_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `label`
--
ALTER TABLE `label`
  MODIFY `l_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `m_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `picture`
--
ALTER TABLE `picture`
  MODIFY `p_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `question`
--
ALTER TABLE `question`
  MODIFY `q_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Question''s primary key', AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `t_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `user_statistics`
--
ALTER TABLE `user_statistics`
  MODIFY `us_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=14;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_answer_question` FOREIGN KEY (`a_question`) REFERENCES `question` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `assigned_tests`
--
ALTER TABLE `assigned_tests`
  ADD CONSTRAINT `FK_assigned_tests_test` FOREIGN KEY (`at_test`) REFERENCES `test` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_assigned_tests_user` FOREIGN KEY (`at_user`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `formed_test`
--
ALTER TABLE `formed_test`
  ADD CONSTRAINT `FK_formed_test_question` FOREIGN KEY (`f_question`) REFERENCES `question` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_formed_test_test` FOREIGN KEY (`f_test`) REFERENCES `test` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `guest`
--
ALTER TABLE `guest`
  ADD CONSTRAINT `FK_guest_test` FOREIGN KEY (`g_test`) REFERENCES `test` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `FK_picture_question` FOREIGN KEY (`p_question`) REFERENCES `question` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_statistics`
--
ALTER TABLE `user_statistics`
  ADD CONSTRAINT `FK_user_statistics_test` FOREIGN KEY (`us_test`) REFERENCES `test` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_statistics_user` FOREIGN KEY (`us_user`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
