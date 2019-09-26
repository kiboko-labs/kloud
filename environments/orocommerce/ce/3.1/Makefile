ifndef ORO_VERSION
export ORO_VERSION=$(subst @,-,$(shell basename $(CURDIR)))
endif

ifndef EDITION_VERSION
ifndef EDITION
$(error Variable $$EDITION must be defined)
endif

export EDITION_VERSION = $(EDITION)-$(ORO_VERSION)
endif

.PHONY: all
all: mysql postgresql

.PHONY: postgresql
postgresql:
	$(MAKE) -C postgresql

.PHONY: mysql
mysql:
	$(MAKE) -C mysql

.PHONY: mariadb
mariadb:
	$(MAKE) -C mysql DATABASE=mariadb

