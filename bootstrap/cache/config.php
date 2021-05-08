<?php return array (
  'activitylog' => 
  array (
    'enabled' => true,
    'delete_records_older_than_days' => 365,
    'default_log_name' => 'default',
    'default_auth_driver' => NULL,
    'subject_returns_soft_deleted_models' => false,
    'activity_model' => 'Spatie\\Activitylog\\Models\\Activity',
    'table_name' => 'activity_log',
    'database_connection' => NULL,
  ),
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://127.0.0.1:8000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'available_locales' => 
    array (
      0 => 'en',
      1 => 'ar',
    ),
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:E+TTFvuoBDQcES3PXK5TFHJ3V9am36pn6Y8uSSMpzKU=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Joovlly\\DDD\\DomainDriverDesignServiceProvider',
      23 => 'Barryvdh\\DomPDF\\ServiceProvider',
      24 => 'App\\Common\\Providers\\DomainServiceProvider',
      25 => 'App\\Domain\\User\\Providers\\DomainServiceProvider',
      26 => 'App\\Domain\\Category\\Providers\\DomainServiceProvider',
      27 => 'App\\Domain\\Post\\Providers\\DomainServiceProvider',
      28 => 'App\\Domain\\Order\\Providers\\DomainServiceProvider',
      29 => 'App\\Domain\\Discount\\Providers\\DomainServiceProvider',
      30 => 'App\\Domain\\Product\\Providers\\DomainServiceProvider',
      31 => 'App\\Domain\\Location\\Providers\\DomainServiceProvider',
      32 => 'App\\Domain\\Ingredient\\Providers\\DomainServiceProvider',
      33 => 'App\\Domain\\Dashboard\\Providers\\DomainServiceProvider',
      34 => 'App\\Domain\\Branch\\Providers\\DomainServiceProvider',
      35 => 'App\\Domain\\Reservation\\Providers\\DomainServiceProvider',
      36 => 'App\\Domain\\Accommodation\\Providers\\DomainServiceProvider',
      37 => 'App\\Domain\\Website\\Providers\\DomainServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
      'Sms' => 'Joovlly\\SMS\\Facades\\SMS',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Toaster' => 'Joovlly\\Toaster\\Facades\\Toaster',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'jwt',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'socialite' => 
    array (
      'drivers' => 
      array (
        0 => 'google',
        1 => 'facebook',
        2 => 'twitter',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Domain\\User\\Entities\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'useTLS' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/home/badawy/Joovlly/qalzam/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'laravel_cache',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'graphql',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'qalzam',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'enlighten' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'enlighten',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'qalzam',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => false,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'qalzam',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => '',
        'host' => '2.tcp.ngrok.io',
        'port' => '10751',
        'database' => 'Clinic',
        'username' => 'Clinic9Application',
        'password' => 'ClinicNines@',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'days' => 
  array (
    'days' => 
    array (
      0 => 'saturday',
      1 => 'sunday',
      2 => 'monday',
      3 => 'tuesday',
      4 => 'wednesday',
      5 => 'thursday',
      6 => 'friday',
    ),
  ),
  'enlighten' => 
  array (
    'enabled' => true,
    'developer_mode' => true,
    'editor' => 'sublime',
    'tests' => 
    array (
      'ignore' => 
      array (
      ),
    ),
    'request' => 
    array (
      'headers' => 
      array (
        'hide' => 
        array (
        ),
        'overwrite' => 
        array (
        ),
      ),
      'query' => 
      array (
        'hide' => 
        array (
        ),
        'overwrite' => 
        array (
        ),
      ),
      'input' => 
      array (
        'hide' => 
        array (
        ),
        'overwrite' => 
        array (
        ),
      ),
    ),
    'response' => 
    array (
      'headers' => 
      array (
        'hide' => 
        array (
        ),
        'overwrite' => 
        array (
        ),
      ),
      'body' => 
      array (
        'hide' => 
        array (
        ),
        'overwrite' => 
        array (
        ),
      ),
    ),
    'session' => 
    array (
      'hide' => 
      array (
      ),
      'overwrite' => 
      array (
      ),
    ),
    'modules' => 
    array (
      0 => 
      array (
        'name' => 'Stocks',
        'pattern' => 
        array (
          0 => '*Stock*',
        ),
      ),
      1 => 
      array (
        'name' => 'Wishlist',
        'pattern' => 
        array (
          0 => '*Wishlist*',
        ),
      ),
      2 => 
      array (
        'name' => 'Cart',
        'pattern' => 
        array (
          0 => '*Cart*',
        ),
      ),
      3 => 
      array (
        'name' => 'Discounts',
        'pattern' => 
        array (
          0 => '*Discount*',
        ),
      ),
      4 => 
      array (
        'name' => 'Addresses',
        'pattern' => 
        array (
          0 => '*Address*',
        ),
      ),
      5 => 
      array (
        'name' => 'Notifications',
        'pattern' => 
        array (
          0 => '*Notification*',
        ),
      ),
      6 => 
      array (
        'name' => 'Orders',
        'pattern' => 
        array (
          0 => '*Order*',
        ),
      ),
      7 => 
      array (
        'name' => 'Users',
        'pattern' => 
        array (
          0 => '*User*',
        ),
      ),
      8 => 
      array (
        'name' => 'Competitions',
        'pattern' => 
        array (
          0 => '*Competition*',
        ),
      ),
      9 => 
      array (
        'name' => 'Child',
        'pattern' => 
        array (
          0 => '*Child*',
        ),
      ),
      10 => 
      array (
        'name' => 'ProductVariations',
        'pattern' => 
        array (
          0 => '*ProductVariation*',
        ),
      ),
      11 => 
      array (
        'name' => 'ProductVariationTypes',
        'pattern' => 
        array (
          0 => '*ProductVariationType*',
        ),
      ),
      12 => 
      array (
        'name' => 'Products',
        'pattern' => 
        array (
          0 => '*Product*',
        ),
      ),
      13 => 
      array (
        'name' => 'Locations',
        'pattern' => 
        array (
          0 => '*Location*',
        ),
      ),
      14 => 
      array (
        'name' => 'Feeds',
        'pattern' => 
        array (
          0 => '*Feed*',
        ),
      ),
      15 => 
      array (
        'name' => 'Ingredients',
        'pattern' => 
        array (
          0 => '*Ingredient*',
        ),
      ),
      16 => 
      array (
        'name' => 'Categories',
        'pattern' => 
        array (
          0 => '*Categories*',
          1 => '*Category*',
        ),
      ),
      17 => 
      array (
        'name' => 'Posts',
        'pattern' => 
        array (
          0 => '*Post*',
        ),
      ),
      18 => 
      array (
        'name' => 'Other Modules',
        'pattern' => 
        array (
          0 => '*',
        ),
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/home/badawy/Joovlly/qalzam/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/home/badawy/Joovlly/qalzam/storage/app/public',
        'url' => 'http://127.0.0.1:8000/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
      ),
    ),
    'links' => 
    array (
      '/home/badawy/Joovlly/qalzam/public/storage' => '/home/badawy/Joovlly/qalzam/storage/app/public',
    ),
  ),
  'firebase' => 
  array (
    'default' => 'app',
    'projects' => 
    array (
      'app' => 
      array (
        'credentials' => 
        array (
          'file' => NULL,
          'auto_discovery' => true,
        ),
        'database' => 
        array (
          'url' => NULL,
        ),
        'dynamic_links' => 
        array (
          'default_domain' => NULL,
        ),
        'storage' => 
        array (
          'default_bucket' => NULL,
        ),
        'cache_store' => 'file',
        'logging' => 
        array (
          'http_log_channel' => NULL,
          'http_debug_log_channel' => NULL,
        ),
        'http_client_options' => 
        array (
          'proxy' => NULL,
          'timeout' => NULL,
        ),
        'debug' => false,
      ),
    ),
    'credentials' => 
    array (
      'file' => NULL,
      'auto_discovery' => true,
    ),
    'database' => 
    array (
      'url' => NULL,
    ),
    'dynamic_links' => 
    array (
      'default_domain' => NULL,
    ),
    'storage' => 
    array (
      'default_bucket' => NULL,
    ),
    'cache_store' => 'file',
    'logging' => 
    array (
      'http_log_channel' => NULL,
      'http_debug_log_channel' => NULL,
    ),
    'debug' => false,
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'jwt' => 
  array (
    'secret' => 'DsG303fThJFeRzRnRuhMyfAgLtfCgXvS7magV52rtUF3Zy5UlSiOH3HWy7gsjpF4',
    'keys' => 
    array (
      'public' => NULL,
      'private' => NULL,
      'passphrase' => NULL,
    ),
    'ttl' => NULL,
    'refresh_ttl' => NULL,
    'algo' => 'HS256',
    'required_claims' => 
    array (
      0 => 'iss',
      1 => 'iat',
      2 => 'nbf',
      3 => 'sub',
      4 => 'jti',
    ),
    'persistent_claims' => 
    array (
    ),
    'lock_subject' => true,
    'leeway' => 0,
    'blacklist_enabled' => true,
    'blacklist_grace_period' => 0,
    'decrypt_cookies' => false,
    'providers' => 
    array (
      'jwt' => 'Tymon\\JWTAuth\\Providers\\JWT\\Namshi',
      'auth' => 'Tymon\\JWTAuth\\Providers\\Auth\\Illuminate',
      'storage' => 'Tymon\\JWTAuth\\Providers\\Storage\\Illuminate',
    ),
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => '/home/badawy/Joovlly/qalzam/resources/views/livewire',
    'layout' => 'layouts.app',
    'asset_url' => NULL,
    'middleware_group' => 'web',
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
    ),
    'manifest_path' => NULL,
  ),
  'livewire-datatables' => 
  array (
    'default_time_format' => 'H:i',
    'default_date_format' => 'd/m/Y',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/home/badawy/Joovlly/qalzam/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/home/badawy/Joovlly/qalzam/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/home/badawy/Joovlly/qalzam/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'mailhog',
        'port' => '1025',
        'encryption' => NULL,
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'stream' => 
      array (
        'ssl' => 
        array (
          'allow_self_signed' => true,
          'verify_peer' => false,
          'verify_peer_name' => false,
        ),
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
    ),
    'from' => 
    array (
      'address' => NULL,
      'name' => 'Laravel',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/home/badawy/Joovlly/qalzam/resources/views/vendor/mail',
      ),
    ),
  ),
  'media-library' => 
  array (
    'disk_name' => 'public',
    'max_file_size' => 31457280,
    'queue_name' => '',
    'queue_conversions_by_default' => true,
    'media_model' => 'Spatie\\MediaLibrary\\MediaCollections\\Models\\Media',
    'remote' => 
    array (
      'extra_headers' => 
      array (
        'CacheControl' => 'max-age=604800',
      ),
    ),
    'responsive_images' => 
    array (
      'width_calculator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\WidthCalculator\\FileSizeOptimizedWidthCalculator',
      'use_tiny_placeholders' => true,
      'tiny_placeholder_generator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\TinyPlaceholderGenerator\\Blurred',
    ),
    'default_loading_attribute_value' => NULL,
    'conversion_file_namer' => 'Spatie\\MediaLibrary\\Conversions\\DefaultConversionFileNamer',
    'path_generator' => 'Spatie\\MediaLibrary\\Support\\PathGenerator\\DefaultPathGenerator',
    'url_generator' => 'Spatie\\MediaLibrary\\Support\\UrlGenerator\\DefaultUrlGenerator',
    'version_urls' => false,
    'image_optimizers' => 
    array (
      'Spatie\\ImageOptimizer\\Optimizers\\Jpegoptim' => 
      array (
        0 => '--strip-all',
        1 => '--all-progressive',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Pngquant' => 
      array (
        0 => '--force',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Optipng' => 
      array (
        0 => '-i0',
        1 => '-o2',
        2 => '-quiet',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Svgo' => 
      array (
        0 => '--disable=cleanupIDs',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Gifsicle' => 
      array (
        0 => '-b',
        1 => '-O3',
      ),
    ),
    'image_generators' => 
    array (
      0 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Image',
      1 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Webp',
      2 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Pdf',
      3 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Svg',
      4 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Video',
    ),
    'image_driver' => 'gd',
    'ffmpeg_path' => '/usr/bin/ffmpeg',
    'ffprobe_path' => '/usr/bin/ffprobe',
    'temporary_directory_path' => NULL,
    'jobs' => 
    array (
      'perform_conversions' => 'Spatie\\MediaLibrary\\Conversions\\Jobs\\PerformConversionsJob',
      'generate_responsive_images' => 'Spatie\\MediaLibrary\\ResponsiveImages\\Jobs\\GenerateResponsiveImagesJob',
    ),
    'media_downloader' => 'Spatie\\MediaLibrary\\Downloaders\\DefaultDownloader',
  ),
  'qalzam' => 
  array (
    'pagination' => 20,
    'remindable' => 
    array (
      'expiration' => 1,
    ),
    'currency' => 'ar_SA',
    'dashboard-prefix' => 'admin-panel',
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'suffix' => NULL,
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'reviewable' => 
  array (
    'models' => 
    array (
      'author' => 'App\\Domain\\User\\Entities\\User',
      'review' => 'Joovlly\\Reviewable\\Models\\Review',
    ),
    'reviews_table_name' => 'reviews',
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/home/badawy/Joovlly/qalzam/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/home/badawy/Joovlly/qalzam/resources/views',
    ),
    'compiled' => '/home/badawy/Joovlly/qalzam/storage/framework/views',
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => '/home/badawy/Joovlly/qalzam/storage/fonts/',
      'font_cache' => '/home/badawy/Joovlly/qalzam/storage/fonts/',
      'temp_dir' => '/tmp',
      'chroot' => '/home/badawy/Joovlly/qalzam',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'pdf' => 
  array (
    'mode' => '',
    'format' => 'A4',
    'default_font_size' => '12',
    'default_font' => 'sans-serif',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_header' => 0,
    'margin_footer' => 0,
    'orientation' => 'P',
    'title' => 'Laravel mPDF',
    'author' => '',
    'watermark' => '',
    'show_watermark' => false,
    'watermark_font' => 'sans-serif',
    'display_mode' => 'fullpage',
    'watermark_text_alpha' => 0.1,
    'custom_font_dir' => '',
    'custom_font_data' => 
    array (
    ),
    'auto_language_detection' => false,
    'temp_dir' => '/tmp',
    'pdfa' => false,
    'pdfaauto' => false,
  ),
  'flare' => 
  array (
    'key' => NULL,
    'reporting' => 
    array (
      'anonymize_ips' => true,
      'collect_git_information' => false,
      'report_queries' => true,
      'maximum_number_of_collected_queries' => 200,
      'report_query_bindings' => true,
      'report_view_data' => true,
      'grouping_type' => NULL,
      'report_logs' => true,
      'maximum_number_of_collected_logs' => 200,
      'censor_request_body_fields' => 
      array (
        0 => 'password',
      ),
    ),
    'send_logs_as_events' => true,
    'censor_request_body_fields' => 
    array (
      0 => 'password',
    ),
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'light',
    'enable_share_button' => true,
    'register_commands' => false,
    'ignored_solution_providers' => 
    array (
      0 => 'Facade\\Ignition\\SolutionProviders\\MissingPackageSolutionProvider',
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'commentable' => 
  array (
    'model' => 'Joovlly\\Commentable\\Models\\Comment',
    'user' => 'App\\Domains\\User\\Entities\\User',
    'allow_uuid' => false,
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => '/home/badawy/Joovlly/qalzam/storage/framework/laravel-excel',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'image-optimizer' => 
  array (
    'optimizers' => 
    array (
      'Spatie\\ImageOptimizer\\Optimizers\\Jpegoptim' => 
      array (
        0 => '-m85',
        1 => '--strip-all',
        2 => '--all-progressive',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Pngquant' => 
      array (
        0 => '--force',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Optipng' => 
      array (
        0 => '-i0',
        1 => '-o2',
        2 => '-quiet',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Svgo' => 
      array (
        0 => '--disable=cleanupIDs',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Gifsicle' => 
      array (
        0 => '-b',
        1 => '-O3',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Cwebp' => 
      array (
        0 => '-m 6',
        1 => '-pass 10',
        2 => '-mt',
        3 => '-q 90',
      ),
    ),
    'binary_path' => '',
    'timeout' => 60,
    'log_optimizer_activity' => false,
  ),
  'datatables-buttons' => 
  array (
    'namespace' => 
    array (
      'base' => 'DataTables',
      'model' => '',
    ),
    'pdf_generator' => 'snappy',
    'snappy' => 
    array (
      'options' => 
      array (
        'no-outline' => true,
        'margin-left' => '0',
        'margin-right' => '0',
        'margin-top' => '10mm',
        'margin-bottom' => '10mm',
      ),
      'orientation' => 'landscape',
    ),
    'parameters' => 
    array (
      'dom' => 'Bfrtip',
      'order' => 
      array (
        0 => 
        array (
          0 => 0,
          1 => 'desc',
        ),
      ),
      'buttons' => 
      array (
        0 => 'create',
        1 => 'export',
        2 => 'print',
        3 => 'reset',
        4 => 'reload',
      ),
    ),
    'generator' => 
    array (
      'columns' => 'id,add your columns,created_at,updated_at',
      'buttons' => 'create,export,print,reset,reload',
      'dom' => 'Bfrtip',
    ),
  ),
  'datatables-html' => 
  array (
    'namespace' => 'LaravelDataTables',
    'table' => 
    array (
      'class' => 'table',
      'id' => 'dataTableBuilder',
    ),
    'callback' => 
    array (
      0 => '$',
      1 => '$.',
      2 => 'function',
    ),
    'script' => 'datatables::script',
    'editor' => 'datatables::editor',
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
      'starts_with' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 94,
  ),
  'ddd' => 
  array (
    'path' => 'Domain',
    'migrations' => true,
    'factories' => true,
    'observers' => true,
    'views' => true,
    'translations' => true,
    'commands' => true,
    'layout' => 
    array (
      0 => 'lte',
      1 => 
      array (
        'compacted' => true,
      ),
    ),
    'structure' => 
    array (
      'base' => 
      array (
        'Common' => 
        array (
          'Commands' => 
          array (
          ),
          'Exceptions' => 
          array (
            0 => 'Handler.php',
          ),
          'Helpers' => 
          array (
            0 => 'UploadHelper.php',
            1 => 'Enums.php',
            2 => 'Lang.php',
            3 => 'Main.php',
            4 => 'QueryHelpers.php',
          ),
          'Http' => 
          array (
            'Middleware' => 
            array (
              0 => 'Admin.php',
              1 => 'Authenticate.php',
              2 => 'CheckForMaintenanceMode.php',
              3 => 'Cors.php',
              4 => 'EncryptCookies.php',
              5 => 'LangMiddleware.php',
              6 => 'RedirectIfAuthenticated.php',
              7 => 'TrimStrings.php',
              8 => 'TrustProxies.php',
              9 => 'VerifyCsrfToken.php',
            ),
            0 => 'Kernel.php',
          ),
          'Console' => 
          array (
            0 => 'Kernel.php',
          ),
          'Providers' => 
          array (
            0 => 'DomainServiceProvider.php',
            1 => 'EventServiceProvider.php',
            2 => 'HelperServiceProvider.php',
            3 => 'PolicyServiceProvider.php',
            4 => 'RepositoryServiceProvider.php',
          ),
        ),
        'Domain' => 
        array (
        ),
        'Infrastructure' => 
        array (
          'Contracts' => 
          array (
            0 => 'BaseRepository.php',
            1 => 'Scope.php',
          ),
          'AbstractModels' => 
          array (
            0 => 'BaseModel.php',
          ),
          'AbstractRepositories' => 
          array (
            0 => 'EloquentRepository.php',
          ),
          'AbstractProviders' => 
          array (
            0 => 'ServiceProvider.php',
          ),
          'Http' => 
          array (
            'AbstractResources' => 
            array (
              0 => 'BaseResource.php',
              1 => 'BaseCollection.php',
            ),
            'AbstractRequests' => 
            array (
              0 => 'BaseRequest.php',
            ),
            'AbstractControllers' => 
            array (
              0 => 'BaseController.php',
            ),
            'AbstractFactories' => 
            array (
              0 => 'ModelFactory.php',
            ),
          ),
          'Commands' => 
          array (
            'AbstractCommand' => 
            array (
              0 => 'BaseCommand.php',
            ),
          ),
          'Scoping' => 
          array (
            0 => 'Scoper.php',
          ),
          'Traits' => 
          array (
            0 => 'BuilderParameters.php',
            1 => 'SpatieQueryBuilder.php',
            2 => 'WorkFlow.php',
            3 => 'CanBeScoped.php',
          ),
        ),
      ),
      'domain' => 
      array (
        0 => 'Traits',
        1 => 'Contracts',
        2 => 'Providers',
        'Routes' => 
        array (
          0 => 'api',
          1 => 'web',
        ),
      ),
    ),
    'stubs' => 
    array (
      'test_stub' => 'test_stub.stub',
      'config-app' => 'Config/app.stub',
      'config-fortify' => 'Config/app.stub',
      'config-auth' => 'Config/auth.stub',
      'config-cors' => 'Config/cors.stub',
      'config-lighthouse' => 'Config/lighthouse.stub',
      'event' => 'Domain/Events/event.stub',
      'job' => 'Domain/Jobs/job.stub',
      'command' => 'Domain/Commands/command.stub',
      'livewire' => 'Common/Http/Livewire/livewire.stub',
      'middleware' => 'Common/Http/Middleware/middleware.stub',
      'common_command' => 'Common/Commands/command.stub',
      'common_scope' => 'Common/Scopes/scope.stub',
      'common_event' => 'Common/Events/event.stub',
      'common_notification' => 'Common/Notifications/notification.stub',
      'common_listener' => 'Common/Listeners/listener.stub',
      'common_mail' => 'Common/Mails/mail.stub',
      'scope' => 'Domain/Entities/Scopes/scope.stub',
      'observer' => 'Domain/Observers/observer.stub',
      'policy' => 'Domain/Policies/policy.stub',
      'mail' => 'Domain/Mail/mail.stub',
      'criteria' => 'Domain/Criteria/criteria.stub',
      'listener' => 'Domain/Listeners/listener.stub',
      'notification' => 'Domain/Notifications/notification.stub',
      'rule' => 'Domain/Http/Rules/rule.stub',
      'eloquent' => 'Domain/Repositories/Eloquent/eloquent.stub',
      'contract' => 'Domain/Repositories/Contracts/contract.stub',
      'controller' => 'Domain/Http/Controllers/controller.stub',
      'controller-sac' => 'Domain/Http/Controllers/SAC/controller.stub',
      'controller-api-resource' => 'Domain/Http/Controllers/Api/V1/controller.stub',
      'controller-api-sac' => 'Domain/Http/Controllers/Api/V1/SAC/controller.stub',
      'request-store' => 'Domain/Http/Requests/Entity/store.stub',
      'request-update' => 'Domain/Http/Requests/Entity/update.stub',
      'service' => 'Domain/Services/service.stub',
      'resource' => 'Domain/Http/Resources/resource.stub',
      'resource_collection' => 'Domain/Http/Resources/collection.stub',
      'database-view' => 'Domain/Entities/Views/database_view.stub',
      'datatable' => 'Domain/Datatables/datatable.stub',
      'entity' => 'Domain/Entities/entity.stub',
      'relation' => 'Domain/Entities/Traits/Relations/relations.stub',
      'customer-attributes' => 'Domain/Entities/Traits/CustomAttributes/attributes.stub',
      'factory' => 'Domain/Database/Factories/factory.stub',
      'migration' => 'Domain/Database/Migrations/migration.stub',
      'migration_view' => 'Domain/Database/Migrations/view.stub',
      'seeder' => 'Domain/Database/Seeds/seeder.stub',
      'view-fields' => 'Domain/Resources/Views/_partials/_fields.blade.stub',
      'view-scripts' => 'Domain/Resources/Views/_partials/_scripts.blade.stub',
      'view-buttons' => 'Domain/Resources/Views/buttons/actions.blade.php',
      'view-create' => 'Domain/Resources/Views/create.blade.php',
      'view-edit' => 'Domain/Resources/Views/edit.blade.php',
      'view-index' => 'Domain/Resources/Views/index.blade.php',
      'view-show' => 'Domain/Resources/Views/show.blade.php',
      'first_domain-entity' => 'User/entity.stub',
      'first_domain-user-migration' => 'User/user-migration.stub',
      'first_domain-user-factory' => 'User/user-factory.stub',
      'first_domain-user-seeder' => 'User/user-seeder.stub',
      'first_domain-user-route-service-provider' => 'User/route-service-provider.stub',
      'component-view' => 'Common/Components/view.stub',
      'component-class' => 'Common/Components/class.stub',
      'route-web' => 'route-web.stub',
      'phpunit' => 'phpunit.stub',
      'magic-Feature' => 'Domain/Tests/magic-Feature.stub',
      'Feature' => 'Domain/Tests/Feature.stub',
      'magic-Unit' => 'Domain/Tests/magic-Unit.stub',
      'Unit' => 'Domain/Tests/Unit.stub',
      'graphql-Directives' => 'Domain/Graphql/Directives/Directives.graphql',
      'graphql-Directives-php' => 'Domain/Graphql/Directives/Directive.stub',
      'graphql-Interfaces' => 'Domain/Graphql/Interfaces/Interfaces.graphql',
      'graphql-Mutations' => 'Domain/Graphql/Mutations/Mutations.graphql',
      'graphql-Mutations-php' => 'Domain/Graphql/Mutations/Mutation.stub',
      'graphql-Queries' => 'Domain/Graphql/Queries/Queries.graphql',
      'graphql-Queries-php' => 'Domain/Graphql/Queries/Query.stub',
      'graphql-Scalars' => 'Domain/Graphql/Scalars/Scalars.graphql',
      'graphql-Scalars-php' => 'Domain/Graphql/Scalars/Scalar.stub',
      'graphql-Subscriptions' => 'Domain/Graphql/Subscriptions/Subscriptions.graphql',
      'graphql-Types' => 'Domain/Graphql/Types/Types.graphql',
      'graphql-Inputs' => 'Domain/Graphql/Inputs/Inputs.graphql',
      'graphql-Unions' => 'Domain/Graphql/Unions/Unions.graphql',
      'graphql-common' => 'directives.graphql.stub',
      'test-crud' => 'directives.graphql.stub',
      'app-js' => 'app.js.stub',
      'main-translation' => 'main.stub',
      'repository-eloquent-test' => 'Domain/Tests/Unit/Repository/Eloquent.stub',
      'resource-test' => 'Domain/Tests/Unit/Resource/Main.stub',
      'resource-normal-test' => 'Domain/Tests/Unit/Resource/Methods/NormalResource.stub',
      'resource-setup' => 'Domain/Tests/Unit/Resource/Methods/SETUP.stub',
      'entity-test' => 'Domain/Tests/Unit/Entity/Main/Main.stub',
      'entity-constants-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/Constants.stub',
      'entity-protected-constants-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/ProtectedConstants.stub',
      'entity-jwt-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/JWT.stub',
      'entity-setup-method' => 'Domain/Tests/Unit/Entity/Main/Methods/Setup.stub',
      'trait-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/Trait.stub',
      'entity-relations-test' => 'Domain/Tests/Unit/Entity/Relations/Main.stub',
      'entity-relations-anonymous-class' => 'Domain/Tests/Unit/Entity/Relations/AnonymousClass.stub',
      'entity-relations-has-methods' => 'Domain/Tests/Unit/Entity/Relations/Has.stub',
      'entity-relations-belongs-to-methods' => 'Domain/Tests/Unit/Entity/Relations/BelongsTo.stub',
      'entity-relations-belongs-to-many-methods' => 'Domain/Tests/Unit/Entity/Relations/BelongsToMany.stub',
      'request-existance-test-cases-methods' => 'Domain/Tests/Unit/Request/Methods/ExistanceRules.stub',
      'request-size-test-cases-methods' => 'Domain/Tests/Unit/Request/Methods/SizeRules.stub',
    ),
  ),
  'sms' => 
  array (
    'model' => 'App\\Domain\\User\\Entities\\User',
    'key' => 'phone',
    'default' => 'misr',
    'providers' => 
    array (
      'misr' => 
      array (
        'username' => 'misr-username',
        'password' => 'misr-password',
        'sender' => 'misr-sender',
      ),
      'victory_link' => 
      array (
        'username' => 'vl-username',
        'password' => 'vl-password',
        'sender' => 'vl-sender',
      ),
      'cequens' => 
      array (
        'username' => 'ce-username',
        'password' => 'ce-password',
        'sender' => 'ce-sender',
      ),
    ),
  ),
  'repository' => 
  array (
    'pagination' => 
    array (
      'limit' => 15,
    ),
    'fractal' => 
    array (
      'params' => 
      array (
        'include' => 'include',
      ),
      'serializer' => 'League\\Fractal\\Serializer\\DataArraySerializer',
    ),
    'cache' => 
    array (
      'enabled' => false,
      'minutes' => 30,
      'repository' => 'cache',
      'clean' => 
      array (
        'enabled' => true,
        'on' => 
        array (
          'create' => true,
          'update' => true,
          'delete' => true,
        ),
      ),
      'params' => 
      array (
        'skipCache' => 'skipCache',
      ),
      'allowed' => 
      array (
        'only' => NULL,
        'except' => NULL,
      ),
    ),
    'criteria' => 
    array (
      'acceptedConditions' => 
      array (
        0 => '=',
        1 => 'like',
        2 => 'in',
      ),
      'params' => 
      array (
        'search' => 'search',
        'searchFields' => 'searchFields',
        'filter' => 'filter',
        'orderBy' => 'orderBy',
        'sortedBy' => 'sortedBy',
        'with' => 'with',
        'searchJoin' => 'searchJoin',
        'withCount' => 'withCount',
      ),
    ),
    'generator' => 
    array (
      'basePath' => '/home/badawy/Joovlly/qalzam/app',
      'rootNamespace' => 'App\\',
      'stubsOverridePath' => '/home/badawy/Joovlly/qalzam/app',
      'paths' => 
      array (
        'models' => 'Entities',
        'repositories' => 'Repositories',
        'interfaces' => 'Repositories',
        'transformers' => 'Transformers',
        'presenters' => 'Presenters',
        'validators' => 'Validators',
        'controllers' => 'Http/Controllers',
        'provider' => 'RepositoryServiceProvider',
        'criteria' => 'Criteria',
      ),
    ),
  ),
  'query-builder' => 
  array (
    'parameters' => 
    array (
      'include' => 'include',
      'filter' => 'filter',
      'sort' => 'sort',
      'fields' => 'fields',
      'append' => 'append',
    ),
    'count_suffix' => 'Count',
    'disable_invalid_filter_query_exception' => false,
  ),
  'datatables-fractal' => 
  array (
    'includes' => 'include',
    'serializer' => 'League\\Fractal\\Serializer\\DataArraySerializer',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
