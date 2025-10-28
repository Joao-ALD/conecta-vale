# Conecta Vale

## Description
Conecta Vale is a Laravel-based e-commerce platform that connects sellers and customers. It allows sellers to create their own profiles, manage products, and categorize them, while customers can browse and purchase products. The platform includes an administration panel for managing the entire system.

## Features
- User authentication for administrators, sellers, and customers.
- Seller profiles with store name, document type, document number and phone.
- Product management, including creation, editing, and deletion.
- Category management to organize products.
- A database seeder to populate the application with test data, including an administrator, sellers, customers, products, and categories.

## Technologies Used
- **Backend:** Laravel, PHP
- **Frontend:** Blade, Alpine.js, Tailwind CSS, Vite
- **Database:** MySQL (based on typical Laravel setup)
- **Development Environment:** Laravel Sail (optional, based on `composer.json`)

## Installation
1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/conecta-vale.git
   cd conecta-vale
   ```
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Install frontend dependencies:**
   ```bash
   npm install
   ```
4. **Create a copy of the `.env.example` file and name it `.env`:**
   ```bash
   cp .env.example .env
   ```
5. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```
6. **Configure your database in the `.env` file.**
7. **Run the database migrations and seed the database:**
   ```bash
   php artisan migrate --seed
   ```
8. **Start the Vite development server:**
   ```bash
   npm run dev
   ```
9. **Start the Laravel development server:**
   ```bash
   php artisan serve
   ```
## Usage
The database seeder creates the following test users:

- **Administrator:**
  - **Email:** `admin@conectavale.com`
  - **Password:** `admin123`

- **Seller:**
  - **Email:** `vendedor@teste.com`
  - **Password:** `password`

You can use these credentials to log in and test the application.

## Contributing
Contributions are welcome! Please feel free to submit a pull request.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
