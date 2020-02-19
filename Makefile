REPOSITORY=kiboko/php
LATEST_OROPLATFORM=3.1
LATEST_OROCOMMERCE=3.1
LATEST_OROCRM=3.1
LATEST_MARELLO=2.0

all: ## Build all variations
all: oroplatform orocommerce orocrm marello

oroplatform: ## Build all OroPlatform (latest LTS) variations
oroplatform: oroplatform-ce oroplatform-ee
oroplatform-ce: ## Build all OroPlatform (latest LTS) Community Edition variations
oroplatform-ce: oroplatform-ce-$(LATEST_OROPLATFORM)
oroplatform-ee: ## Build all OroPlatform (latest LTS) Enterprise Edition variations
oroplatform-ee: oroplatform-ee-$(LATEST_OROPLATFORM)

oroplatform-3.1: ## Build all OroPlatform (3.1) variations
oroplatform-3.1: oroplatform-ce-3.1 oroplatform-ee-3.1
oroplatform-ce-3.1: ## Build all OroPlatform (3.1) Community Edition variations
oroplatform-ce-3.1: 7.1-cli-oroplatform-ce-3.1 7.1-cli-blackfire-oroplatform-ce-3.1 7.1-cli-xdebug-oroplatform-ce-3.1 7.1-fpm-oroplatform-ce-3.1 7.1-fpm-blackfire-oroplatform-ce-3.1 7.1-fpm-xdebug-oroplatform-ce-3.1 7.2-cli-oroplatform-ce-3.1 7.2-cli-blackfire-oroplatform-ce-3.1 7.2-cli-xdebug-oroplatform-ce-3.1 7.2-fpm-oroplatform-ce-3.1 7.2-fpm-blackfire-oroplatform-ce-3.1 7.2-fpm-xdebug-oroplatform-ce-3.1
oroplatform-ee-3.1: ## Build all OroPlatform (3.1) Enterprise Edition variations
oroplatform-ee-3.1: 7.1-cli-oroplatform-ee-3.1 7.1-cli-blackfire-oroplatform-ee-3.1 7.1-cli-xdebug-oroplatform-ee-3.1 7.1-fpm-oroplatform-ee-3.1 7.1-fpm-blackfire-oroplatform-ee-3.1 7.1-fpm-xdebug-oroplatform-ee-3.1 7.2-cli-oroplatform-ee-3.1 7.2-cli-blackfire-oroplatform-ee-3.1 7.2-cli-xdebug-oroplatform-ee-3.1 7.2-fpm-oroplatform-ee-3.1 7.2-fpm-blackfire-oroplatform-ee-3.1 7.2-fpm-xdebug-oroplatform-ee-3.1

oroplatform-4.1: ## Build all OroPlatform (4.1) variations
oroplatform-4.1: oroplatform-ce-4.1 oroplatform-ee-4.1
oroplatform-ce-4.1: ## Build all OroPlatform (4.1) Community Edition variations
oroplatform-ce-4.1: 7.1-cli-oroplatform-ce-4.1 7.1-cli-blackfire-oroplatform-ce-4.1 7.1-cli-xdebug-oroplatform-ce-4.1 7.1-fpm-oroplatform-ce-4.1 7.1-fpm-blackfire-oroplatform-ce-4.1 7.1-fpm-xdebug-oroplatform-ce-4.1 7.2-cli-oroplatform-ce-4.1 7.2-cli-blackfire-oroplatform-ce-4.1 7.2-cli-xdebug-oroplatform-ce-4.1 7.2-fpm-oroplatform-ce-4.1 7.2-fpm-blackfire-oroplatform-ce-4.1 7.2-fpm-xdebug-oroplatform-ce-4.1
oroplatform-ee-4.1: ## Build all OroPlatform (4.1) Enterprise Edition variations
oroplatform-ee-4.1: 7.1-cli-oroplatform-ee-4.1 7.1-cli-blackfire-oroplatform-ee-4.1 7.1-cli-xdebug-oroplatform-ee-4.1 7.1-fpm-oroplatform-ee-4.1 7.1-fpm-blackfire-oroplatform-ee-4.1 7.1-fpm-xdebug-oroplatform-ee-4.1 7.2-cli-oroplatform-ee-4.1 7.2-cli-blackfire-oroplatform-ee-4.1 7.2-cli-xdebug-oroplatform-ee-4.1 7.2-fpm-oroplatform-ee-4.1 7.2-fpm-blackfire-oroplatform-ee-4.1 7.2-fpm-xdebug-oroplatform-ee-4.1

