export REPOSITORY = kiboko/php

ifndef VERSION
export VERSION = $(subst php@,,$(shell basename $(CURDIR)))
endif

ifndef EDITION_VERSION
$(error Variable $$EDITION_VERSION must be defined)
endif

ifndef ORO_VERSION
$(error Variable $$ORO_VERSION must be defined)
endif

REPOSITORY = kiboko/php
VERSION = $(subst php@,,$(shell basename $(CURDIR)))

.PHONY: all
all: cli cli-blackfire cli-xdebug fpm fpm-blackfire fpm-xdebug

%:
	docker build --build-arg FLAVOR=$@ --build-arg ORO_VERSION=$(ORO_VERSION) --tag $(REPOSITORY):$(VERSION)-$@-$(EDITION_VERSION)-mysql .
	docker push $(REPOSITORY):$(VERSION)-$@-$(EDITION_VERSION)-mysql
