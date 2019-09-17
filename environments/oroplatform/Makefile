export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all: ce ee

.PHONY: ce
ce:
	$(MAKE) -C ce

.PHONY: ee
ee:
	$(MAKE) -C ee