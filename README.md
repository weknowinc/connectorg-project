# OneWorkPlace

**Resources:**

- [Drupal](https://www.drupal.org/)
- [DDEV](https://www.ddev.com/)

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

### Build the stack

```
ddev start
```
and then install all composer dependencies
```
ddev composer update
```
For further information about ddev visit https://ddev.readthedocs.io/
## Export configuration

Run the following command in the root dir:
1. ``` ddev exec drush cex ```
2. ``` find ./web/profiles/oneworkplace/config/install/ -type f -exec sed -i -e '/^uuid: /d' {} \; ```
3. ``` find ./web/profiles/oneworkplace/config/install/ -type f  -exec sed -i -e '/_core:/,+1d' {} \; ```
3. Finally, delete the following files in the dir config/install: core.extension.yml, update.settings.yml, file.settings.yml.
