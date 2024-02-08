include .env
build:
	composer install
	cp .env.example .env
	php artisan key:generate
	docker stop $$(docker ps -aq)
	docker-compose build
	docker network create proxynet
	docker exec -it ${PROJECT_NAME}_app bash -c "php artisan storage:link"
	exit
	@echo "\033[0;32mBuild done\033[0m"
run:
	docker-compose up -d
	@echo "\033[0;32mDone\033[0m"
stop:
	docker-compose down
	@echo "\033[0;32mDone\033[0m"
import-db:
	@read -p "Enter the path to your SQL file: " SQL_FILE_PATH; \
	docker exec -i ${DB_HOST} mysql -u root -proot ${DB_DATABASE} < $$SQL_FILE_PATH; \
	echo "\033[0;32mDone\033[0m"
