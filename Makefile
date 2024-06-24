install-libs:
	composer install

update-libs:
	composer update

install-composer-scripts:
	composer run-script post-root-package-install
	composer run-script post-update-cmd # возможно, закомментировать
	composer run-script post-create-project-cmd

create-files-link:
	php artisan storage:link

db-seed:
	php artisan db:seed

install: install-libs install-composer-scripts create-files-link db-seed

setup: install

build: install

compile: install
