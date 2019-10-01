ifndef PLATFORM
export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: ce ee

.PHONY: ce
ce:
	$(MAKE) -C ce

.PHONY: ee
ee:
	$(MAKE) -C ce EDITION=ee