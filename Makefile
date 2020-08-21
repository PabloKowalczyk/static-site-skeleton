watch-assets:
	docker-compose run --user=node node_builder yarn watch

deploy-dev:
	ansible-playbook --vault-password-file=./.ansible-password.txt -i ./resources/ansible/inventory ./resources/ansible/deploy.yml
