CIVI_CORE="${WEB_ROOT}/sites/all/modules/civicrm"
CIVI_FILES="${WEB_ROOT}/sites/default/files/civicrm"
CIVI_TEMPLATEC="${CIVI_FILES}/templates_c"
CIVI_DOMAIN_NAME="Chatbot demo"
CIVI_DOMAIN_EMAIL="\"Chatbot demo\" <chatbot@example.org>"
CIVI_SETTINGS="${WEB_ROOT}/sites/default/civicrm.settings.php"
CIVI_UF="Drupal"

# Install Drupal and CiviCRM
amp_install
drupal_install
civicrm_install

# Create chat user
drush user-create chat --password=chat --mail=chat@example.com

# Site name, frontpage and some Drupal niceties
drush vset site_name "Chatbot demo site"
drush en -y pathauto
drush dis -y overlay shortcut
drush vset site_frontpage "node/1"
drush scr "$SITE_CONFIG_DIR/install/frontpage.php"

# CiviCM theme setup
drush en -y civicrmtheme tivy
drush vset civicrmtheme_theme_admin tivy
drush sql-query "UPDATE block SET status= 0, region = -1 WHERE theme = 'tivy'"
drush sql-query "UPDATE block SET status= 1, region = 'main' WHERE theme = 'tivy' AND module = 'system' AND delta = 'main'"
drush sql-query "UPDATE block SET status= 1, region = 'right' WHERE theme = 'tivy' AND module = 'civicrm' AND delta = '2'"

# Enable CiviCRM extensions
cv ext:enable org.civicrm.shoreditch
cv api setting.create customCSSURL=$CMS_URL/sites/all/modules/civicrm/tools/extensions/org.civicrm.shoreditch/css/custom-civicrm.css
cv ext:enable chatbot

drush role-create 'civicrm user'
drush role-add-perm 'civicrm user' 'access CiviCRM'
drush role-add-perm 'civicrm user' 'administer CiviCRM'
drush user-add-role 'civicrm user' chat
