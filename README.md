# laravel-vue-subdomain-SPA-eshop
Single page application (SPA) with subdomain,  vue CLI, laravel php framework and Bootstrap css. CRUD with admin area. Eshop with Paypal payment. Secured with larval sanctum
Require: 
Nodejs (>= 12.0),
Composer, laravel,
apache2, mysql,
PHP >= 7.2.5 see extensions requirements https://laravel.com/docs/7.x/installation
( WAMP or LAMP or MAMP confiqured installation),
Vue CLI4,
Bootstrap4,
Paypal sandbox account.

------------------------

HOW TO:
Create  database 'sundance' in your mysql
From sundance-berlin folder:
open .env file in a IDE (Editor)
set DB_USERNAME and DB_PASSWORD with username und password from your mysql installation.
...
DB_DATABASE=sundance
DB_USERNAME=yourUsername
DB_PASSWORD=yourPassword
...
save the file

in console type:
php artisan key:generate
php artisan migrate
Create a initial user (test@test.com, test) with seeding:
php artisan db:seed
php artisan serve
copy URL (http://127.0.0.1:8000) and paste in browser. Browser window must remain open, do nothing there.

From admin-sundance-berlin folder
in console type:
npm install
npm run serve

copy local URL (http://localhost:8080/) and paste in another browser window. This is the main application.

Admin area type in Browser http://localhost:8080/login
email: test@test.com
password: test

--------------------

** for paypal functionality you must set your paypal client-id.
Open file admin-sundance-berlin/src/pages/Checkout.vue and replace xxxxxxxxxxxxxxxxxx with your client-id

.......
mounted: function() {
    const script = document.createElement("script");
    script.src =
      "https://www.paypal.com/sdk/js?client-id=xxxxxxxxxxxxxxxxxx&disable-funding=credit,card";
    script.addEventListener("load", this.setLoaded);
    document.body.appendChild(script);
  },
  ......
