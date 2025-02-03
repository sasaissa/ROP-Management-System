<div align="center">

# ROP Management System

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![ICROP3](https://www.medscinet.com/ROP/uploads/ICROP3%20-%20Ophthalmology%202021.pdf)

A comprehensive medical platform for managing Retinopathy of Prematurity (ROP) cases following ICROP3 guidelines.

</div>

## 🌟 Overview

The ROP Management System is a state-of-the-art medical platform designed to revolutionize the care of premature infants at risk of Retinopathy of Prematurity. Built with modern web technologies and adhering to ICROP3 guidelines, this system empowers healthcare professionals with precise tools for diagnosis, treatment planning, and follow-up care.

## ✨ Key Features

### 👥 Patient Management
- Comprehensive patient profiles with medical history tracking
- Automated gestational age calculations
- Real-time status monitoring
- Chronological examination & treatment views

### 🔍 Examination Module
- ICROP3-compliant digital examination forms
- Bilateral eye examination with zone mapping
- Automated severity assessment
- Smart follow-up scheduling

### 💉 Treatment Automation
- AI-powered treatment plan generation
- 48-hour urgency assessment
- Multi-treatment support (Anti-VEGF, Laser)
- Priority-based scheduling

### 🤖 Clinical Decision Support
- Evidence-based recommendations
- Automated risk assessment
- Smart alerts system
- Treatment effectiveness tracking

### 🎨 User Interface
- Clean, intuitive interface designed for clinical settings
- Mobile-responsive design for bedside examinations
- Quick-access patient records and treatment histories
- Real-time updates and notifications

### 🔒 Security & Compliance
- Role-based access control
- Secure patient data handling
- Audit trail for all clinical decisions
- HIPAA-compliant data storage

## 🛠️ Technical Stack
- Laravel PHP Framework
- MySQL Database
- Tailwind CSS for responsive design
- Modern JavaScript for interactive features

## 🚀 Getting Started
[Installation instructions and requirements to be added]

## Contributing
We welcome contributions from the medical and development communities. Please read our contributing guidelines for more information.

## License
[License information to be added]

## Support
[Support contact information to be added]

## Acknowledgments
This system was developed in collaboration with ophthalmologists and follows the latest International Classification of Retinopathy of Prematurity (ICROP3) guidelines.

---

Built with ❤️ for improving premature infant care worldwide.


## Features

- Multi-role user management (Admin, Screening Officer Doctor, Ophthalmologist, NICU Doctor, Nurse)
- Patient management and tracking
- ROP screening and examination records
- Treatment planning and tracking
- Follows ICROP3 classification system
- Secure medical data handling

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM
- Git

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd rop-management
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rop_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Install NPM dependencies:
```bash
npm install
npm run dev
```

8. Start the server:
```bash
php artisan serve
```

## Default Users

After seeding, the following test users will be available:

- Admin: admin@rop.com / password
- Screening Officer: screening@rop.com / password
- Ophthalmologist: ophthalmologist@rop.com / password
- NICU Doctor: nicu@rop.com / password
- Nurse: nurse@rop.com / password

## License

The ROP Management System is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
