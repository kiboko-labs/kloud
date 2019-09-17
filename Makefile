.PHONY: all
all: oroplatform orocommerce orocrm marello

.PHONY: oroplatform
oroplatform:
	$(MAKE) -C environments/oroplatform all

.PHONY: orocommerce
orocommerce:
	$(MAKE) -C environments/orocommerce-ce@3.1 push
	$(MAKE) -C environments/orocommerce-ee@1.6 push
	$(MAKE) -C environments/orocommerce-ee@3.1 push

.PHONY: orocrm
orocrm:
	$(MAKE) -C environments/orocrm all

.PHONY: marello
marello:
	$(MAKE) -C environments/marello all
