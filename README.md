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
* ``` sh export.sh ```
