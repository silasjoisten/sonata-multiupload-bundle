# vim: set tabstop=8 softtabstop=8 noexpandtab:

install:
	@composer install --no-interaction

cs:
	@php vendor/bin/php-cs-fixer fix

test:
	@php vendor/bin/phpunit
