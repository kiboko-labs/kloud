export REPOSITORY = kiboko/php

ifndef VERSION
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))
endif

.PHONY: all
all:
	$(MAKE) -C cli push
	$(MAKE) -C cli-xdebug push
	$(MAKE) -C cli-blackfire push
	$(MAKE) -C fpm push
	$(MAKE) -C fpm-xdebug push
	$(MAKE) -C fpm-blackfire push

