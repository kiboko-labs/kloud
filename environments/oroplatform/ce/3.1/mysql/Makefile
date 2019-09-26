export DATABASE = $(subst @,-,$(shell basename $(CURDIR)))

.PHONY: all
all:
	$(MAKE) -C php\@7.1 $@
	$(MAKE) -C php\@7.2 $@
	$(MAKE) -C php\@7.3 $@
	$(MAKE) -C php\@7.4 $@

.PHONY: clean
clean:
	$(MAKE) -C php\@7.1 $@
	$(MAKE) -C php\@7.2 $@
	$(MAKE) -C php\@7.3 $@
	$(MAKE) -C php\@7.4 $@

