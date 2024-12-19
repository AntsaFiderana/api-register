liste commande et explication
dans terminal pour entrer dans le conteneur du projet: 
docker exec -it myapi bash

dans le conteneur du projet:
composer remove caouecs/laravel-lang

dans le conteneur du projet:
composer clear-cache

dans le conteneur du projet:
composer require darkaonline/l5-swagger

dans le conteneur du projet:
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

apres modification de chaque controller:
php artisan l5-swagger:generate

pour ajouter swagger a chaque controller : regarder app/Http/Controllers/UserCtrl

lien regarder swagger : http://localhost:8000/api/documentation