orocommerce: ## Build all OroCommerce (latest LTS) variations
orocommerce: orocommerce-ce orocommerce-ee
orocommerce-ce: ## Build all OroCommerce (latest LTS) Community Edition variations
orocommerce-ce: orocommerce-ce-$(LATEST_OROCOMMERCE)
orocommerce-ee: ## Build all OroCommerce (latest LTS) Enterprise Edition variations
orocommerce-ee: orocommerce-ee-$(LATEST_OROCOMMERCE)

orocommerce-3.1: ## Build all OroCommerce (3.1) variations
orocommerce-3.1: orocommerce-ce-3.1 orocommerce-ee-3.1
orocommerce-ce-3.1: ## Build all OroCommerce (3.1) Community Edition variations
orocommerce-ce-3.1: 7.1-cli-orocommerce-ce-3.1 7.1-cli-blackfire-orocommerce-ce-3.1 7.1-cli-xdebug-orocommerce-ce-3.1 7.1-fpm-orocommerce-ce-3.1 7.1-fpm-blackfire-orocommerce-ce-3.1 7.1-fpm-xdebug-orocommerce-ce-3.1 7.2-cli-orocommerce-ce-3.1 7.2-cli-blackfire-orocommerce-ce-3.1 7.2-cli-xdebug-orocommerce-ce-3.1 7.2-fpm-orocommerce-ce-3.1 7.2-fpm-blackfire-orocommerce-ce-3.1 7.2-fpm-xdebug-orocommerce-ce-3.1
orocommerce-ee-3.1: ## Build all OroCommerce (3.1) variations
orocommerce-ee-3.1: 7.1-cli-orocommerce-ee-3.1 7.1-cli-blackfire-orocommerce-ee-3.1 7.1-cli-xdebug-orocommerce-ee-3.1 7.1-fpm-orocommerce-ee-3.1 7.1-fpm-blackfire-orocommerce-ee-3.1 7.1-fpm-xdebug-orocommerce-ee-3.1 7.2-cli-orocommerce-ee-3.1 7.2-cli-blackfire-orocommerce-ee-3.1 7.2-cli-xdebug-orocommerce-ee-3.1 7.2-fpm-orocommerce-ee-3.1 7.2-fpm-blackfire-orocommerce-ee-3.1 7.2-fpm-xdebug-orocommerce-ee-3.1

orocommerce-4.1: ## Build all OroCommerce (4.1) variations
orocommerce-4.1: orocommerce-ce-4.1 orocommerce-ee-4.1
orocommerce-ce-4.1: ## Build all OroCommerce (4.1) Community Edition variations
orocommerce-ce-4.1: 7.1-cli-orocommerce-ce-4.1 7.1-cli-blackfire-orocommerce-ce-4.1 7.1-cli-xdebug-orocommerce-ce-4.1 7.1-fpm-orocommerce-ce-4.1 7.1-fpm-blackfire-orocommerce-ce-4.1 7.1-fpm-xdebug-orocommerce-ce-4.1 7.2-cli-orocommerce-ce-4.1 7.2-cli-blackfire-orocommerce-ce-4.1 7.2-cli-xdebug-orocommerce-ce-4.1 7.2-fpm-orocommerce-ce-4.1 7.2-fpm-blackfire-orocommerce-ce-4.1 7.2-fpm-xdebug-orocommerce-ce-4.1
orocommerce-ee-4.1: ## Build all OroCommerce (4.1) Enterprise Edition variations
orocommerce-ee-4.1: 7.1-cli-orocommerce-ee-4.1 7.1-cli-blackfire-orocommerce-ee-4.1 7.1-cli-xdebug-orocommerce-ee-4.1 7.1-fpm-orocommerce-ee-4.1 7.1-fpm-blackfire-orocommerce-ee-4.1 7.1-fpm-xdebug-orocommerce-ee-4.1 7.2-cli-orocommerce-ee-4.1 7.2-cli-blackfire-orocommerce-ee-4.1 7.2-cli-xdebug-orocommerce-ee-4.1 7.2-fpm-orocommerce-ee-4.1 7.2-fpm-blackfire-orocommerce-ee-4.1 7.2-fpm-xdebug-orocommerce-ee-4.1

orocrm: ## Build all OroCRM (latest LTS) variations
orocrm: orocrm-ce orocrm-ee
orocrm-ce: ## Build all OroCRM (latest LTS) Community Edition variations
orocrm-ce: orocrm-ce-$(LATEST_OROCRM)
orocrm-ee: ## Build all OroCRM (latest LTS) Enterprise Edition variations
orocrm-ee: orocrm-ee-$(LATEST_OROCRM)

