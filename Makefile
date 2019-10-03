REPOSITORY=kiboko/php

all: oroplatform orocommerce orocrm marello

oroplatform: oroplatform-ce oroplatform-ee

orocommerce: orocommerce-ce orocommerce-ee

orocrm: orocrm-ce orocrm-ee

marello: marello-ce marello-ee

oroplatform-ce: 7.1-cli-oroplatform-ce-3.1 7.1-cli-blackfire-oroplatform-ce-3.1 7.1-cli-xdebug-oroplatform-ce-3.1 7.1-fpm-oroplatform-ce-3.1 7.1-fpm-blackfire-oroplatform-ce-3.1 7.1-fpm-xdebug-oroplatform-ce-3.1 7.2-cli-oroplatform-ce-3.1 7.2-cli-blackfire-oroplatform-ce-3.1 7.2-cli-xdebug-oroplatform-ce-3.1 7.2-fpm-oroplatform-ce-3.1 7.2-fpm-blackfire-oroplatform-ce-3.1 7.2-fpm-xdebug-oroplatform-ce-3.1

oroplatform-ee: 7.1-cli-oroplatform-ee-3.1 7.1-cli-blackfire-oroplatform-ee-3.1 7.1-cli-xdebug-oroplatform-ee-3.1 7.1-fpm-oroplatform-ee-3.1 7.1-fpm-blackfire-oroplatform-ee-3.1 7.1-fpm-xdebug-oroplatform-ee-3.1 7.2-cli-oroplatform-ee-3.1 7.2-cli-blackfire-oroplatform-ee-3.1 7.2-cli-xdebug-oroplatform-ee-3.1 7.2-fpm-oroplatform-ee-3.1 7.2-fpm-blackfire-oroplatform-ee-3.1 7.2-fpm-xdebug-oroplatform-ee-3.1

orocommerce-ce: 7.1-cli-orocommerce-ce-3.1 7.1-cli-blackfire-orocommerce-ce-3.1 7.1-cli-xdebug-orocommerce-ce-3.1 7.1-fpm-orocommerce-ce-3.1 7.1-fpm-blackfire-orocommerce-ce-3.1 7.1-fpm-xdebug-orocommerce-ce-3.1 7.2-cli-orocommerce-ce-3.1 7.2-cli-blackfire-orocommerce-ce-3.1 7.2-cli-xdebug-orocommerce-ce-3.1 7.2-fpm-orocommerce-ce-3.1 7.2-fpm-blackfire-orocommerce-ce-3.1 7.2-fpm-xdebug-orocommerce-ce-3.1

orocommerce-ee: 7.1-cli-orocommerce-ee-3.1 7.1-cli-blackfire-orocommerce-ee-3.1 7.1-cli-xdebug-orocommerce-ee-3.1 7.1-fpm-orocommerce-ee-3.1 7.1-fpm-blackfire-orocommerce-ee-3.1 7.1-fpm-xdebug-orocommerce-ee-3.1 7.2-cli-orocommerce-ee-3.1 7.2-cli-blackfire-orocommerce-ee-3.1 7.2-cli-xdebug-orocommerce-ee-3.1 7.2-fpm-orocommerce-ee-3.1 7.2-fpm-blackfire-orocommerce-ee-3.1 7.2-fpm-xdebug-orocommerce-ee-3.1

orocrm-ce: 7.1-cli-orocrm-ce-3.1 7.1-cli-blackfire-orocrm-ce-3.1 7.1-cli-xdebug-orocrm-ce-3.1 7.1-fpm-orocrm-ce-3.1 7.1-fpm-blackfire-orocrm-ce-3.1 7.1-fpm-xdebug-orocrm-ce-3.1 7.2-cli-orocrm-ce-3.1 7.2-cli-blackfire-orocrm-ce-3.1 7.2-cli-xdebug-orocrm-ce-3.1 7.2-fpm-orocrm-ce-3.1 7.2-fpm-blackfire-orocrm-ce-3.1 7.2-fpm-xdebug-orocrm-ce-3.1

orocrm-ee: 7.1-cli-orocrm-ee-3.1 7.1-cli-blackfire-orocrm-ee-3.1 7.1-cli-xdebug-orocrm-ee-3.1 7.1-fpm-orocrm-ee-3.1 7.1-fpm-blackfire-orocrm-ee-3.1 7.1-fpm-xdebug-orocrm-ee-3.1 7.2-cli-orocrm-ee-3.1 7.2-cli-blackfire-orocrm-ee-3.1 7.2-cli-xdebug-orocrm-ee-3.1 7.2-fpm-orocrm-ee-3.1 7.2-fpm-blackfire-orocrm-ee-3.1 7.2-fpm-xdebug-orocrm-ee-3.1

