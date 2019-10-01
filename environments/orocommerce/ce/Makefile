ifndef EDITION
ifndef PLATFORM
$(error Variable $$PLATFORM must be defined)
endif

export EDITION = $(PLATFORM)-$(subst @,-,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: 1.6 3.1 4.1

.PHONY: 3.1
3.1:
	$(MAKE) -j8 -j8 -C 3.1

.PHONY: 1.6
1.6:
	$(MAKE) -j8 -j8 -C 3.1 EDITION_VERSION=$(EDITION)-1.6

.PHONY: 4.1
4.1:
	$(MAKE) -j8 -j8 -C 3.1 EDITION_VERSION=$(EDITION)-4.1