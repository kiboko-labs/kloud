ifndef REPOSITORY
$(error Variable $$REPOSITORY must be defined)
endif

ifndef VERSION
$(error Variable $$VERSION must be defined)
endif

FLAVOR = $(shell basename $(CURDIR))
TAG = $(REPOSITORY):$(VERSION)-$(FLAVOR)

.PHONY: build
build: .buildignore

.PHONY: push
push: build .pushignore

.PHONY: clean
clean:
	-rm .buildignore .pushignore

.buildignore:
	docker build . --tag $(TAG)
	touch $@

.pushignore:
	docker push $(TAG)
	touch $@
