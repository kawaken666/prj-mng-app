up:
	docker compose up -d
build:
	docker compose build --no-cache --force-rm
laravel-install:
	docker compose exec app composer create-project --prefer-dist laravel/laravel="9.*" .
install-recommend-packages:
	docker compose exec app composer require doctrine/dbal
	docker compose exec app composer require --dev ucan-lab/laravel-dacapo
	docker compose exec app composer require --dev barryvdh/laravel-ide-helper
	docker compose exec app composer require --dev beyondcode/laravel-dump-server
	docker compose exec app composer require --dev barryvdh/laravel-debugbar
	docker compose exec app composer require --dev roave/security-advisories:dev-master
	docker compose exec app php artisan vendor:publish --provider="BeyondCode\DumpServer\DumpServerServiceProvider"
	docker compose exec app php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
init:
	cp .env.example .env
	docker compose up -d --build
	docker compose exec app composer install
	docker compose exec app cp .env.example .env
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec app chown -R www-data:www-data storage bootstrap/cache
	docker compose exec app chmod -R 775 storage bootstrap/cache
	docker compose exec app yarn install
	docker compose exec app yarn build
	yarn install
	@make fresh
remake:
	@make destroy
	@make init
dev:
	docker compose exec app yarn dev
stop:
	docker compose stop
down:
	docker compose down --remove-orphans
restart:
	@make down
	@make up
destroy:
	docker compose down --rmi all --volumes --remove-orphans
destroy-volumes:
	docker compose down --volumes --remove-orphans
app:
	docker compose exec app bash
db:
	docker compose exec db bash
sql:
	docker compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
sql-testing:
	docker compose exec db-testing bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD testing'
sql-root:
	docker compose exec db bash -c 'mysql -u root -p'
migrate:
	docker compose exec app php artisan migrate
fresh:
	docker compose exec app php artisan migrate:fresh --seed
seed:
	docker compose exec app php artisan db:seed
tinker:
	docker compose exec app php artisan tinker
test:
	docker compose exec app php artisan test
rollback-test:
	docker compose exec app php artisan migrate:refresh
clear:
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan view:clear
autoload:
	docker compose exec app composer dump-autoload
ide-generate:
	docker compose exec app php artisan ide-helper:generate