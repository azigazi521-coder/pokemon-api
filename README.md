# Laravel Pokemon API

Prosta aplikacja API w Laravel 12 do zarządzania Pokemonami, w tym zakazanymi i customowymi.

## Wymagania

- PHP >= 8.2
- Composer
- SQLite (lub inna baza danych)
- Laravel 12

## Instalacja

1. Sklonuj repozytorium:
git clone https://github.com/azigazi521-coder/pokemon-api.git
cd pokemon-api

composer install

cp .env.example .env

touch database/database.sqlite

php artisan migrate

php artisan serve

Serwis dostępny pod: http://127.0.0.1:8000

Rozpiska endpointów:
dodałem plik pokemon-api.yaml do importu na stronie https://editor.swagger.io/  -> File -> Import File

dodałem również eksport kolekcji z postmana w pliku Pokemon.postman_collection.json



