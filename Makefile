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

generate-permissions:
	 php artisan permissions:sync -Y

regenerate-permissions:
	php artisan permissions:sync -CY

db-seed:
	php artisan db:seed

reset-db:
	php artisan migrate:refresh

rerun-db: reset-db regenerate-permissions db-seed

install: install-libs install-composer-scripts generate-permissions create-files-link db-seed

setup: install

build: install

compile: install
