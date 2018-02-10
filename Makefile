.PHONY: test

test-integration:
	./vendor/bin/peridot test/integration
test:
	./vendor/bin/peridot test/unit
