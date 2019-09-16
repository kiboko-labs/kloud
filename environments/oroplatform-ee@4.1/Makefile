export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: build
build:
	$(MAKE) -C php\@7.2 build
	$(MAKE) -C php\@7.3 build
	$(MAKE) -C php\@7.4 build

.PHONY: push
push:
	$(MAKE) -C php\@7.2 push
	$(MAKE) -C php\@7.3 push
	$(MAKE) -C php\@7.4 push

