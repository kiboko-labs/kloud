ifndef PLATFORM
$(error Variable $$PLATFORM must be defined)
endif

export EDITION = $(PLATFORM)-$(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all: 3.1

.PHONY: 3.1
3.1:
	$(MAKE) -C 3.1