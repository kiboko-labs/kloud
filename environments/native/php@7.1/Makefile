export REPOSITORY = kiboko/php

ifndef VERSION
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: cli cli-blackfire cli-xdebug fpm fpm-blackfire fpm-xdebug

.PHONY: cli
cli:
	$(MAKE) -C $@ push

.PHONY: cli-blackfire
cli-blackfire: cli
	$(MAKE) -C $@ push

.PHONY: cli-xdebug
cli-xdebug: cli
	$(MAKE) -C $@ push

.PHONY: fpm
fpm:
	$(MAKE) -C $@ push

.PHONY: fpm-blackfire
fpm-blackfire: fpm
	$(MAKE) -C $@ push

.PHONY: fpm-xdebug
fpm-xdebug: fpm
	$(MAKE) -C $@ push

.PHONY: clean
clean:
	$(MAKE) -C cli $@
	$(MAKE) -C cli-blackfire $@
	$(MAKE) -C cli-xdebug $@
	$(MAKE) -C fpm $@
	$(MAKE) -C fpm-blackfire $@
	$(MAKE) -C fpm-xdebug $@