marello-ce: 7.1-cli-marello-ce-3.1 7.1-cli-blackfire-marello-ce-3.1 7.1-cli-xdebug-marello-ce-3.1 7.1-fpm-marello-ce-3.1 7.1-fpm-blackfire-marello-ce-3.1 7.1-fpm-xdebug-marello-ce-3.1 7.2-cli-marello-ce-3.1 7.2-cli-blackfire-marello-ce-3.1 7.2-cli-xdebug-marello-ce-3.1 7.2-fpm-marello-ce-3.1 7.2-fpm-blackfire-marello-ce-3.1 7.2-fpm-xdebug-marello-ce-3.1

marello-ee: 7.1-cli-marello-ee-3.1 7.1-cli-blackfire-marello-ee-3.1 7.1-cli-xdebug-marello-ee-3.1 7.1-fpm-marello-ee-3.1 7.1-fpm-blackfire-marello-ee-3.1 7.1-fpm-xdebug-marello-ee-3.1 7.2-cli-marello-ee-3.1 7.2-cli-blackfire-marello-ee-3.1 7.2-cli-xdebug-marello-ee-3.1 7.2-fpm-marello-ee-3.1 7.2-fpm-blackfire-marello-ee-3.1 7.2-fpm-xdebug-marello-ee-3.1

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

%-cli-oroplatform-ce-3.1: %-cli
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/cli)
%-cli-blackfire-oroplatform-ce-3.1: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/cli-blackfire)
%-cli-xdebug-oroplatform-ce-3.1: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/cli-xdebug)

%-fpm-oroplatform-ce-3.1: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/fpm)
%-fpm-blackfire-oroplatform-ce-3.1: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/fpm-blackfire)
%-fpm-xdebug-oroplatform-ce-3.1: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/fpm-xdebug)

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

%-cli-orocommerce-ce-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*/cli)
%-cli-blackfire-orocommerce-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*/cli-blackfire)
%-cli-xdebug-orocommerce-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*/cli-xdebug)

%-fpm-orocommerce-ce-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*/fpm)
%-fpm-blackfire-orocommerce-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/orocommerce/php@$*/fpm-blackfire)
%-fpm-xdebug-orocommerce-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocommerce/ce/3.1/postgresql/php@$*/fpm-xdebug)

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

%-cli-orocrm-ce-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*/cli)
%-cli-blackfire-orocrm-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*/cli-blackfire)
%-cli-xdebug-orocrm-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*/cli-xdebug)

%-fpm-orocrm-ce-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*/fpm)
%-fpm-blackfire-orocrm-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/orocrm/php@$*/fpm-blackfire)
%-fpm-xdebug-orocrm-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/orocrm/ce/3.1/postgresql/php@$*/fpm-xdebug)

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

%-cli-marello-ce-3.1: %-cli-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*/cli)
%-cli-blackfire-marello-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*/cli-blackfire)
%-cli-xdebug-marello-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*/cli-xdebug)

%-fpm-marello-ce-3.1: %-fpm-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*/fpm)
%-fpm-blackfire-marello-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/marello/php@$*/fpm-blackfire)
%-fpm-xdebug-marello-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	$(call build_from,$@,$<,environments/marello/ce/3.1/postgresql/php@$*/fpm-xdebug)

%-cli-marello-ee-3.1: %-cli-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-3.1: %-cli-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-3.1: %-cli-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-3.1: %-fpm-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-3.1: %-fpm-blackfire-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-3.1: %-fpm-xdebug-oroplatform-ee-3.1
	$(call build_from,$@,$<,environments/marello/ee)

%-cli-marello-ce-3.1-mysql: %-cli-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-blackfire-marello-ce-3.1-mysql: %-cli-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-cli-xdebug-marello-ce-3.1-mysql: %-cli-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-fpm-marello-ce-3.1-mysql: %-fpm-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-blackfire-marello-ce-3.1-mysql: %-fpm-blackfire-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)
%-fpm-xdebug-marello-ce-3.1-mysql: %-fpm-xdebug-oroplatform-ce-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ce/3.1/mysql/php@$*)

%-cli-marello-ee-3.1-mysql: %-cli-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-blackfire-marello-ee-3.1-mysql: %-cli-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-cli-xdebug-marello-ee-3.1-mysql: %-cli-xdebug-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)

%-fpm-marello-ee-3.1-mysql: %-fpm-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-blackfire-marello-ee-3.1-mysql: %-fpm-blackfire-oroplatform-ee-3.1-mysql
	$(call build_from,$@,$<,environments/marello/ee)
%-fpm-xdebug-marello-ee-3.1-mysql: %-fpm-xdebug-oroplatform-ee-3.1-mysql
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
