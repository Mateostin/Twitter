-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 21 Sty 2018, 11:17
-- Wersja serwera: 5.7.20-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comments`
--

CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `creationDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Comments`
--

INSERT INTO `Comments` (`comment_id`, `user_id`, `tweet_id`, `text`, `creationDate`) VALUES
(1, 37, 52, 'A tutaj Testowy Komentarz !!! :D', '2018-01-10 20:31:40'),
(2, 37, 52, 'Jeszcze jeden! 😜😜👌', '2018-01-10 20:32:01'),
(3, 37, 53, 'Linki też działają ', '2018-01-10 20:34:27'),
(4, 39, 54, 'asdfasdfasdfa', '2018-01-14 08:56:49');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE `Messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `status` varchar(2) COLLATE utf8_polish_ci DEFAULT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Messages`
--

INSERT INTO `Messages` (`message_id`, `sender_id`, `receiver_id`, `text`, `status`, `creationDate`) VALUES
(1, 40, 39, 'asdfasdfasdfasdf', '0', '2018-01-14 08:59:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweet`
--

CREATE TABLE `Tweet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  `creationDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Zrzut danych tabeli `Tweet`
--

INSERT INTO `Tweet` (`id`, `user_id`, `text`, `creationDate`) VALUES
(52, 37, 'Testowy Tweet !!! :) 🙈', '2018-01-10 20:31:26'),
(53, 37, 'https://www.youtube.com/channel/UCdTnQ5I4SgDNc4aXEeyUIEA', '2018-01-10 20:34:04'),
(54, 39, '❤️😜', '2018-01-14 08:56:43');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `secondname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `hash_pass` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `avatar` varchar(200) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `email`, `firstname`, `secondname`, `hash_pass`, `avatar`) VALUES
(37, 'mat.lipecki@gmail.com', 'Mateusz', 'Lipecki', '$2y$10$Et2zK8LYxpBYJRGl4oB92uTbjZYwDqTnX6h/4FiK66hAOmVtH8yCa', 'user_avatars/customavatar.png'),
(38, 'test@o2.pl', 'Testowy', 'Uzytkownik', '$2y$10$HzolBn/N.0nRAIV/.q4ojOs//ubjeGZfTlPecRy8.gmpqa2XLiej2', 'user_avatars/customavatar.png'),
(39, 'aaa@o2.pl', 'Bskfgsg', 'Sdfgsdf', '$2y$10$T75ud7J.Y.xl6qq3DExTcOi8brusfrcaq88lkFkAawOqox9KEgPwS', 'user_avatars/indeks.jpeg'),
(40, 'aaaa@o2.pl', 'Ggsdgsd', 'Gsdgsdfd', '$2y$10$mCVGG5haAbTu.ILaCZxCmOhJ/CF.xwuLEI1MbW7fCJtxmMtfaZwHG', 'user_avatars/customavatar.png');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `tweet_id` (`tweet_id`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `Tweet`
--
ALTER TABLE `Tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Comments`
--
ALTER TABLE `Comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `Messages`
--
ALTER TABLE `Messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT dla tabeli `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `Tweet` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
