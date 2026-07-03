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

Error :
'No input file specified.' error

The 'No input file specified.' error in CodeIgniter 4 is a server-level PHP error that happens when your web server (Apache or Nginx) passes an incorrect file path to PHP-FPM or FastCGI. This usually happens because of a misconfigured .htaccess file when trying to remove index.php from your URL, or because your server requires a query string format to process routes.Here are the step-by-step methods to fix this problem.Method 1: Add a Question Mark to your .htaccess File (Apache)Many shared hosting environments require a query string (?) after index.php to correctly forward the request parameters.Open the .htaccess file located inside your public/ folder.Look for the RewriteRule line near the bottom.Change it to include a ? right after index.php:apache# Before
RewriteRule ^([\s\S]\*)$ index.php/$1 [L,NC,QSA]

# After (Change to this)

RewriteRule ^([\s\S]\*)$ index.php?/$1 [L,NC,QSA]
