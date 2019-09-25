export PLATFORM = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all: ce ee

.PHONY: ce
ce:
	$(MAKE) -C ce

.PHONY: ee
ee:
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,oroplatform-ee-3.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,oroplatform-ee-3.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,oroplatform-ee-3.1);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-4.1,oroplatform-ce-4.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-4.1,oroplatform-ce-4.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-4.1,oroplatform-ce-4.1);)

	$(foreach version, 7.1 7.2, $(call alias_php_light_image,$(version),oroplatform-ce-3.1-mysql,oroplatform-ee-3.1-mysql);)
	$(foreach version, 7.1 7.2, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1-mysql,oroplatform-ee-3.1-mysql);)
	$(foreach version, 7.1 7.2, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1-mysql,oroplatform-ee-3.1-mysql);)

	$(foreach version, 7.1 7.2, $(call alias_php_light_image,$(version),oroplatform-ce-4.1-mysql,oroplatform-ce-4.1-mysql);)
	$(foreach version, 7.1 7.2, $(call alias_php_blackfire_image,$(version),oroplatform-ce-4.1-mysql,oroplatform-ce-4.1-mysql);)
	$(foreach version, 7.1 7.2, $(call alias_php_xdebug_image,$(version),oroplatform-ce-4.1-mysql,oroplatform-ce-4.1-mysql);)

define alias_php_light_image
	$(call alias_php_image,$(1),cli,$(2),$(3))
	$(call alias_php_image,$(1),fpm,$(2),$(3))
endef

define alias_php_blackfire_image
	$(call alias_php_image,$(1),cli-blackfire,$(2),$(3))
	$(call alias_php_image,$(1),fpm-blackfire,$(2),$(3))
endef

define alias_php_xdebug_image
	$(call alias_php_image,$(1),cli-xdebug,$(2),$(3))
	$(call alias_php_image,$(1),fpm-xdebug,$(2),$(3))
endef

define alias_php_image
	$(call alias_image,php,$(1),$(2),$(3),$(4))
endef

define alias_image
	docker tag kiboko/$(1):$(2)-$(3)-$(4) kiboko/$(1):$(2)-$(3)-$(5)
	docker push kiboko/$(1):$(2)-$(3)-$(5)
endef