orocrm-3.1: ## Build all OroCRM (3.1) variations
orocrm-3.1: orocrm-ce orocrm-ee
orocrm-ce-3.1: ## Build all OroCRM (3.1) Community Edition variations
orocrm-ce-3.1: 7.1-cli-orocrm-ce-3.1 7.1-cli-blackfire-orocrm-ce-3.1 7.1-cli-xdebug-orocrm-ce-3.1 7.1-fpm-orocrm-ce-3.1 7.1-fpm-blackfire-orocrm-ce-3.1 7.1-fpm-xdebug-orocrm-ce-3.1 7.2-cli-orocrm-ce-3.1 7.2-cli-blackfire-orocrm-ce-3.1 7.2-cli-xdebug-orocrm-ce-3.1 7.2-fpm-orocrm-ce-3.1 7.2-fpm-blackfire-orocrm-ce-3.1 7.2-fpm-xdebug-orocrm-ce-3.1
orocrm-ee-3.1: ## Build all OroCRM (3.1) Enterprise Edition variations
orocrm-ee-3.1: 7.1-cli-orocrm-ee-3.1 7.1-cli-blackfire-orocrm-ee-3.1 7.1-cli-xdebug-orocrm-ee-3.1 7.1-fpm-orocrm-ee-3.1 7.1-fpm-blackfire-orocrm-ee-3.1 7.1-fpm-xdebug-orocrm-ee-3.1 7.2-cli-orocrm-ee-3.1 7.2-cli-blackfire-orocrm-ee-3.1 7.2-cli-xdebug-orocrm-ee-3.1 7.2-fpm-orocrm-ee-3.1 7.2-fpm-blackfire-orocrm-ee-3.1 7.2-fpm-xdebug-orocrm-ee-3.1

orocrm-4.1: ## Build all OroCRM (4.1) variations
orocrm-4.1: orocrm-ce orocrm-ee
orocrm-ce-4.1: ## Build all OroCRM (4.1) Community Edition variations
orocrm-ce-4.1: 7.1-cli-orocrm-ce-4.1 7.1-cli-blackfire-orocrm-ce-4.1 7.1-cli-xdebug-orocrm-ce-4.1 7.1-fpm-orocrm-ce-4.1 7.1-fpm-blackfire-orocrm-ce-4.1 7.1-fpm-xdebug-orocrm-ce-4.1 7.2-cli-orocrm-ce-4.1 7.2-cli-blackfire-orocrm-ce-4.1 7.2-cli-xdebug-orocrm-ce-4.1 7.2-fpm-orocrm-ce-4.1 7.2-fpm-blackfire-orocrm-ce-4.1 7.2-fpm-xdebug-orocrm-ce-4.1
orocrm-ee-4.1: ## Build all OroCRM (4.1) Enterprise Edition variations
orocrm-ee-4.1: 7.1-cli-orocrm-ee-4.1 7.1-cli-blackfire-orocrm-ee-4.1 7.1-cli-xdebug-orocrm-ee-4.1 7.1-fpm-orocrm-ee-4.1 7.1-fpm-blackfire-orocrm-ee-4.1 7.1-fpm-xdebug-orocrm-ee-4.1 7.2-cli-orocrm-ee-4.1 7.2-cli-blackfire-orocrm-ee-4.1 7.2-cli-xdebug-orocrm-ee-4.1 7.2-fpm-orocrm-ee-4.1 7.2-fpm-blackfire-orocrm-ee-4.1 7.2-fpm-xdebug-orocrm-ee-4.1

marello: ## Build all Marello (latest LTS) variations
marello: marello-ce marello-ee
marello-ce: ## Build all Marello (latest LTS) Community Edition variations
marello-ce: marello-ce-$(LATEST_MARELLO)
marello-ee: ## Build all Marello (latest LTS) Enterprise Edition variations
marello-ee: marello-ee-$(LATEST_MARELLO)

