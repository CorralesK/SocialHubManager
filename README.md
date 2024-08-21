# Social Hub Manager

## Description

Social Hub Manager is a web application developed for managing and scheduling social media posts. This application allows users to connect their social media accounts and post content simultaneously or on a scheduled basis. Additionally, it implements extra security with two-factor authentication (2FA).

## Features

- **User Registration and Login:** Allows users to register and access the application.
- **Social Media Integration:** Users can connect their social media accounts (supports Twitter, LinkedIn, and Mastodon) and authorize posts.
- **Post Publishing:** Users can create instant posts, schedule them, or send entries to a queue for publishing at predefined times.
- **Schedule Management:** Users can define publishing schedules to automate their posts.
- **Post Queue:** Entries can be queued and published according to the next available slot or at a scheduled date and time.
- **Two-Factor Authentication (2FA):** A two-factor authentication mechanism is implemented using Google Authenticator for enhanced security.
- **Data Privacy:** Each user has their own private workspace protected by authentication.

## Requirements

### Technologies

- **PHP:** ^7.3 | ^8.0
- **Laravel Framework:** ^8.75
- **MySQL** as the database.

### Dependencies

This project uses the following main dependencies:

- **abraham/twitteroauth:** ^7.0 - Connection with Twitter's API.
- **bacon/bacon-qr-code:** ^3.0 - QR code generation.
- **fruitcake/laravel-cors:** ^2.0 - Handling CORS in Laravel.
- **laravel/sanctum:** ^2.11 - Lightweight authentication for APIs in Laravel.
- **laravel/tinker:** ^2.5 - Command-line tool for Laravel.
- **league/oauth2-client:** ^2.7 - OAuth2 client for third-party authentications.
- **pragmarx/google2fa-laravel:** ^2.2 - Implementation of Google Authenticator for 2FA.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/CorralesK/SocialHubManager.git
   cd SocialHubManager
   ```

2. Install the dependencies:

   ```bash
   composer install
   ```

3. Set up the `.env` file:

   Copy the `.env.example` file and rename it to `.env`. Configure the environment variables, including the database credentials and API keys for the social media platforms.

4. Run the migrations to create the database tables:

   ```bash
   php artisan migrate
   ```

## Contribution

This project was developed as part of the course **ISW-811: Web Applications using Free Software** at the National Technical University.

## License

This project uses open-source software and is available under the MIT license.
