# Mobizilla

Welcome to **Mobizilla**, your all-in-one e-commerce platform! Mobizilla empowers users to **buy**, **sell**, **exchange**, or even **place orders for repairs** with ease. Built with Laravel, this project leverages cutting-edge libraries and frameworks to deliver a modern and seamless experience.

---

## Features

### User-centric Commerce
- **Buy**: Browse a wide range of products and make purchases easily.
- **Sell**: List your items for sale with an intuitive interface.
- **Exchange**: Trade items directly with other users.
- **Repair Orders**: Place service requests for repairs and track their progress.

### Modern UI/UX Enhancements
- **Dynamic Interfaces**: Powered by Filament and Livewire for fast and interactive experiences.
- **Stunning Animations**: Enhance user engagement with WOW.js and Animate.js.

### Customizable Styling
- **SCSS Integration**: Simplified styling with reusable variables and components.

---

## Tech Stack

### Core Frameworks
- **Laravel**: Backend framework for robust and scalable development.
- **Filament**: Admin panel and form builder tailored for Laravel projects.
- **Livewire**: Full-stack framework for dynamic and reactive user interfaces.

### Frontend Libraries
- **WOW.js**: Trigger animations on scroll for interactive experiences.
- **Animate.js**: Predefined CSS animations for elements.
- **Alpine.js**: Library for inline javascript for easiness.

### Styling
- **SCSS**: Flexible and maintainable styles with nested rules, variables, and mixins.

---

## Installation

Follow these steps to set up the Mobizilla project:

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js and npm
- MySQL or compatible database

### Steps
1. **Clone the repository**:
   ```bash
   git clone https://github.com/mobizilla101/MyMobi.git
   cd mobizilla
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Compile assets**:
   ```bash
   npm run dev
   ```

5. **Set up the environment file**:
    - Duplicate `.env.example` and rename it `.env`.
    - Configure your database and other environment variables.

6. **Run migrations**:
   ```bash
   php artisan migrate
   ```

7. **Start the development server**:
   ```bash
   php artisan serve
   ```

---

## Usage

### base setup
- add localhost to the extra url in env to run and support the appropriate support.

### Animations
- Add the class `wow` to elements you want animated with WOW.js.
- Use Animate.css classes to define the animation type, e.g., `animate__fadeIn`.

### Livewire Components
- Utilize Livewire for creating dynamic, real-time UI updates without requiring page reloads.

### SCSS
- Organize styles in the `resources/scss` folder.
- Compile SCSS with Laravel Mix for efficient asset bundling.

---

## Contribution

We welcome contributions to Mobizilla! To get started:

1. Fork the repository.
2. Create a new branch for your feature or fix.
3. Submit a pull request with a detailed description of your changes.

---

## License

This project is licensed under the [MIT License](LICENSE).

---

## Acknowledgments

- [Laravel](https://laravel.com/)
- [Filament](https://filamentphp.com/)
- [Livewire](https://laravel-livewire.com/)
- [WOW.js](https://wowjs.uk/)
- [Animate.css](https://animate.style/)
- [SCSS](https://sass-lang.com/)

---

## Screenshots
*(Optional: Add screenshots of the application here)*
