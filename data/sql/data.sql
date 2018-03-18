-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Czas generowania: 18 Mar 2018, 11:36
-- Wersja serwera: 5.7.20
-- Wersja PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Baza danych: `db_1`
--

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id`, `name`) VALUES
(1, 'product 1'),
(2, 'product 2');
COMMIT;
