-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 08 2018 г., 10:42
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `soullaqd_bke`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Sotrud`
--
-- Создание: Май 04 2018 г., 04:46
-- Последнее обновление: Май 06 2018 г., 18:05
--

DROP TABLE IF EXISTS `Sotrud`;
CREATE TABLE `Sotrud` (
  `Id_sotrud` int(11) NOT NULL,
  `surName_Sotrud` varchar(55) NOT NULL,
  `Name_Sotrud` varchar(55) NOT NULL,
  `Otchestvo_sotrud` varchar(55) NOT NULL,
  `Id_Technique` int(11) NOT NULL,
  `Korpus_and_Kabinet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Sotrud`
--

INSERT INTO `Sotrud` (`Id_sotrud`, `surName_Sotrud`, `Name_Sotrud`, `Otchestvo_sotrud`, `Id_Technique`, `Korpus_and_Kabinet`) VALUES
(5, 'Орехов', 'Василий', 'Иванов', 1, '1корп.\r\nКб 108\r\n'),
(6, 'Иванов', 'Николай', 'Михайлович', 2, '1корп.\r\nКб508\r\n'),
(7, 'Манченко', 'Сергей', 'Алексеевич', 3, '2корп\r\nКб 607\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `Technique`
--
-- Создание: Май 04 2018 г., 04:47
-- Последнее обновление: Май 08 2018 г., 07:39
--

DROP TABLE IF EXISTS `Technique`;
CREATE TABLE `Technique` (
  `Id_Technique` int(11) NOT NULL,
  `Name_Technique` text NOT NULL,
  `Information_Technique` text NOT NULL,
  `ID_To` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Technique`
--

INSERT INTO `Technique` (`Id_Technique`, `Name_Technique`, `Information_Technique`, `ID_To`) VALUES
(1, 'МФУ HP LaserJet Pro M28w(W2G55A)', 'Технология печати: Лазерная.\r\nОригинальный лазерный картридж HP LaserJet 44A, черный(CF244A)\r\n\r\n', 1),
(2, 'Сканер HP SCANJET G3110', 'Высота	7 см\r\nШирина	30,5 см\r\nГлубина	45,5 см\r\nВес	2,9 кг\r\nЦвет	Серый\r\n', 2),
(3, 'ПК Acer Extensa EX2610G [DT.X0MER.013', '[Intel Celeron J3060, 2x1600 МГц, 4 ГБ DDR3L, HDD 500 ГБ, без ОС]', 3),
(28, '15.6&quot; Ноутбук MSI GP62M 7REX-2091RU', '[AMD A4 6300, 2x3700 МГц, 2 ГБ DDR3, HDD 500 ГБ, Windows 10 Домашняя]', 44);

-- --------------------------------------------------------

--
-- Структура таблицы `TechniqueDate`
--
-- Создание: Май 06 2018 г., 02:27
-- Последнее обновление: Май 08 2018 г., 07:40
--

DROP TABLE IF EXISTS `TechniqueDate`;
CREATE TABLE `TechniqueDate` (
  `ID_TO` int(11) NOT NULL,
  `Time_TO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `TechniqueDate`
--

INSERT INTO `TechniqueDate` (`ID_TO`, `Time_TO`) VALUES
(1, '2018-05-11'),
(2, '2018-04-19'),
(3, '2019-06-21'),
(44, '2018-05-01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Sotrud`
--
ALTER TABLE `Sotrud`
  ADD PRIMARY KEY (`Id_sotrud`),
  ADD KEY `Id_Technique` (`Id_Technique`);

--
-- Индексы таблицы `Technique`
--
ALTER TABLE `Technique`
  ADD PRIMARY KEY (`Id_Technique`),
  ADD KEY `ID_TO` (`ID_To`);

--
-- Индексы таблицы `TechniqueDate`
--
ALTER TABLE `TechniqueDate`
  ADD PRIMARY KEY (`ID_TO`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Sotrud`
--
ALTER TABLE `Sotrud`
  MODIFY `Id_sotrud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `Technique`
--
ALTER TABLE `Technique`
  MODIFY `Id_Technique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `TechniqueDate`
--
ALTER TABLE `TechniqueDate`
  MODIFY `ID_TO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Sotrud`
--
ALTER TABLE `Sotrud`
  ADD CONSTRAINT `Sotrud_ibfk_1` FOREIGN KEY (`Id_Technique`) REFERENCES `Technique` (`Id_Technique`);

--
-- Ограничения внешнего ключа таблицы `Technique`
--
ALTER TABLE `Technique`
  ADD CONSTRAINT `Technique_ibfk_1` FOREIGN KEY (`ID_To`) REFERENCES `TechniqueDate` (`ID_TO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
