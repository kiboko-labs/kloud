export REPOSITORY = kiboko/php
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: build
build:
	$(MAKE) -C cli build
	$(MAKE) -C cli-xdebug build
	$(MAKE) -C cli-blackfire build
	$(MAKE) -C fpm build
	$(MAKE) -C fpm-xdebug build
	$(MAKE) -C fpm-blackfire build

.PHONY: push
push:
	$(MAKE) -C cli push
	$(MAKE) -C cli-xdebug push
	$(MAKE) -C cli-blackfire push
	$(MAKE) -C fpm push
	$(MAKE) -C fpm-xdebug push
	$(MAKE) -C fpm-blackfire push

