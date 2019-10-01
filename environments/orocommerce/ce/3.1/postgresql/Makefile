export DATABASE = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -j8 -C php\@7.1 $@
	$(MAKE) -j8 -C php\@7.2 $@

.PHONY: clean
clean:
	$(MAKE) -j8 -C php\@7.1 $@
	$(MAKE) -j8 -C php\@7.2 $@

