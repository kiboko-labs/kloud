.PHONY: all
all: oroplatform orocommerce orocrm marello

.PHONY: native
native:
	$(MAKE) -C environments/native all

.PHONY: oroplatform
oroplatform:
	$(MAKE) -C environments/oroplatform all

.PHONY: orocommerce
orocommerce: oroplatform
	$(MAKE) -C environments/orocommerce all

.PHONY: orocrm
orocrm: oroplatform
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,orocrm-ce-3.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,orocrm-ce-3.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,orocrm-ce-3.1);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,orocrm-ee-3.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,orocrm-ee-3.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,orocrm-ee-3.1);)

.PHONY: marello
marello: oroplatform
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ce-2.0);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ce-2.0);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ce-2.0);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ce-2.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ce-2.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ce-2.1);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ce-2.2);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ce-2.2);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ce-2.2);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ee-2.0);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ee-2.0);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ee-2.0);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ee-2.1);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ee-2.1);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ee-2.1);)

	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_light_image,$(version),oroplatform-ce-3.1,marello-ee-2.2);)
	$(foreach version, 7.1 7.2 7.3, $(call alias_php_blackfire_image,$(version),oroplatform-ce-3.1,marello-ee-2.2);)
	$(foreach version, 7.1 7.2 7.3 7.4, $(call alias_php_xdebug_image,$(version),oroplatform-ce-3.1,marello-ee-2.2);)

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
