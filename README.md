# simpleshop-laravel-vuejs

> A simple e-commerce app based on Laravel (API) and VueJS (Front-end) using Bootstrap and Material Design pattern.

## Installation

Step by step, how to get an app running.
* Required: PHP 7.1, Node 9, NPM 5.6, Composer

1. Clone project to your path
	```
	git clone https://github.com/boski-src/simpleshop-laravel-vuejs.git <ProjectName>
	```
2. Go to project dir	
	```
	cd <ProjectName>
	```
3. Install packages
	```
	composer install
	```
	```
	npm install
	```
4. Update app key
	```
	php artisan key:generate
	```
5. Copy *.env.example* and configure to *.env* file
6. Run *php artisan migrate*
7. Start app on *http://localhost:8000/*
	```
	php artisan serve
	```
8. Set user privilage
	```
	php artisan user:privilage
	```
#### Build JavaScript
```
npm run prod
```
#### Build with
* [Laravel 5.6](https://laravel.com/) PHP framework
* [VueJS 2](https://vuejs.org/) Front-end framework
	* [epic-spinners](https://github.com/epicmaxco/epic-spinners), 
	[vee-validate](https://github.com/baianat/vee-validate), 
	[izitoast](https://github.com/arthurvasconcelos/vue-izitoast), 
	[mugen-scroll](https://github.com/egoist/vue-mugen-scroll)
* [Bootstrap 4](http://getbootstrap.com) for CSS and jQuery plugins
* [MDBootstrap 4.5](https://mdbootstrap.com/) for Material Design pattern
* [Font Awesome](https://fortawesome.com/) for the icons
