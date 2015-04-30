pptube
================================

Find popular videos from the world.


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.

SERVER CONFIGURATION
-------------

### Nginx
```bash
server {
  listen *:80;
  #listen [::]:80 ipv6only=on;

  root /var/www/html/pptube/web;
  index index.php;

  # Make site accessible from http://localhost/
  server_name pp.zhexiao.space;

  access_log /var/log/nginx/pp.access.log;
  error_log /var/log/nginx/pp.error.log;

  location / {
    # First attempt to serve request as file, then
    # as directory, then fall back to displaying a 404.
    # try_files $uri $uri/ =404;
    try_files $uri $uri/ /index.php?$args;
    # Uncomment to enable naxsi on this location
    # include /etc/nginx/naxsi.rules
  } 

  error_page 404 /404.html;
  error_page 500 502 503 504 /50x.html;
  location = /50x.html {
    root /var/www/html;
  }

  location ~ \.php$ {
    try_files $uri =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
  }

  location ~ /\.(ht|svn|git){
    deny all;
  }

}
```

### Apache
```bash
<VirtualHost *:80>
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/pptube/web"

    <Directory "/Applications/XAMPP/xamppfiles/htdocs/pptube/web">
        # use mod_rewrite for pretty URL support
        RewriteEngine on
        # If a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # Otherwise forward the request to index.php
        RewriteRule . index.php
    </Directory>

    ServerName pp.zhexiao.space
    ErrorLog "logs/pptube.example.com-error_log"
    CustomLog "logs/pptube.example.com-access_log" common
</VirtualHost>
```

Technical
---------

- [Yii](http://www.yiiframework.com/) The Fast, Secure and Professional PHP Framework.

- [Python](https://www.python.org/) Python is a programming language that lets you work quickly and integrate systems more effectively.

- [Angularjs](https://angularjs.org/) HTML enhanced for web apps.

- [Mongodb](http://www.mongodb.org/) MongoDB is an open-source, document database designed for ease of development and scaling.

- [Bootstrap](http://getbootstrap.com/) Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile first projects on the web.

