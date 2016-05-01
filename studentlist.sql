-- MySQL dump 10.13  Distrib 5.7.10, for Win64 (x86_64)
--
-- Host: localhost    Database: studentlist
-- ------------------------------------------------------
-- Server version	5.7.10-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abiturient`
--

DROP TABLE IF EXISTS `abiturient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abiturient` (
  `name` varchar(60) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(50) NOT NULL,
  `groupNumber` varchar(5) NOT NULL,
  `points` int(4) NOT NULL,
  `year` year(4) NOT NULL,
  `loko` enum('yes','no') NOT NULL,
  `abiturientID` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`abiturientID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abiturient`
--

LOCK TABLES `abiturient` WRITE;
/*!40000 ALTER TABLE `abiturient` DISABLE KEYS */;
INSERT INTO `abiturient` VALUES ('Васька','Пупкин','male','one2@ya.ru','123',100,1994,'yes',102),('Васька','Пупкин','male','one@ya.ru','123',100,1994,'yes',103),('Петька','Пупкин','male','two@ya.ru','123',200,1994,'yes',104),('Саня','Белый','male','sanyawhite@mail.ru','90',50,1960,'yes',105),('Маша','Ктулхова','female','masha@ya.ru','3213',400,1992,'yes',106),('Маша','Сайхилова','female','masha2@ya.ru','1345',340,1993,'yes',107),('Павел','Маслянкин','male','pavel@mail.ru','48151',323,1997,'no',108),('Елена','Полено','female','elena@rambler.com','2А3Б',246,2000,'no',109),('Джек','Воробей','male','jacksparrow@gmail.com','КРБ4',40,1989,'no',110),('Никита','Базаров','male','nikita@ya.ru','АНМ4',210,1995,'yes',111),('Александр','Пушкин','male','sanya05rus@ya.ru','Б12',370,2001,'no',112),('Сергей','Грызлов','male','sergey@ya.ru','МТР42',360,1998,'no',114),('Маша','Вичхаусова','female','osnova@ya.ru','абв32',246,1999,'no',115),('Анон','Пхптредов','male','iphonetask@ya.ru','2ч',370,1998,'yes',116),('Анна','Свечкарева','female','anna@ya.ru','ЫЧ134',180,2000,'no',117),('Георгий','Смертин','male','georg@ya.ru','МТР42',402,1998,'yes',118),('Сенпай','Каваев','male','kavaiii@ya.ru','АНМ4',210,1999,'no',119),('Марина','Киркорова','female','marinalove@ya.ru','ЫЧ134',221,1999,'no',120),('Списал','Хорошо','male','minobrrf@ya.ru','ЫЧ134',450,1997,'no',121),('Мяу','Мурмяу','female','meow@gmail.com','ЫЧ134',150,1998,'no',122),('Екатерина','Семенова','female','kate@ya.ru','Б12',370,1997,'yes',123),('Пистон','Блатной','male','piston@ya.ru','Б12',140,1968,'no',124),('Сергей','Сергеев','male','sergey2@ya.ru','Б12',198,1999,'no',125),('Евгений','Онопко','male','evgen@ya.ru','Б12',150,2001,'yes',126),('Сергей','Иванов','male','seregaga@ya.ru','ЫЧ134',205,1901,'yes',127),('Елена','Прекрасная','female','elena2@gmail.com','КРБ4',301,1989,'no',128),('Крестный','Отец','male','mafia@ya.ru','МТР42',438,1969,'yes',129),('Никита','Базаров','male','bazar@ya.ru','МТР42',99,1995,'no',130),('Аска','Евангелионова','female','ask@ya.ru','АНМ4',342,2001,'no',131),('Евгений','Подснежников','male','evgenius@ya.ru','АНМ4',140,1994,'no',132),('Александр','Иванов','male','sasha@ya.ru','АНМ4',180,1997,'yes',133),('Василий','Обломов','male','vasya2@ya.ru','3213',160,1999,'yes',134),('Гарик','Аганасян','male','garik2@ya.ru','3213',215,1998,'yes',135),('Саша','Черный','male','sanyablack@mail.ru','3213',256,1998,'yes',136),('Никита','Памбов','male','nikitos@ya.ru','3213',180,1994,'no',137),('Карина','Сычева','female','kariasha@ya.ru','3213',190,1999,'no',138),('Джон','Сноу','male','johny@ya.ru','3213',177,1997,'no',139),('Иван','Плющенко','male','ivan@ya.ru','ЫЧ134',152,1996,'no',140),('Никита','Михалков','male','nikitka@ya.ru','ЫЧ134',202,1995,'yes',141),('Святослав','Гуляев','male','gulyaev@ya.ru','АНМ4',233,1998,'yes',142),('Дана','Маслянкина','female','dana@ya.ru','Б12',289,1994,'no',143),('Артур','Мишечкин','male','artur@ya.ru','ЫЧ134',309,1997,'no',144),('Наташа','Туринова','female','natasha@ya.ru','Б12',291,2001,'yes',145),('Жора','Иванов','male','jora@ya.ru','Б12',304,2002,'no',146),('Виктор','Гостюхин','male','vitya@ya.ru','3213',389,2001,'no',147),('Даниил','Прокопенко','male','danila@ya.ru','ЫЧ134',188,1999,'yes',148),('Леонид','Сидоров','male','leonid@ya.ru','3213',170,2001,'yes',149),('Анна','Сысоева','female','anna2@ya.ru','ЫЧ134',192,1999,'yes',150),('Михаил','Потапов','male','mihail@ya.ru','ЫЧ134',213,2001,'yes',151),('Олег','Сергеев','male','oleg@ya.ru','ЫЧ134',115,1998,'no',152),('Иван','Сан Антуан Кристоф','male','ivan2@ya.ru','ЫЧ134',211,2000,'no',153),('Владимир','Петров','male','vladimir@ya.ru','АНМ4',162,1994,'no',154),('Олег','Мерзликин','male','olegolegoleg@ya.ru','АНМ4',102,1999,'no',155),('Диана','Юн','female','diana@ya.ru','3213',213,1998,'no',156),('Евгений','Юн','male','evgeny@ya.ru','3213',204,1998,'no',157),('Джеймс','О\'Генри','male','james@gmail.com','3213',232,1999,'no',158),('Иван','Иванов','male','ivangreat@ya.ru','ЫЧ134',100,1994,'no',159),('Сан Антуан Кристоф','Гулевич','male','antuan@ya.ru','ЫЧ134',172,1979,'no',160),('Дарья','Шульгина','female','darya@ya.ru','3213',213,1999,'yes',161),('Виталий','Виницын','male','wk@ya.ru','3213',104,1999,'no',162);
/*!40000 ALTER TABLE `abiturient` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-01 20:48:20
