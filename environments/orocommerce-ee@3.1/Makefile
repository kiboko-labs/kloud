export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: build
build:
	$(MAKE) -C php\@7.1 build
	$(MAKE) -C php\@7.2 build

.PHONY: push
push:
	$(MAKE) -C php\@7.1 push
	$(MAKE) -C php\@7.2 push