marello-2.0: ## Build all Marello (2.0) variations
marello-2.0: marello-ce marello-ee
marello-ce-2.0: ## Build all Marello (2.0) Community Edition variations
marello-ce-2.0: 7.1-cli-marello-ce-2.0 7.1-cli-blackfire-marello-ce-2.0 7.1-cli-xdebug-marello-ce-2.0 7.1-fpm-marello-ce-2.0 7.1-fpm-blackfire-marello-ce-2.0 7.1-fpm-xdebug-marello-ce-2.0 7.2-cli-marello-ce-2.0 7.2-cli-blackfire-marello-ce-2.0 7.2-cli-xdebug-marello-ce-2.0 7.2-fpm-marello-ce-2.0 7.2-fpm-blackfire-marello-ce-2.0 7.2-fpm-xdebug-marello-ce-2.0
marello-ee-2.0: ## Build all Marello (2.0) Enterprise Edition variations
marello-ee-2.0: 7.1-cli-marello-ee-2.0 7.1-cli-blackfire-marello-ee-2.0 7.1-cli-xdebug-marello-ee-2.0 7.1-fpm-marello-ee-2.0 7.1-fpm-blackfire-marello-ee-2.0 7.1-fpm-xdebug-marello-ee-2.0 7.2-cli-marello-ee-2.0 7.2-cli-blackfire-marello-ee-2.0 7.2-cli-xdebug-marello-ee-2.0 7.2-fpm-marello-ee-2.0 7.2-fpm-blackfire-marello-ee-2.0 7.2-fpm-xdebug-marello-ee-2.0

blackfire: ## Build all Blackfire variations
blackfire: oroplatform-blackfire orocommerce-blackfire orocrm-blackfire marello-blackfire
oroplatform-blackfire: 7.1-cli-blackfire-oroplatform-ce-3.1 7.1-fpm-blackfire-oroplatform-ce-3.1 7.1-cli-blackfire-oroplatform-ee-3.1 7.1-fpm-blackfire-oroplatform-ee-3.1 7.2-cli-blackfire-oroplatform-ce-3.1 7.2-fpm-blackfire-oroplatform-ce-3.1 7.2-cli-blackfire-oroplatform-ee-3.1 7.2-fpm-blackfire-oroplatform-ee-3.1
orocommerce-blackfire: 7.1-cli-blackfire-orocommerce-ce-3.1 7.1-fpm-blackfire-orocommerce-ce-3.1 7.1-cli-blackfire-orocommerce-ee-3.1 7.1-fpm-blackfire-orocommerce-ee-3.1 7.2-cli-blackfire-orocommerce-ce-3.1 7.2-fpm-blackfire-orocommerce-ce-3.1 7.2-cli-blackfire-orocommerce-ee-3.1 7.2-fpm-blackfire-orocommerce-ee-3.1
orocrm-blackfire: 7.1-cli-blackfire-orocrm-ce-3.1 7.1-fpm-blackfire-orocrm-ce-3.1 7.1-cli-blackfire-orocrm-ee-3.1 7.1-fpm-blackfire-orocrm-ee-3.1 7.2-cli-blackfire-orocrm-ce-3.1 7.2-fpm-blackfire-orocrm-ce-3.1 7.2-cli-blackfire-orocrm-ee-3.1 7.2-fpm-blackfire-orocrm-ee-3.1
marello-blackfire: 7.1-cli-blackfire-marello-ce-2.0 7.1-fpm-blackfire-marello-ce-2.0 7.1-cli-blackfire-marello-ee-2.0 7.1-fpm-blackfire-marello-ee-2.0 7.2-cli-blackfire-marello-ce-2.0 7.2-fpm-blackfire-marello-ce-2.0 7.2-cli-blackfire-marello-ee-2.0 7.2-fpm-blackfire-marello-ee-2.0

xdebug: ## Build all Xdebug variations
xdebug: oroplatform-xdebug orocommerce-xdebug orocrm-xdebug marello-xdebug
oroplatform-xdebug: 7.1-cli-xdebug-oroplatform-ce-3.1 7.1-fpm-xdebug-oroplatform-ce-3.1 7.1-cli-xdebug-oroplatform-ee-3.1 7.1-fpm-xdebug-oroplatform-ee-3.1 7.2-cli-xdebug-oroplatform-ce-3.1 7.2-fpm-xdebug-oroplatform-ce-3.1 7.2-cli-xdebug-oroplatform-ee-3.1 7.2-fpm-xdebug-oroplatform-ee-3.1
orocommerce-xdebug: 7.1-cli-xdebug-orocommerce-ce-3.1 7.1-fpm-xdebug-orocommerce-ce-3.1 7.1-cli-xdebug-orocommerce-ee-3.1 7.1-fpm-xdebug-orocommerce-ee-3.1 7.2-cli-xdebug-orocommerce-ce-3.1 7.2-fpm-xdebug-orocommerce-ce-3.1 7.2-cli-xdebug-orocommerce-ee-3.1 7.2-fpm-xdebug-orocommerce-ee-3.1
orocrm-xdebug: 7.1-cli-xdebug-orocrm-ce-3.1 7.1-fpm-xdebug-orocrm-ce-3.1 7.1-cli-xdebug-orocrm-ee-3.1 7.1-fpm-xdebug-orocrm-ee-3.1 7.2-cli-xdebug-orocrm-ce-3.1 7.2-fpm-xdebug-orocrm-ce-3.1 7.2-cli-xdebug-orocrm-ee-3.1 7.2-fpm-xdebug-orocrm-ee-3.1
marello-xdebug: 7.1-cli-xdebug-marello-ce-2.0 7.1-fpm-xdebug-marello-ce-2.0 7.1-cli-xdebug-marello-ee-2.0 7.1-fpm-xdebug-marello-ee-2.0 7.2-cli-xdebug-marello-ce-2.0 7.2-fpm-xdebug-marello-ce-2.0 7.2-cli-xdebug-marello-ee-2.0 7.2-fpm-xdebug-marello-ee-2.0

