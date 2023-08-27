include .env

MYSQL_DUMPS_DIR=./.shared/

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "up: starta os containers docker"
	@echo "down: para os containers docker"
	@echo "roda: os testes automatizados"
	@echo "back: acessa o container do backend"
	@echo "frontend: acessa o container do frontend"
	@echo "restore: restaura o banco de dados"
	@echo "backup: cria o backup do banco de dados"

up: 
	docker compose up -d
down: 
	docker compose down
test: 
	docker compose exec app php artisan test
back: 
	docker compose exec app bash
frontend:
	docker compose exec my_frontend bash
initbanco:
	docker exec -i $(shell docker-compose ps -q db) mysql -u"$(MYSQL_USER)" -p"$(MYSQL_ROOT_PASSWORD)" < $(MYSQL_DUMPS_DIR)dbtest.sql 2>/dev/null
restore:
	docker exec -i $(shell docker-compose ps -q db) mysql -u"$(MYSQL_USER)" -p"$(MYSQL_ROOT_PASSWORD)" < $(MYSQL_DUMPS_DIR)db.sql 2>/dev/null
gerabackup:
	docker exec $(shell docker-compose ps -q db) mysqldump --all-databases -u"$(MYSQL_USER)" -p"$(MYSQL_ROOT_PASSWORD)" > $(MYSQL_DUMPS_DIR)db.sql 2>/dev/null

