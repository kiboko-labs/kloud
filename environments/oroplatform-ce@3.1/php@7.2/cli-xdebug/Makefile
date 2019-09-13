ifndef PLATFORM
$(error Variable $$PLATFORM must be defined)
endif

ifndef REPOSITORY
$(error Variable $$REPOSITORY must be defined)
endif

ifndef VERSION
$(error Variable $$VERSION must be defined)
endif

FLAVOR = $(shell basename $(CURDIR))
TAG = $(REPOSITORY):$(VERSION)-$(FLAVOR)-$(PLATFORM)

.PHONY: build
build:
	docker build . --tag $(TAG)

.PHONY: push
push: build
	docker push $(TAG)

