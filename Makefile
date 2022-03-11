# vim: set tabstop=8 softtabstop=8 noexpandtab:

.PHONY: vendor
vendor:
	@symfony composer install --no-interaction

.PHONY: cs
cs:
	@symfony php vendor/bin/php-cs-fixer fix

.PHONY: tests
tests: vendor ## Runs unit tests with phpunit/phpunit
	mkdir -p .build/phpunit
	symfony php vendor/bin/phpunit --configuration=phpunit.xml.dist --testsuite=tests

