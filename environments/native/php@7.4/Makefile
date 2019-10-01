export REPOSITORY = kiboko/php

ifndef VERSION
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: cli cli-xdebug fpm fpm-xdebug

.PHONY: cli
cli:
	$(MAKE) -j8 -C $@ push

.PHONY: cli-xdebug
cli-xdebug: cli
	$(MAKE) -j8 -C $@ push

.PHONY: fpm
fpm:
	$(MAKE) -j8 -C $@ push

.PHONY: fpm-xdebug
fpm-xdebug: fpm
	$(MAKE) -j8 -C $@ push

.PHONY: clean
clean:
	$(MAKE) -j8 -C cli $@
	$(MAKE) -j8 -C cli-xdebug $@
	$(MAKE) -j8 -C fpm $@
	$(MAKE) -j8 -C fpm-xdebug $@
