# Интернет-магазин Медуса

### Проект для сайта: http://meduca.site.
Этот проект представляет собой интернет-магазин, разработанный с использованием фреймворка Laravel/PHP и JavaScript. Проект разработан в учебных целях для изучения и закрепления принципов MVC (Model-View-Controller) архитектуры.

## Описание проекта

Интернет-магазин представляет собой веб-приложение, которое позволяет пользователям просматривать каталог товаров, добавлять товары в корзину, оформлять заказы и т.д. Проект реализует основные функциональности типичного интернет-магазина.

## Технологии

- Laravel: Фреймворк PHP для создания веб-приложений с использованием архитектурного шаблона MVC.
- PHP: Язык программирования, используемый для написания бэкенд-части приложения.
- JavaScript: Язык программирования, используемый для создания интерактивных элементов пользовательского интерфейса.
- MySQL: Реляционная база данных, используемая для хранения данных о продуктах, заказах и пользователях.
- PHPWord: Библиотека PHP для работы с документами формата .docx, используемая для формирования и сохранения файлов заказов.

## Функциональности

1. Регистрация и аутентификация пользователей.
2. Просмотр каталога товаров.
3. Добавление товаров в корзину и избранное.
   - Реализована функциональность корзины товаров с использованием куков. Куки создаются через JavaScript на клиентской стороне и для авторизованных пользователей отлавливаются на бэкенде, где сохраняются в хранилище Redis для обеспечения надежного хранения информации о корзине и обработки заказов.
4. Оформление заказа.
5. Управление товарами (добавление, удаление, редактирование).
6. Управление заказами (просмотр, изменение статуса).
7. Поиск по товарам.
8. Формирование и сохранение файлов в формате .docx для заказов.
9. Личный кабинет пользователя с возможностью просмотра истории заказов
