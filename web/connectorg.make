api: 2
core: 8.x
projects:
  drupal:
    subdir: contrib
    type: core
    version: "8.8.x"
    patch:
      3103529: 'https://www.drupal.org/files/issues/2020-01-29/3103529-22.patch'
      2985882: 'https://www.drupal.org/files/issues/2020-04-08/2985882-field-85.patch'
  balbuf/drupal-libraries-installer:
    subdir: contrib
    type: module
    download:
      type: git
      url: 'git@github.com:balbuf/drupal-libraries-installer.git'
      branch: 8.x-1.x
  cweagans/composer-patches:
    subdir: contrib
    type: module
    version: '^1.6.5'
  address:
    subdir: contrib
    type: module
    version: '~1.0'
  bond:
    subdir: contrib
    type: theme
    version: '1.0.x-dev'
  ctools:
    subdir: contrib
    type: module
    version: '^3.2'
  pathauto:
    subdir: contrib
    type: module
    version: '^1.6'
  redirect_after_login:
    subdir: contrib
    type: module
    version: '^2.6'
  search_api:
    subdir: contrib
    type: module
    version: '^1.16'
  smart_date:
    subdir: contrib
    type: module
    version: '^2.5'
  social_api:
    subdir: contrib
    type: module
    version: '2.x-dev'
  social_auth:
    subdir: contrib
    type: module
    version: '2.x-dev'
  social_auth_facebook:
    subdir: contrib
    type: module
    version: '2.x-dev'
  social_auth_google:
    subdir: contrib
    type: module
    version: '2.x-dev'
  token:
    subdir: contrib
    type: module
    version: '^1.6'
  twig_tweak:
    subdir: contrib
    type: module
    version: '^2.6'
  upgrade_status:
    subdir: contrib
    type: module
    version: '^2.6'
  drush:
    subdir: contrib
    type: module
    version: '^9.7.1 | ^10.0.0'
  eluceo/ical:
    subdir: contrib
    type: module
    version: '^0.16.0'
  symfony/http-foundation:
    subdir: contrib
    type: module
    version: '^4.4.7'
  vlucas/phpdotenv:
    subdir: contrib
    type: module
    version: '^4.0'
  zaporylie/composer-drupal-optimizations:
    subdir: contrib
    type: module
    version: '^1.0'

