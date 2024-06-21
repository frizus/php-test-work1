install-libs:
	composer install

update-libs:
	composer update

install-composer-scripts:
	composer run-script post-root-package-install
	composer run-script post-update-cmd # возможно, закомментировать
	composer run-script post-create-project-cmd

install: install-libs install-composer-scripts

setup: install

build: install

compile: install
