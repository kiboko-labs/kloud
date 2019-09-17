ifndef EDITION_VERSION
$(error Variable $$EDITION_VERSION must be defined)
endif

ifndef REPOSITORY
$(error Variable $$REPOSITORY must be defined)
endif

ifndef VERSION
$(error Variable $$VERSION must be defined)
endif

FLAVOR = $(shell basename $(CURDIR))
SOURCE = $(REPOSITORY):$(VERSION)-$(FLAVOR)-oroplatform-ee-3.1
TAG = $(REPOSITORY):$(VERSION)-$(FLAVOR)-$(PLATFORM)

.PHONY: build
build:
	docker tag $(SOURCE) $(TAG)

.PHONY: push
push: build
	docker push $(TAG)