%-cli:
	$(call build,$@,environments/native/php@$*/cli)
%-cli-blackfire: %-cli
	$(call build,$@,environments/native/php@$*/cli-blackfire)
%-cli-xdebug: %-cli
	$(call build,$@,environments/native/php@$*/cli-xdebug)

%-fpm:
	$(call build,$@,environments/native/php@$*/fpm)
%-fpm-blackfire: %-fpm
	$(call build,$@,environments/native/php@$*/fpm-blackfire)
%-fpm-xdebug: %-fpm
	$(call build,$@,environments/native/php@$*/fpm-xdebug)

#
# OroPlatform (Postgres)
#
%-cli-oroplatform-ce-3.1: %-cli
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-cli-blackfire-oroplatform-ce-3.1: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-cli-xdebug-oroplatform-ce-3.1: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)

%-fpm-oroplatform-ce-3.1: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-oroplatform-ce-3.1: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-fpm-xdebug-oroplatform-ce-3.1: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)

%-cli-oroplatform-ee-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-blackfire-oroplatform-ee-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-xdebug-oroplatform-ee-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)

%-fpm-oroplatform-ee-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-blackfire-oroplatform-ee-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-xdebug-oroplatform-ee-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ee)

#
# OroPlatform (MySQL)
#
%-cli-oroplatform-ce-3.1-mysql: %-cli
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-cli-blackfire-oroplatform-ce-3.1-mysql: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-cli-xdebug-oroplatform-ce-3.1-mysql: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)

%-fpm-oroplatform-ce-3.1-mysql: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-fpm-blackfire-oroplatform-ce-3.1-mysql: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-fpm-xdebug-oroplatform-ce-3.1-mysql: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)

%-cli-oroplatform-ee-3.1-mysql: %-cli-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-blackfire-oroplatform-ee-3.1-mysql: %-cli-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-xdebug-oroplatform-ee-3.1-mysql: %-cli-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)

%-fpm-oroplatform-ee-3.1-mysql: %-fpm-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-blackfire-oroplatform-ee-3.1-mysql: %-fpm-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-xdebug-oroplatform-ee-3.1-mysql: %-fpm-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)

#
# OroPlatform (Postgres)
#
%-cli-oroplatform-ce-4.1: %-cli
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-cli-blackfire-oroplatform-ce-4.1: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-cli-xdebug-oroplatform-ce-4.1: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)

%-fpm-oroplatform-ce-4.1: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-oroplatform-ce-4.1: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)
%-fpm-xdebug-oroplatform-ce-4.1: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*)

%-cli-oroplatform-ee-4.1: %-cli-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-blackfire-oroplatform-ee-4.1: %-cli-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-xdebug-oroplatform-ee-4.1: %-cli-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)

%-fpm-oroplatform-ee-4.1: %-fpm-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-blackfire-oroplatform-ee-4.1: %-fpm-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-xdebug-oroplatform-ee-4.1: %-fpm-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ee)

#
# OroPlatform (MySQL)
#
%-cli-oroplatform-ce-4.1-mysql: %-cli
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-cli-blackfire-oroplatform-ce-4.1-mysql: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-cli-xdebug-oroplatform-ce-4.1-mysql: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)

%-fpm-oroplatform-ce-4.1-mysql: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-fpm-blackfire-oroplatform-ce-4.1-mysql: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)
%-fpm-xdebug-oroplatform-ce-4.1-mysql: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*)

%-cli-oroplatform-ee-4.1-mysql: %-cli-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-blackfire-oroplatform-ee-4.1-mysql: %-cli-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-cli-xdebug-oroplatform-ee-4.1-mysql: %-cli-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)

%-fpm-oroplatform-ee-4.1-mysql: %-fpm-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-blackfire-oroplatform-ee-4.1-mysql: %-fpm-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)
%-fpm-xdebug-oroplatform-ee-4.1-mysql: %-fpm-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/oroplatform/ee)

