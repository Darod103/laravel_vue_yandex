
up-dev:
	docker compose -f docker-compose.dev.yml up -d

down-dev:
	docker compose -f docker-compose.dev.yml down
bash-dev:
	docker exec -it laravel_app_dev sh
