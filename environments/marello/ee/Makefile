ifndef PLATFORM
$(error Variable $$PLATFORM must be defined)
endif

export EDITION = $(PLATFORM)-$(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all: 2.0 2.1 2.2

.PHONY: 2.0
2.0:
	$(MAKE) -C 2.0

.PHONY: 2.1
2.1:
	$(MAKE) -C 2.1

.PHONY: 2.2
2.2:
	$(MAKE) -C 2.2