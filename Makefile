.PHONY: all
all:
	$(MAKE) -C environments/orocommerce-ee@2.6 build push
	$(MAKE) -C environments/orocommerce-ee@3.1 build push
	$(MAKE) -C environments/oroplatform-ce@4.1 build push
	$(MAKE) -C environments/oroplatform-ce@3.1 build push