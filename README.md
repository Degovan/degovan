<p align="center">
    <img src="https://avatars.githubusercontent.com/u/74700238?s=200&v=4" alt="Logo"><br>
    <img alt="GitHub repo size" src="https://img.shields.io/github/repo-size/Degovan/degovan">
    <img alt="GitHub" src="https://img.shields.io/github/license/Degovan/degovan">
</p>


## About
Repository containing the source code of the main [Degovan](https://degovan.com) website.


## Requirements
- PHP >= 8


## Getting Started
- Clone or download this repository
    ```bash
    git clone https://github.com/Degovan/degovan
    cd degovan
    ```
    
- Install all dependencies
    ```bash
    composer install
    ```
    
- Copy environment file
    ```bash
    cp .env.example .env
    ```
    
- Setup [Laravel](https://laravel.com) app
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
    
    
## Contributing
- Create a new branch, then do a pull request so we can review the code and what features you added
- Run ``php artisan test`` to ensure your passed all testing
- Run ``./vendor/bin/pint`` to ensure your code is in accordance with the laravel coding standard
- The changes you make must pass all the tests
 