#
# OroCommerce (Postgres)
#
%-cli-orocommerce-ce-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)
%-cli-blackfire-orocommerce-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)
%-cli-xdebug-orocommerce-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)

%-fpm-orocommerce-ce-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-orocommerce-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)
%-fpm-xdebug-orocommerce-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)

%-cli-orocommerce-ee-3.1: %-cli-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-blackfire-orocommerce-ee-3.1: %-cli-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-xdebug-orocommerce-ee-3.1: %-cli-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-fpm-orocommerce-ee-3.1: %-fpm-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-blackfire-orocommerce-ee-3.1: %-fpm-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-xdebug-orocommerce-ee-3.1: %-fpm-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-cli-orocommerce-ce-4.1: %-cli-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/4.1/postgresql/php@$*)
%-cli-blackfire-orocommerce-ce-4.1: %-cli-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/4.1/postgresql/php@$*)
%-cli-xdebug-orocommerce-ce-4.1: %-cli-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/4.1/postgresql/php@$*)

%-fpm-orocommerce-ce-4.1: %-fpm-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/4.1/postgresql/php@$*)
%-fpm-blackfire-orocommerce-ce-4.1: %-fpm-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/4.1/orocommerce/php@$*)
%-fpm-xdebug-orocommerce-ce-4.1: %-fpm-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*)

%-cli-orocommerce-ee-4.1: %-cli-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-blackfire-orocommerce-ee-4.1: %-cli-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-xdebug-orocommerce-ee-4.1: %-cli-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-fpm-orocommerce-ee-4.1: %-fpm-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-blackfire-orocommerce-ee-4.1: %-fpm-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-xdebug-orocommerce-ee-4.1: %-fpm-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocommerce/ee)

#
# OroCommerce (MySQL)
#
%-cli-orocommerce-ce-3.1-mysql: %-cli-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-cli-blackfire-orocommerce-ce-3.1-mysql: %-cli-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-cli-xdebug-orocommerce-ce-3.1-mysql: %-cli-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)

%-fpm-orocommerce-ce-3.1-mysql: %-fpm-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-fpm-blackfire-orocommerce-ce-3.1-mysql: %-fpm-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-fpm-xdebug-orocommerce-ce-3.1-mysql: %-fpm-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)

%-cli-orocommerce-ee-3.1-mysql: %-cli-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-blackfire-orocommerce-ee-3.1-mysql: %-cli-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-xdebug-orocommerce-ee-3.1-mysql: %-cli-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-fpm-orocommerce-ee-3.1-mysql: %-fpm-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-blackfire-orocommerce-ee-3.1-mysql: %-fpm-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-xdebug-orocommerce-ee-3.1-mysql: %-fpm-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-cli-orocommerce-ce-4.1-mysql: %-cli-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-cli-blackfire-orocommerce-ce-4.1-mysql: %-cli-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-cli-xdebug-orocommerce-ce-4.1-mysql: %-cli-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)

%-fpm-orocommerce-ce-4.1-mysql: %-fpm-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-fpm-blackfire-orocommerce-ce-4.1-mysql: %-fpm-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)
%-fpm-xdebug-orocommerce-ce-4.1-mysql: %-fpm-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/mysql/php@$*)

%-cli-orocommerce-ee-4.1-mysql: %-cli-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-blackfire-orocommerce-ee-4.1-mysql: %-cli-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-cli-xdebug-orocommerce-ee-4.1-mysql: %-cli-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)

%-fpm-orocommerce-ee-4.1-mysql: %-fpm-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-blackfire-orocommerce-ee-4.1-mysql: %-fpm-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)
%-fpm-xdebug-orocommerce-ee-4.1-mysql: %-fpm-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocommerce/ee)

#
# OroCRM (Postgres)
#
%-cli-orocrm-ce-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-cli-blackfire-orocrm-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-cli-xdebug-orocrm-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)

%-fpm-orocrm-ce-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-orocrm-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/orocrm/php@$*)
%-fpm-xdebug-orocrm-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)

%-cli-orocrm-ee-3.1: %-cli-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-blackfire-orocrm-ee-3.1: %-cli-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-xdebug-orocrm-ee-3.1: %-cli-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)

%-fpm-orocrm-ee-3.1: %-fpm-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-blackfire-orocrm-ee-3.1: %-fpm-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-xdebug-orocrm-ee-3.1: %-fpm-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/orocrm/ee)
	
