ifndef PLATFORM
export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: ce ee

.PHONY: ce
ce:
	$(MAKE) -j8 -j8 -C ce

.PHONY: ee
ee:
	$(MAKE) -j8 -j8 -C ce EDITION=ee