## PROJECT TO PAY AN INVOICE

Development in php with laravel, which involves making an invoice payment through the redirection with PlacetoPay [webcheckout](https://placetopay.github.io/web-checkout-api-docs/#webcheckout) , controlling the invoice payment statuses and allowing to view the history of payment attempts.

## Installation

You must keep in mind that since this program is built with php, you must have a **WEB SERVER**

## Installing dependencies with Composer 
The first thing you should do after downloading the project on you machine and configuring the web server, is to install the dependencies with composer. Therefore, you must have [Composer](https://getcomposer.org/) installed on your machine.

<p> The composer dependences download can be done using this command in the console, inside the root folder of your project:</p>

```bash
$ composer install
```

<p>This will install all the necessary dependencies for the project defined in the <b>composer.json</b> file during development.</p>

## Laravel configuration file

"Every new project with Laravel, by default has an **.env** file with the necessary configuration data for it, when we use a version control system like git, this file is excluded from the repository for security measures."

<p>In this project there is a <b> .env.example </b> file with is an example of how to create a configuration file, we can copy this file from the console with:</p>

```bash
$ cp .env.example .env
```
In this way we already have the configuration file for our project. In this file you can fill the data for the redirection with [PlacetoPay](https://placetopay.github.io/web-checkout-api-docs/#que-datos-debo-tener-antes-de-iniciar-la-instalacion) and the information of the database that you are going to use.

After that, you run the migrations and seeders:

```bash
$ php artisan migrate --seed
```

you should also install **node.js** and run this command:

```bash
$ npm install
$ npm run dev
```

## THANK YOU

I hope this information helps you.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
