# orgdon-v2
Organ Donation Website

ErrorDocument 404 '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>404 - Not Found</title></head><body></body></html>'

RewriteEngine On
RewriteBase /orgdon-v2/

# Allow access to index.html (public entry point)
RewriteRule ^index\.html$ - [L]

RewriteRule ^(config|controllers|core|models|views)/ - [R=404,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
