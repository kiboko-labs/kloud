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
ifndef FORCE_BUILD
	docker pull $(TAG) || docker build . --tag $(TAG)
else
	docker build --no-cache --tag $(TAG) .
endif
	touch $@

.pushignore:
	docker push $(TAG)
	touch $@
