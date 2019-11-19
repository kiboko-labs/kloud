##
## Makefile
##
include .env
export

RED=033[31m
GREEN=033[32m
YELLOW=033[33m
BLUE=033[34m
PURPLE=033[35m
CYAN=033[36m
GREY=033[37m
NC=033[0m

DOCKER-COMPOSE=docker-compose

DOCKER-EXEC=$(DOCKER-COMPOSE) exec

SH=$(DOCKER-EXEC) sh /bin/sh
CONSOLE=$(DOCKER-EXEC) sh bin/console
COMPOSER=$(DOCKER-EXEC) sh composer
SERVICES=elasticsearch dejavu sql amqp redis http http-dev http-xdebug mail fpm fpm-xdebug sh sh-xdebug

.env:
	cp .env.dist .env

update-containers: ## Pull last images and launch
update-containers: .env pull start

.PHONY: start
start: ## Launch docker services
start: .env
	@echo "\${BLUE}- Lauching docker\${NC}"
	$(DOCKER-COMPOSE) up -d $(SERVICES)

.PHONY: start-mq
start-mq: ## Launch docker MQ worker service
start-mq: .env
	@echo "\${BLUE}- Lauching docker\${NC}"
	$(DOCKER-COMPOSE) up -d mq
	$(MAKE) amqp-management

.PHONY: start-ws
start-ws: ## Launch docker WS service
start-ws: .env
	@echo "\${BLUE}- Lauching docker\${NC}"
	$(DOCKER-COMPOSE) up -d ws

.PHONY: stop
stop: ## Stop docker services
stop: .env
	@echo "\${BLUE}- Stopping docker\${NC}"
	$(DOCKER-COMPOSE) stop

.PHONY: pull
pull: ## Pull latest images for docker services
pull: .env
	$(DOCKER-COMPOSE) pull

.PHONY: clean
clean: ## Clean project.
clean: .env start
	@echo "\${BLUE}- Cleaning project\${NC}"
	$(SH) -c "/usr/bin/env rm -Rf app/cache vendor composer.lock && git checkout composer.lock"

platform-update: ## Execute platform application update commands and init platform assets.
platform-update: .env start
	@echo "\${BLUE}- Executing platform application update\${NC}"
	$(CONSOLE) oro:platform:update --force --symlink --env=prod -vvv --timeout=0

.PHONY: cache-clear
cache-clear: ## Clear cache
cache-clear:
	@echo "\${YELLOW}- Clearing PROD cache\${NC}"
	$(CONSOLE) cache:clear --env=prod

.PHONY: cache-clear-dev
cache-clear-dev: ## Clear cache
cache-clear-dev:
	@echo "\${YELLOW}- Clearing DEV cache\${NC}"
	$(CONSOLE) cache:clear --env=dev

.PHONY: cache-warmup
cache-warmup: ## Warmup cache
cache-warmup:
	@echo "\${YELLOW}- Warming up PROD cache\${NC}"
	$(CONSOLE) cache:warmup --env=prod

.PHONY: cache-warmup-dev
cache-warmup-dev: ## Warmup cache
cache-warmup-dev:
	@echo "\${YELLOW}- Warming up DEV cache\${NC}"
	$(CONSOLE) cache:warmup --env=dev

.PHONY: install
install: ## Install OroCommerce
install: vendor start
	@echo "\${YELLOW}- Installing OroCommerce\${NC}"
	$(CONSOLE) oro:install \
		--application-url=http://127.0.0.1:8000 \
		--env=prod \
		--organization-name="Kiboko" \
		--user-name=admin \
		--user-email=hello@kiboko.fr \
		--user-firstname=Hippo \
		--user-lastname=Potamus \
		--user-password=password \
		--language=en \
		--formatting-code=en \
		--symlink \
		--timeout=0

.PHONY: uninstall
uninstall: ## Uninstall OroCommerce
uninstall: start
	@echo "\${YELLOW}- Uninstalling OroCommercd\${NC}"
	$(SH) -c "rm -rf var/cache/*"
	$(SH) -c "php -r \"use Symfony\Component\Yaml\Yaml;require 'vendor/autoload.php';\$$data = Yaml::parseFile('config/parameters.yml');\$$data['parameters']['installed'] = null;file_put_contents('config/parameters.yml', Yaml::dump(\$$data));\"

.PHONY: reinstall
reinstall: ## Reinstall OroCommerce
reinstall: vendor uninstall start
	@echo "\${YELLOW}- Reinstalling OroCommercd\${NC}"
	$(CONSOLE) oro:install \
		--application-url=http://127.0.0.1:8000 \
		--env=prod \
		--organization-name="Kiboko" \
		--user-name=admin \
		--user-email=hello@kiboko.fr \
		--user-firstname=Hippo \
		--user-lastname=Potamus \
		--user-password=password \
		--language=en \
		--formatting-code=en \
		--symlink \
		--timeout=0 \
		--drop-database

vendor: composer.json composer.lock start
	@echo "\${BLUE}- Installing composer dependencies\${NC}"
	$(COMPOSER) install

.PHONY: amqp-management
amqp-management:
	@echo "\${BLUE}- Enabling RabbitMQ manager\${NC}"
	$(DOCKER-EXEC) amqp rabbitmq-plugins enable rabbitmq_management

.DEFAULT_GOAL := help

.PHONY: help
help: ## Show this help
help:
	@echo "\n\${BLUE}usage: make \${GREEN}command [...command]\${NC}"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