%-cli-orocrm-ce-4.1: %-cli-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-cli-blackfire-orocrm-ce-4.1: %-cli-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-cli-xdebug-orocrm-ce-4.1: %-cli-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)

%-fpm-orocrm-ce-4.1: %-fpm-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-orocrm-ce-4.1: %-fpm-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/orocrm/php@$*)
%-fpm-xdebug-orocrm-ce-4.1: %-fpm-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*)

%-cli-orocrm-ee-4.1: %-cli-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-blackfire-orocrm-ee-4.1: %-cli-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-xdebug-orocrm-ee-4.1: %-cli-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)

%-fpm-orocrm-ee-4.1: %-fpm-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-blackfire-orocrm-ee-4.1: %-fpm-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-xdebug-orocrm-ee-4.1: %-fpm-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/orocrm/ee)

#
# OroCRM (MySQL)
#
%-cli-orocrm-ce-3.1-mysql: %-cli-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-cli-blackfire-orocrm-ce-3.1-mysql: %-cli-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-cli-xdebug-orocrm-ce-3.1-mysql: %-cli-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)

%-fpm-orocrm-ce-3.1-mysql: %-fpm-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-fpm-blackfire-orocrm-ce-3.1-mysql: %-fpm-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-fpm-xdebug-orocrm-ce-3.1-mysql: %-fpm-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)

%-cli-orocrm-ee-3.1-mysql: %-cli-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-blackfire-orocrm-ee-3.1-mysql: %-cli-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-xdebug-orocrm-ee-3.1-mysql: %-cli-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)

%-fpm-orocrm-ee-3.1-mysql: %-fpm-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-blackfire-orocrm-ee-3.1-mysql: %-fpm-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-xdebug-orocrm-ee-3.1-mysql: %-fpm-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)

%-cli-orocrm-ce-4.1-mysql: %-cli-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-cli-blackfire-orocrm-ce-4.1-mysql: %-cli-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-cli-xdebug-orocrm-ce-4.1-mysql: %-cli-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)

%-fpm-orocrm-ce-4.1-mysql: %-fpm-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-fpm-blackfire-orocrm-ce-4.1-mysql: %-fpm-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)
%-fpm-xdebug-orocrm-ce-4.1-mysql: %-fpm-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/mysql/php@$*)

%-cli-orocrm-ee-4.1-mysql: %-cli-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-blackfire-orocrm-ee-4.1-mysql: %-cli-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-cli-xdebug-orocrm-ee-4.1-mysql: %-cli-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)

%-fpm-orocrm-ee-4.1-mysql: %-fpm-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-blackfire-orocrm-ee-4.1-mysql: %-fpm-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)
%-fpm-xdebug-orocrm-ee-4.1-mysql: %-fpm-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/orocrm/ee)

#
# Marello (Postgres)
#
%-cli-marello-ce-2.0: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-cli-blackfire-marello-ce-2.0: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-cli-xdebug-marello-ce-2.0: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)

%-fpm-marello-ce-2.0: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-marello-ce-2.0: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-fpm-xdebug-marello-ce-2.0: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)

%-cli-marello-ee-2.0: %-cli-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-2.0: %-cli-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-2.0: %-cli-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-2.0: %-fpm-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-2.0: %-fpm-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-2.0: %-fpm-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)

%-cli-marello-ce-3.0: %-cli-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-cli-blackfire-marello-ce-3.0: %-cli-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-cli-xdebug-marello-ce-3.0: %-cli-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)

%-fpm-marello-ce-3.0: %-fpm-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-fpm-blackfire-marello-ce-3.0: %-fpm-blackfire-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)
%-fpm-xdebug-marello-ce-3.0: %-fpm-xdebug-oroplatform-ce-4.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*)

%-cli-marello-ee-3.0: %-cli-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-3.0: %-cli-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-3.0: %-cli-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-3.0: %-fpm-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-3.0: %-fpm-blackfire-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-3.0: %-fpm-xdebug-oroplatform-ee-4.1
	$(call build_from,$@,$<,environments/marello/ee)

#
# Marello (MySQL)
#
%-cli-marello-ce-2.0-mysql: %-cli-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-blackfire-marello-ce-2.0-mysql: %-cli-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-xdebug-marello-ce-2.0-mysql: %-cli-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-fpm-marello-ce-2.0-mysql: %-fpm-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-blackfire-marello-ce-2.0-mysql: %-fpm-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-xdebug-marello-ce-2.0-mysql: %-fpm-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-cli-marello-ee-2.0-mysql: %-cli-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-2.0-mysql: %-cli-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-2.0-mysql: %-cli-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-2.0-mysql: %-fpm-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-2.0-mysql: %-fpm-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-2.0-mysql: %-fpm-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)

