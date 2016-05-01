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
  `token` varchar(32) NOT NULL,
  PRIMARY KEY (`abiturientID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abiturient`
--

LOCK TABLES `abiturient` WRITE;
/*!40000 ALTER TABLE `abiturient` DISABLE KEYS */;
INSERT INTO `abiturient` VALUES ('Васька','Пупкин','male','one2@ya.ru','123',100,1994,'yes',102,'kpcqFo3OuB3AbTL3UNwfb6V6przUBlPJ'),('Васька','Пупкин','male','one@ya.ru','123',100,1994,'yes',103,'kmVwh4KP9tOeJsAXp2GF5sxyW232zpCc'),('Петька','Пупкин','male','two@ya.ru','123',200,1994,'yes',104,'3JgaktLYG5R9YaaIHMb8n7LOEUjJgubP'),('Саня','Белый','male','sanyawhite@mail.ru','90',50,1960,'yes',105,'9csgDr4pAdeJIjFl5Cv4ALiTIfM1i7pa'),('Маша','Ктулхова','female','masha@ya.ru','3213',400,1992,'yes',106,'vnEgCv5ieGLF7IJLtTFpJ6eCi2Y81LoI'),('Маша','Сайхилова','female','masha2@ya.ru','1345',340,1993,'yes',107,'fuPo5P0vGcPYmk4Jo7YQvgTv3FHkEcLq'),('Павел','Маслянкин','male','pavel@mail.ru','48151',323,1997,'no',108,'2rvDQyQ5K7Xgs45EGKRHu6OQNfMh1Ac8'),('Елена','Полено','female','elena@rambler.com','2А3Б',246,2000,'no',109,'mFGSYXtsGHcHYhwG6abPJeBJGNJztmZs'),('Джек','Воробей','male','jacksparrow@gmail.com','КРБ4',40,1989,'no',110,'F3kXz6IAImwuratKD25c2x06BSIdJ4ed'),('Никита','Базаров','male','nikita@ya.ru','АНМ4',210,1995,'yes',111,'d3GXyxidxS1rL8K4GUMpw6U1H03gS37H'),('Александр','Пушкин','male','sanya05rus@ya.ru','Б12',370,2001,'no',112,'zmjXlmMS9UShyPxlDuwSzWJmwkhOMgGi'),('Сергей','Грызлов','male','sergey@ya.ru','МТР42',360,1998,'no',114,'Ww9vKkqo4NwlMw1TeawEtNyOvKHWIKdN'),('Маша','Вичхаусова','female','osnova@ya.ru','абв32',246,1999,'no',115,'kiQfsHNHvB90SflCXKznGtc3Y2geN3eD'),('Анон','Пхптредов','male','iphonetask@ya.ru','2ч',370,1998,'yes',116,'On9xsDlBvDEH4kH2iOkPgityFj6BOlUY'),('Анна','Свечкарева','female','anna@ya.ru','ЫЧ134',180,2000,'no',117,'zAKQ289Qy1ilLy3nwpzectBqVhCZtd1u'),('Георгий','Смертин','male','georg@ya.ru','МТР42',402,1998,'yes',118,'8OR26wwo7U3c3GofEwfuTbZwZLBupsHM'),('Сенпай','Каваев','male','kavaiii@ya.ru','АНМ4',210,1999,'no',119,'EeIJrXwsLW33dHQXLQIPQfLnrUU7O5aR'),('Марина','Киркорова','female','marinalove@ya.ru','ЫЧ134',221,1999,'no',120,'4dz66hVO3y8jeH2CC1lyUuaIPXEMUrmT'),('Списал','Хорошо','male','minobrrf@ya.ru','ЫЧ134',450,1997,'no',121,'8mE2DfkmWrUzXadPIotrdjMJuaJOkgSs'),('Мяу','Мурмяу','female','meow@gmail.com','ЫЧ134',150,1998,'no',122,'L13KOWbCWBMZ4z9MQDz9HtoCDjNO8tsF'),('Екатерина','Семенова','female','kate@ya.ru','Б12',370,1997,'yes',123,'Bg8CZx23lWNoaAszclsjOcfuOAVqjNSd'),('Пистон','Блатной','male','piston@ya.ru','Б12',140,1968,'no',124,'bsw65ESOBJ9QB4Z8CiXXnkNRgh9m9JJU'),('Сергей','Сергеев','male','sergey2@ya.ru','Б12',198,1999,'no',125,'1hr5iL2PLCdjgPlgR7YA6fET6mdGD2nE'),('Евгений','Онопко','male','evgen@ya.ru','Б12',150,2001,'yes',126,'Ew67prNIiFFfCAEhvkW7EpHKb4teWUHC'),('Сергей','Иванов','male','seregaga@ya.ru','ЫЧ134',205,1901,'yes',127,'lAEa7Xq9PVbVKifCwsK0KXXdyoidOiuD'),('Елена','Прекрасная','female','elena2@gmail.com','КРБ4',301,1989,'no',128,'9txmIDQo44agjW6OllDsbuut2RnC0yBg'),('Крестный','Отец','male','mafia@ya.ru','МТР42',438,1969,'yes',129,'35ApXRL5HspU2ka5DYDByQkOVPiTFqYA'),('Никита','Базаров','male','bazar@ya.ru','МТР42',99,1995,'no',130,'O1FL4Udzh7QaIQe1AuiQKt23pYO49Drb'),('Аска','Евангелионова','female','ask@ya.ru','АНМ4',342,2001,'no',131,'IsvL46MPj0VtyJBR61IzxUNywKkBnYDe'),('Евгений','Подснежников','male','evgenius@ya.ru','АНМ4',140,1994,'no',132,'51BDShpE1E2xyILcIzJjUqoxjnpkCRHm'),('Александр','Иванов','male','sasha@ya.ru','АНМ4',180,1997,'yes',133,'I4iCg6fFVjX8Y2Ba6a24xWeTC24jw8x2'),('Василий','Обломов','male','vasya2@ya.ru','3213',160,1999,'yes',134,'AswIm0VzegXzHyzHYMNWVhtHS2KaECLT'),('Гарик','Аганасян','male','garik2@ya.ru','3213',215,1998,'yes',135,'wjI92qqiQGuUsTgo9TLTILRdUe0SXcJ7'),('Саша','Черный','male','sanyablack@mail.ru','3213',256,1998,'yes',136,'Ejznwn9LKBRRlqdJ4AA0fuevnLBRowLF'),('Никита','Памбов','male','nikitos@ya.ru','3213',180,1994,'no',137,'DusLIC4xFoA861JZIdgPftS4Rv4ixZl4'),('Карина','Сычева','female','kariasha@ya.ru','3213',190,1999,'no',138,'BtnFRfKzguX0Z96gxgU9A4mPqmQbvpsY'),('Джон','Сноу','male','johny@ya.ru','3213',177,1997,'no',139,'lxKUggT0afZaEPZgcYGj5N3cBK2LxTxF'),('Иван','Плющенко','male','ivan@ya.ru','ЫЧ134',152,1996,'no',140,'F1AOKiTCs1uqBBC0Qj6DMuVplrR7hm6J'),('Никита','Михалков','male','nikitka@ya.ru','ЫЧ134',202,1995,'yes',141,'QcIHaQxy67U7vy8b3X1LMIckc2mBHQH8'),('Святослав','Гуляев','male','gulyaev@ya.ru','АНМ4',233,1998,'yes',142,'fop0jikHWBN4SCYCdJYPD05sTJQ7SWcP'),('Дана','Маслянкина','female','dana@ya.ru','Б12',289,1994,'no',143,'pL7K71LXB9h8YB7s7LrSkikXz2tSuvIq'),('Артур','Мишечкин','male','artur@ya.ru','ЫЧ134',309,1997,'no',144,'pfCbiPhW8FyBwsk9oqzZIY9EE7CGuHXR'),('Наташа','Туринова','female','natasha@ya.ru','Б12',291,2001,'yes',145,'NMrDDoiijnZqpZfTiM7xUSJ5yzwf3tJp'),('Жора','Иванов','male','jora@ya.ru','Б12',304,2002,'no',146,'rxB4iHifKyruc9vC9NOEOXx8qH0Wmxjv'),('Виктор','Гостюхин','male','vitya@ya.ru','3213',389,2001,'no',147,'ILbu8z8kWaMRyslFoWtBHpKW0WR05DO9'),('Даниил','Прокопенко','male','danila@ya.ru','ЫЧ134',188,1999,'yes',148,'9tGBXOLbWp3d5308svJ6tni0RbEGLD4n'),('Леонид','Сидоров','male','leonid@ya.ru','3213',170,2001,'yes',149,'dU86L7Aq70H1YeCVvTN74vbvgBb7Iu8g'),('Анна','Сысоева','female','anna2@ya.ru','ЫЧ134',192,1999,'yes',150,'xFcWS6n1zY1pfd4r68WF4E4uofyPqZo2'),('Михаил','Потапов','male','mihail@ya.ru','ЫЧ134',213,2001,'yes',151,'Xqlzh2CpyAYIE87TT7Z2Eg8oBfPGWfOS'),('Олег','Сергеев','male','oleg@ya.ru','ЫЧ134',115,1998,'no',152,'EbwPLQFacroIQmGbtOEDW0uh2VvubA6A'),('Иван','Сан Антуан Кристоф','male','ivan2@ya.ru','ЫЧ134',211,2000,'no',153,'UUWaHDWw64YsCFOs9CchClAPkyBQlJMb'),('Владимир','Петров','male','vladimir@ya.ru','АНМ4',162,1994,'no',154,'dmjyVNH3paQwm0N0t4OdUKEFm2Pn3dkQ'),('Олег','Мерзликин','male','olegolegoleg@ya.ru','АНМ4',102,1999,'no',155,'N8cEMMymK66lUQusechQGCeJ7YsBLdpO'),('Диана','Юн','female','diana@ya.ru','3213',213,1998,'no',156,'6gka6eA9CH6pzchCVtXzQy1AGZ0mphRu'),('Евгений','Юн','male','evgeny@ya.ru','3213',204,1998,'no',157,'rMMeVfCT20nJJ8KiXXbzfpyQCcyFnbQO'),('Джеймс','О\'Генри','male','james@gmail.com','3213',232,1999,'no',158,'aXrIGgGoLD3txLpkecr7OG25rZMX9Or5'),('Иван','Иванов','male','ivangreat@ya.ru','ЫЧ134',100,1994,'no',159,'ys2S6KCm8KDnDuoLhSOaIY6daIv26taj'),('Сан Антуан Кристоф','Гулевич','male','antuan@ya.ru','ЫЧ134',172,1979,'no',160,'AtANF2aC2I86T4mnSXnELanL3PE94dJf'),('Дарья','Шульгина','female','darya@ya.ru','3213',213,1999,'yes',161,'skIdKpGYTi4Hgbg2Wc2BTijZmPylGRdc'),('Виталий','Виницын','male','wk@ya.ru','3213',104,1999,'no',162,'czQHnwWc9znp4dfxigFReY3ypGyh6IYg'),('Иван','ИвановИван Иванов Иван','male','ivan333@ya.ru','ЫЧ134',1,1901,'no',171,'oR46flfvUGoE3n7p8l6XLZJbiEQ7dHOq');
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

-- Dump completed on 2016-04-30 22:15:07
