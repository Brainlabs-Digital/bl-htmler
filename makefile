unit:
	vendor/bin/phpunit tests/unit

unit-cov:
	vendor/bin/phpunit --coverage-html coverage-unit tests/unit

phpcs:
	vendor/bin/phpcs

phan:
	vendor/bin/phan