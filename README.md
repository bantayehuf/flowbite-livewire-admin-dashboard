# laravel-livewire-admin-dahboard
Reusable Laravel Livewire admin dashboard layout built with TailwindCSS and Flowbite. It is fully customizable and easy to use and with ready-to-use components.


## Features
- Responsive layout
- Component-based and easily customizable
- Authentication (Registration, Login, Reset password, and Profile Management) built with Jetstream
- Side Navbar
- Top Navbar
- Toast notification handler from Livewire component (To show success, error, or information messages after database update or for any event).
- User management
- User department management
- User role management
- Password configuration
- Action Confirmation
- Modals
- Data table
  

## Requirements:
- Requirements of Laravel 10.* and Livewire 3.*
- PHP composer
- NodeJs


## Steps to configure:
### Clone repository
```sh
git clone https://github.com/bantayehuf/media.git


```
### Install dependencies
```sh
composer install


```
```sh
npm install
```


### Create configuration
- Create a .env file in the app root by copying the contents of the .env.example file and configure the application enviroment.


### Migrate the database
```sh
php artisan migrate
```


## Now is the time to serve the system
### Start Laravel Dev server and asset bundler
```sh
php artisan serve
```


```sh
npm run dev
```
