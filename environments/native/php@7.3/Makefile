export REPOSITORY = kiboko/php
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C cli push
	$(MAKE) -C cli-xdebug push
	$(MAKE) -C cli-blackfire push
	$(MAKE) -C fpm push
	$(MAKE) -C fpm-xdebug push
	$(MAKE) -C fpm-blackfire push

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
