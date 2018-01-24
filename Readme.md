# Documentation for my MVC and Restfull Api
* Autor: VitaliI Minenko
* vers: 1.0.0
* Stworzony: 2018-01-24
## Config in .htaccess.
```apacheconfig
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```
##### Base work with API.

* All requests do with GET request.
* Response from api in JSON format with status OK.

##Exemple request

```exemplerequest
http://shop.info/api/products?name=products&offset=0&page=1
```

##Exemple answear

```exempleanswear
{
status: "ok",
body: {
data: [
{
0: "5",
1: "Bloodborne",
2: "599",
3: "USD",
id: "5",
title: "Bloodborne",
price: "599",
currency: "USD"
},
{
0: "4",
1: "Icewind Dale",
2: "495",
3: "USD",
id: "4",
title: "Icewind Dale",
price: "495",
currency: "USD"
},
{
0: "3",
1: "Baldur’s Gate",
2: "399",
3: "USD",
id: "3",
title: "Baldur’s Gate",
price: "399",
currency: "USD"
}
],
limit: 3,
offset: 0,
total: 5
},
paginator: {
count_pages: 2,
current_page: "1"
}
}
```