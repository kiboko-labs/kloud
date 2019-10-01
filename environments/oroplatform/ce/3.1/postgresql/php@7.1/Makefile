export REPOSITORY = kiboko/php

ifndef VERSION
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))
endif

.PHONY: all
all:
	$(MAKE) -j8 -j8 -C cli push
	$(MAKE) -j8 -j8 -C cli-xdebug push
	$(MAKE) -j8 -j8 -C cli-blackfire push
	$(MAKE) -j8 -j8 -C fpm push
	$(MAKE) -j8 -j8 -C fpm-xdebug push
	$(MAKE) -j8 -j8 -C fpm-blackfire push

