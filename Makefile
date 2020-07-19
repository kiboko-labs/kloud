
RED=033[31m
GREEN=033[32m
YELLOW=033[33m
BLUE=033[34m
PURPLE=033[35m
CYAN=033[36m
GREY=033[37m
NC=033[0m

KLOUD=docker-compose exec sh php bin/kloud

#build/kloud.phar:
#	bin/build

#.PHONY: build
#build: build/kloud.phar

.PHONY: php-5.6
php-5.6: ## Build all possible images for PHP 5.6
php-5.6:
	$(KLOUD) build --regex='/^5\.6-/' --force-all --push

.PHONY: php-7.1
php-7.1: ## Build all possible images for PHP 7.1
php-7.1:
	$(KLOUD) build --regex='/^7\.1-/' --force-all --push

.PHONY: php-7.2
php-7.2: ## Build all possible images for PHP 7.2
php-7.2:
	$(KLOUD) build --regex='/^7\.2-/' --force-all --push

.PHONY: php-7.3
php-7.3: ## Build all possible images for PHP 7.3
php-7.3:
	$(KLOUD) build --regex='/^7\.3-/' --force-all --push

.PHONY: php-7.4
php-7.4: ## Build all possible images for PHP 7.4
php-7.4:
	$(KLOUD) build --regex='/^7\.4-/' --force-all --push

.PHONY: all
all: ## Build all possible images
all:
	$(KLOUD) build --regex='/^\d+\.\d+/' --force-all --push

.DEFAULT_GOAL := help

.PHONY: help
help: ## Show this help
help:
	@echo "\n\${BLUE}usage: make \${GREEN}target [ ...target ]\${NC}"
	@grep -E '(^[a-zA-Z0-9_.-]+:.*?##.*$$)|(^##)' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\${GREEN}%-30s\${NC} %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