%-cli-marello-ce-3.0-mysql: %-cli-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-blackfire-marello-ce-3.0-mysql: %-cli-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-xdebug-marello-ce-3.0-mysql: %-cli-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-fpm-marello-ce-3.0-mysql: %-fpm-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-blackfire-marello-ce-3.0-mysql: %-fpm-blackfire-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-xdebug-marello-ce-3.0-mysql: %-fpm-xdebug-oroplatform-ce-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-cli-marello-ee-3.0-mysql: %-cli-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-3.0-mysql: %-cli-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-3.0-mysql: %-cli-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-3.0-mysql: %-fpm-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-3.0-mysql: %-fpm-blackfire-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-3.0-mysql: %-fpm-xdebug-oroplatform-ee-4.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)

ifndef FORCE_BUILD
define build
	docker pull $(REPOSITORY):$(1) || ( docker build --tag $(REPOSITORY):$(1) $(2) && docker push $(REPOSITORY):$(1) )
endef
define build_from
	docker pull $(REPOSITORY):$(1) || ( docker build --build-arg SOURCE_VARIATION=$(2) --tag $(REPOSITORY):$(1) $(3) && docker push $(REPOSITORY):$(1) )
endef
else
define build
	docker build --no-cache --tag $(REPOSITORY):$(1) $(2) && docker push $(REPOSITORY):$@
endef
define build_from
	docker build --no-cache --build-arg SOURCE_VARIATION=$(2) --tag $(REPOSITORY):$(1) $(3) && docker push $(REPOSITORY):$(1)
endef
endif

.DEFAULT_GOAL := help

RED=033[31m
GREEN=033[32m
YELLOW=033[33m
BLUE=033[34m
PURPLE=033[35m
CYAN=033[36m
GREY=033[37m
NC=033[0m

.PHONY: help
help: ## Show this help
help:
	@echo "\n    \${BLUE}Usage: make \${GREEN}target [...target]\${NC}"
	@grep -E '(^[a-zA-Z0-9_.-]+:.*?##.*$$)|(^##)' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
	@echo "\n    \${GREEN}The targets follow the following semantic:\${NC}"
	@echo "\n        \${BLUE}[version]-[flavour]-[application]-[application-version]\${NC}"
	@echo "\n    \${GREEN}eg.\${NC} \${YELLOW}7.2-fpm-xdebug-orocommerce-ee-3.1\${NC}"
	@echo ""
	@echo "    \${BLUE}Versions:\${NC}"
	@echo "      \${GREEN}7.1\${NC}"
	@echo "      \${GREEN}7.2\${NC}"
	@echo "      \${GREEN}7.3\${NC} \${YELLOW}! Experimental\${NC}"
	@echo "      \${GREEN}7.4\${NC} \${YELLOW}! Experimental\${NC}"
	@echo ""
	@echo "    \${BLUE}Flavours:\${NC}"
	@echo "      \${GREEN}fpm\${NC}"
	@echo "      \${GREEN}fpm-blackfire\${NC}"
	@echo "      \${GREEN}fpm-xdebug\${NC}"
	@echo "      \${GREEN}cli\${NC}"
	@echo "      \${GREEN}cli-xdenug\${NC}"
	@echo "      \${GREEN}cli-blackfire\${NC}"
	@echo ""
	@echo "    \${BLUE}Applications:\${NC}"
	@echo "      \${GREEN}oroplatform-ce\${NC}, with versions [\${YELLOW}3.1\${NC}, \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}oroplatform-ee\${NC}, with versions [\${YELLOW}3.1\${NC}, \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}orocommerce-ce\${NC}, with versions [\${YELLOW}1.6\${NC}, \${YELLOW}3.1\${NC}, \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}orocommerce-ee\${NC}, with versions [\${YELLOW}1.6\${NC}, \${YELLOW}3.1\${NC}, \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}orocrm-ce\${NC}, with versions [\${YELLOW}3.1\${NC}), \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}orocrm-ee\${NC}, with versions [\${YELLOW}3.1\${NC}), \${YELLOW}4.1\${NC}]  (\${BLUE}latest LTS: 3.1\${NC})"
	@echo "      \${GREEN}marello-ce\${NC}, with versions [\${YELLOW}2.0\${NC}]  (\${BLUE}latest LTS: 2.0\${NC})"
	@echo "      \${GREEN}marello-ee\${NC}, with versions [\${YELLOW}2.0\${NC}]  (\${BLUE}latest LTS: 2.0\${NC})"
	@echo ""
