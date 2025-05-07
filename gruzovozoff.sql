-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Май 07 2025 г., 04:07
-- Версия сервера: 5.7.44
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gruzovozoff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `dimensions` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date_time`, `weight`, `dimensions`, `cargo_type`, `from_address`, `to_address`, `status`, `created_at`) VALUES
(1, 2, '2023-12-15 14:00:00', 150.50, '2м x 1.5м x 1м', 'Мебель', 'г. Москва, ул. Ленина, д. 10', 'г. Москва, ул. Пушкина, д. 5', 'approved', '2025-05-06 19:10:53'),
(2, 3, '2023-12-16 10:30:00', 75.00, '1.5м x 1м x 0.5м', 'Бытовая техника', 'г. Санкт-Петербург, Невский пр., д. 20', 'г. Санкт-Петербург, ул. Гоголя, д. 15', 'approved', '2025-05-06 19:10:53'),
(3, 2, '2023-12-20 09:00:00', 200.00, '3м x 2м x 1.5м', 'Строительные материалы', 'г. Москва, ул. Строителей, д. 25', 'г. Москва, ул. Садовая, д. 30', 'rejected', '2025-05-06 19:10:53'),
(6, 2, '2023-12-20 09:00:00', 200.00, '3м x 2м x 1.5м', 'Строительные материалы', 'г. Москва, ул. Строителей, д. 25', 'г. Москва, ул. Садовая, д. 30', 'rejected', '2025-05-06 19:11:27'),
(7, 2, '2025-05-09 02:58:00', 100.00, '2м', 'Мебель', 'Тюмень', 'Москва', 'rejected', '2025-05-06 22:30:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `phone`, `email`, `created_at`) VALUES
(1, 'admin', 'gruzovik2024', 'Администратор системы', '+7(999)-999-99-99', 'admin@gruzovozoff.ru', '2025-05-06 19:10:53'),
(2, 'иванов', 'пароль123', 'Иванов Иван Иванович', '+7(123)-456-78-90', 'ivanov@example.com', '2025-05-06 19:10:53'),
(3, 'петров', 'qwerty', 'Петров Петр Петрович', '+7(987)-654-32-10', 'petrov@example.com', '2025-05-06 19:10:53'),
(4, 'крузак', '112233', 'Винник Кирилл Михайлович', '+7(912)-383-08-20', 'zxcone@inbox.ru', '2025-05-06 21:45:28'),
(5, 'кирилл', '112233', 'Винник Кирилл Михайлович', '+7(912)-383-08-20', 'zxcone@inbox.ru', '2025-05-06 21:46:37'),
(6, 'павпвап', 'павпвапва', 'Винник Кирилл Михайлович', '+7(912)-383-08-20', 'zxcone@inbox.ru', '2025-05-06 21:48:53'),
(50, 'Грузовик', '112233', 'Тужилов Никита Александрович ', '+7(908)-000-00-00', 'zxc@inbox.ru', '2025-05-06 21:50:36');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date_time` (`date_time`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
