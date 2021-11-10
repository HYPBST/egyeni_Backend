-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Nov 03. 20:59
-- Kiszolgáló verziója: 10.4.17-MariaDB
-- PHP verzió: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `telefonok`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telefon`
--

CREATE TABLE `telefon` (
  `id` int(11) NOT NULL,
  `gyarto` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `modell` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tarhely` int(20) NOT NULL,
  `memoria` int(20) NOT NULL,
  `kiadas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `telefon`
--

INSERT INTO `telefon` (`id`, `gyarto`, `modell`, `tarhely`, `memoria`, `kiadas`) VALUES
(1, 'Apple', 'Xs Max', 126, 16, '2021-11-02'),
(2, 'Samsung', 'Galaxy S10', 64, 8, '2021-11-01'),
(41, 'asdasd', 'asdasd', 12, 123, '2021-11-03');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `telefon`
--
ALTER TABLE `telefon`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `telefon`
--
ALTER TABLE `telefon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
