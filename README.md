```bas
$ docker build -t php_apache:latest .
$ docker run -d --name resizing_site -p 8002:80 -v "$PWD":/var/www/html php_apache:latest
```
