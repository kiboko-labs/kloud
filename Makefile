REPOSITORY=kiboko/php

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
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/cli-blackfire)
%-fpm-xdebug-oroplatform-ce-3.1: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/postgresql/php@$*/cli-xdebug)

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
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/cli)
%-cli-blackfire-oroplatform-ce-3.1-mysql: %-cli-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/cli-blackfire)
%-cli-xdebug-oroplatform-ce-3.1-mysql: %-cli-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/cli-xdebug)

%-fpm-oroplatform-ce-3.1-mysql: %-fpm
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/fpm)
%-fpm-blackfire-oroplatform-ce-3.1-mysql: %-fpm-blackfire
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/cli-blackfire)
%-fpm-xdebug-oroplatform-ce-3.1-mysql: %-fpm-xdebug
	$(call build_from,$@,$<,environments/oroplatform/ce/3.1/mysql/php@$*/cli-xdebug)

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
	@echo $@
%-cli-blackfire-orocommerce-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	@echo $@
%-cli-xdebug-orocommerce-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	@echo $@

%-fpm-orocommerce-ce-3.1: %-fpm-oroplatform-ce-3.1
	@echo $@
%-fpm-blackfire-orocommerce-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	@echo $@
%-fpm-xdebug-orocommerce-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	@echo $@

%-cli-orocommerce-ee-3.1: %-cli-oroplatform-ee-3.1
	@echo $@
%-cli-blackfire-orocommerce-ee-3.1: %-cli-blackfire-oroplatform-ee-3.1
	@echo $@
%-cli-xdebug-orocommerce-ee-3.1: %-cli-xdebug-oroplatform-ee-3.1
	@echo $@

%-fpm-orocommerce-ee-3.1: %-fpm-oroplatform-ee-3.1
	@echo $@
%-fpm-blackfire-orocommerce-ee-3.1: %-fpm-blackfire-oroplatform-ee-3.1
	@echo $@
%-fpm-xdebug-orocommerce-ee-3.1: %-fpm-xdebug-oroplatform-ee-3.1
	@echo $@

%-cli-orocrm-ce-3.1: %-cli-oroplatform-ce-3.1
	@echo $@
%-cli-blackfire-orocrm-ce-3.1: %-cli-blackfire-oroplatform-ce-3.1
	@echo $@
%-cli-xdebug-orocrm-ce-3.1: %-cli-xdebug-oroplatform-ce-3.1
	@echo $@

%-fpm-orocrm-ce-3.1: %-fpm-oroplatform-ce-3.1
	@echo $@
%-fpm-blackfire-orocrm-ce-3.1: %-fpm-blackfire-oroplatform-ce-3.1
	@echo $@
%-fpm-xdebug-orocrm-ce-3.1: %-fpm-xdebug-oroplatform-ce-3.1
	@echo $@

%-cli-orocrm-ee-3.1: %-cli-oroplatform-ee-3.1
	@echo $@
%-cli-blackfire-orocrm-ee-3.1: %-cli-blackfire-oroplatform-ee-3.1
	@echo $@
%-cli-xdebug-orocrm-ee-3.1: %-cli-xdebug-oroplatform-ee-3.1
	@echo $@

%-fpm-orocrm-ee-3.1: %-fpm-oroplatform-ee-3.1
	@echo $@
%-fpm-blackfire-orocrm-ee-3.1: %-fpm-blackfire-oroplatform-ee-3.1
	@echo $@
%-fpm-xdebug-orocrm-ee-3.1: %-fpm-xdebug-oroplatform-ee-3.1
	@echo $@

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
	docker build --no-cache --build-arg SOURCE_VARIATION=$(2) --tag $(REPOSITORY):$(1) $(3) && docker push $(REPOSITORY):$@
endef
endif
