ddev exec drush cex --destination ./profiles/oneworkplace/config/install/
find ./web/profiles/oneworkplace/config/install/ -type f -exec sed -i -e '/^uuid: /d' {} \;
find ./web/profiles/oneworkplace/config/install/ -type f  -exec sed -i -e '/_core:/,+1d' {} \;

rm -f ./web/profiles/oneworkplace/config/install/core.extension.yml ./web/profiles/oneworkplace/config/install/update.settings.yml ./web/profiles/oneworkplace/config/install/file.settings.yml
