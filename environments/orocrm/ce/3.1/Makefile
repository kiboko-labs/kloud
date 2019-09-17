ifndef EDITION
$(error Variable $$EDITION must be defined)
endif

export EDITION_VERSION = $(EDITION)-$(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C php\@7.1
	$(MAKE) -C php\@7.2
	$(MAKE) -C php\@7.3
	$(MAKE) -C php\@7.4

