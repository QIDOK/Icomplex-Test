DC = docker-compose
ARTISAN = $(DC) exec app php artisan

build:
	$(DC) up -d
	sleep 10s
	make migrate
	make storage-link
	make start

down:
	make stop
	$(DC) rm -sfv
	docker image prune -af

rebuild:
	make down
	sleep 5s
	make build

start:
	$(DC) start
	make permission-refresh
	$(DC) exec app npm run dev

stop:
	$(DC) stop

restart:
	make stop
	make start

logs:
	$(DC) logs -f

migrate:
	$(ARTISAN) migrate

migrate-rollback:
	$(ARTISAN) migrate:rollback

seed:
	$(ARTISAN) db:seed

app-shell:
	$(DC) exec app bash

ps:
	$(DC) ps

composer-install:
	$(DC) exec app composer install

composer-update:
	$(DC) exec app composer update

test:
	$(ARTISAN) test

cache-clear:
	$(ARTISAN) cache:clear

refresh:
	$(ARTISAN) migrate:refresh
	$(ARTISAN) db:seed

permission-refresh:
	$(DC) exec app chown -R www-data:www-data /var/www/html
	$(DC) exec app chmod -R 775 /var/www/html/storage
	$(DC) exec app chmod -R 775 /var/www/html/bootstrap/cache

storage-link:
	$(ARTISAN) storage:link

help:
	@echo "Доступные команды:"
	@echo "  build              Собрать все контейнеры"
	@echo "  down               Удалить все контейнеры"
	@echo "  rebuild            Пересобрать все контейнеры"
	@echo "  start           	Запустить все контейнеры"
	@echo "  stop            	Остановить все контейнеры"
	@echo "  logs               Просмотреть логи контейнеров в реальном времени"
	@echo "  migrate            Выполнить миграции базы данных"
	@echo "  migrate-rollback   Откатить последнюю миграцию базы данных"
	@echo "  seed               Заполнить базу данных данными"
	@echo "  app-shell          Войти в интерактивную оболочку контейнера приложения"
	@echo "  ps                 Показать список запущенных контейнеров"
	@echo "  composer-install   Установить зависимости Composer"
	@echo "  composer-update    Обновить зависимости Composer"
	@echo "  test               Запустить тесты приложения"
	@echo "  cache-clear        Очистить кэш приложения"
	@echo "  refresh            Пересоздать базу данных и заполнить данными"
	@echo "  permission-refresh Восстановить права файлов и папок"
	@echo "  storage-link		Генерация ссылки хранилища"

.DEFAULT_GOAL := help
