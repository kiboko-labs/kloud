ifndef PLATFORM
$(error Variable $$PLATFORM must be defined)
endif

export EDITION = $(PLATFORM)-$(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all: 1.6 3.1 4.1

.PHONY: 1.6
1.6:
	$(MAKE) -C 1.6

.PHONY: 3.1
3.1:
	$(MAKE) -C 3.1

.PHONY: 4.1
4.1:
	$(MAKE) -C 4.1