ifndef EDITION
$(error Variable $$EDITION must be defined)
endif

export EDITION_VERSION = $(EDITION)-$(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C postgresql
	$(MAKE) -C mysql

