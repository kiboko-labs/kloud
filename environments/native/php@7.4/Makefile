export REPOSITORY = kiboko/php
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C cli push
	$(MAKE) -C cli-xdebug push
	$(MAKE) -C cli-blackfire push

.PHONY: cli
cli:
	$(MAKE) -C $@ push

.PHONY: cli-blackfire
cli-blackfire: cli
	$(MAKE) -C $@ push

.PHONY: cli-xdebug
cli-xdebug: cli
	$(MAKE) -C $@ push

.PHONY: clean
clean:
	$(MAKE) -C cli $@
	$(MAKE) -C cli-blackfire $@
	$(MAKE) -C cli-xdebug $@
