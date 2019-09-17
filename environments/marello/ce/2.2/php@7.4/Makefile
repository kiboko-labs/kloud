export REPOSITORY = kiboko/php
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C cli push
	$(MAKE) -C cli-xdebug push
	$(MAKE) -C fpm push
	$(MAKE) -C fpm-xdebug push

