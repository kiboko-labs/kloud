ifndef EDITION_VERSION
ifndef EDITION
$(error Variable $$EDITION must be defined)
endif

export EDITION_VERSION = $(EDITION)-$(subst @,-,$(shell basename $(CURDIR)))
endif

.PHONY: all
all: mysql postgresql

.PHONY: postgresql
postgresql:
	$(MAKE) -j8 -j8 -C postgresql

.PHONY: mysql
mysql:
	$(MAKE) -j8 -j8 -C mysql

.PHONY: mariadb
mariadb:
	$(MAKE) -j8 -j8 -C mysql DATABASE=mariadb

