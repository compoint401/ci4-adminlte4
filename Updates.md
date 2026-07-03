composer create-project codeigniter4/appstarter ci4-adminlte4
cd ci4-adminlte4\
cp env .env
php spark key:generate
composer require codeigniter4/shield
php spark shield:setup
change in app/config/app.php following to 
  public string $indexPage = 'index.php';
  public string $indexPage = '';
php spark shield:user create -n Admin -e admin@example.com
php spark shield:user addgroup -e admin@example.com -g superadmin

