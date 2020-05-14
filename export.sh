ddev exec drush cex --destination ./profiles/connectorg/config/install/
find ./web/profiles/connectorg/config/install/ -type f -exec sed -i -e '/^uuid: /d' {} \;
find ./web/profiles/connectorg/config/install/ -type f  -exec sed -i -e '/_core:/,+1d' {} \;

rm -f ./web/profiles/connectorg/config/install/core.extension.yml ./web/profiles/connectorg/config/install/update.settings.yml ./web/profiles/connectorg/config/install/file.settings.yml
