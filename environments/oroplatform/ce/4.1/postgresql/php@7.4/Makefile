ifndef EDITION_VERSION
$(error Variable $$EDITION_VERSION must be defined)
endif

REPOSITORY = kiboko/php
VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all: cli cli-xdebug fpm fpm-xdebug

%:
	docker build --build-arg FLAVOR=$@ --tag $(REPOSITORY):$(VERSION)-$@-$(EDITION_VERSION) .
	docker push $(REPOSITORY):$(VERSION)-$@-$(EDITION_VERSION)
