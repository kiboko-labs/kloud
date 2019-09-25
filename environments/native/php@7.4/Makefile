export REPOSITORY = kiboko/php
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all: cli cli-xdebug fpm fpm-xdebug

.PHONY: cli
cli:
	$(MAKE) -C $@ push

.PHONY: cli-xdebug
cli-xdebug: cli
	$(MAKE) -C $@ push

.PHONY: fpm
fpm:
	$(MAKE) -C $@ push

.PHONY: fpm-xdebug
fpm-xdebug: fpm
	$(MAKE) -C $@ push

.PHONY: clean
clean:
	$(MAKE) -C cli $@
	$(MAKE) -C cli-xdebug $@
	$(MAKE) -C fpm $@
	$(MAKE) -C fpm-xdebug $@
