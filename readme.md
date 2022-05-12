#安装
````
composer create-project dsxwk/fastapp
````

#Nginx rewrite 配置
````
location / {
    if (!-e $request_filename) {
    rewrite ^/(.*)$ /index.php/$1  last;
    break;
    }
}
````

#访问
````
127.0.0.1/应用名称/控制器/方法 默认: 127.0.0.1/index/index/index
````