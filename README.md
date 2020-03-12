# OneWorkPlace

**Resources:**

- [Drupal](https://www.drupal.org/)
- [DDEV](https://www.ddev.com/)
- [Docker-compose](https://docs.docker.com/compose/)

## Setup local enviroment

You have to install Docker in your machine

- [Mac OS](https://docs.docker.com/docker-for-mac/install/)
- [Windows](https://docs.docker.com/docker-for-windows/install/)
- [Ubuntu](https://docs.docker.com/install/linux/docker-ce/ubuntu/#os-requirements)
- [Debian](https://docs.docker.com/install/linux/docker-ce/debian/)
- [Cent OS](https://docs.docker.com/install/linux/docker-ce/centos/)
- [Fedora](https://docs.docker.com/install/linux/docker-ce/fedora/)

then, install ddev

- [DDEV](https://ddev.readthedocs.io/en/latest/)


### Create .env file
Rename the file `oneworkplace/.env.example` to `oneworkplace/.env` and paste the values for:

### Create local .ddev/config.local.yaml and Override defaults
Create a copy of file `oneworkplace/.ddev/config.yaml` to `oneworkplace/.ddev/config.local.yaml` and override values for router_http_port and xdebug_enabled according to your needs
i.e.
`router_http_port: "8080"`
`xdebug_enabled: true`


### Build the stack

Before start to the creation of the containers, enable locally this setting to avoid memory issues:

[vm.max_map_count](https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html#_set_vm_max_map_count_to_at_least_262144)


###### DDEV

First, run:
```
ddev start
```
and then run, in order to install all composer dependencies
```
ddev composer install
```
For further information about ddev visit https://ddev.readthedocs.io/

## Theme
If you want to make some changes on the theme,
[follow this instructions](web/themes/owp/README.md)

## Export configuration

Run the following command in the root dir:
* ``` sh export.sh ```
