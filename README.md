<div align="center">

# ROP Management System

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![ICROP3](https://img.shields.io/badge/Standard-ICROP3-green.svg)](https://www.medscinet.com/ROP/uploads/ICROP3%20-%20Ophthalmology%202021.pdf)

A comprehensive medical platform for managing Retinopathy of Prematurity (ROP) cases following ICROP3 guidelines.

</div>

## 🌟 Overview

The ROP Management System is a state-of-the-art medical platform designed to revolutionize the care of premature infants at risk of Retinopathy of Prematurity. Built with modern web technologies and adhering to ICROP3 guidelines, this system empowers healthcare professionals with precise tools for diagnosis, treatment planning, and follow-up care.

## ✨ Key Features

### 👥 Patient Management
- Detailed patient profiles with comprehensive medical history
- Automated gestational age calculations and risk factor tracking
- Real-time patient status monitoring
- Chronological view of examinations and treatments

### 🔍 Examination Module
- Structured digital examination forms following ICROP3 standards
- Bilateral eye examination support with detailed zone mapping
- Automated severity assessment based on international guidelines
- Dynamic follow-up scheduling based on examination findings

### 💉 Treatment Automation
- Intelligent treatment plan generation based on examination results
- Automated urgency assessment with 48-hour treatment flagging
- Support for multiple treatment types (Anti-VEGF, Laser)
- Treatment scheduling with priority-based timing

### 🤖 Clinical Decision Support
- Evidence-based treatment recommendations
- Automated risk assessment and progression tracking
- Smart alerts for urgent cases and follow-up requirements
- Treatment effectiveness monitoring

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

## 🛠️ Technology Stack
- **Backend:** Laravel 10.x
- **Database:** MySQL 8.0
- **Frontend:** Tailwind CSS
- **Modern JavaScript for interactive features

## 📋 Requirements

### System Requirements
- PHP 8.1 or higher
- MySQL 8.0+
- Node.js & NPM
- Composer

### Browser Support
- Chrome (recommended)
- Firefox
- Safari
- Edge

## 🚀 Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/rop-management.git
cd rop-management
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM dependencies
```bash
npm install
npm run dev
```

4. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rop_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

## 👥 Default Users

The system comes with pre-configured users for testing:

| Role | Email | Password |
|------|--------|----------|
| Admin | admin@rop.com | password |
| Screening Officer | screening@rop.com | password |
| Ophthalmologist | ophtha@rop.com | password |
| NICU Doctor | nicu@rop.com | password |
| Nurse | nurse@rop.com | password |

## 🤝 Contributing

We welcome contributions from the medical and development communities. Please read our contributing guidelines for more information.

## 📜 License

The ROP Management System is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 💬 Support

For support inquiries, please contact:
- Technical Support: [Coming Soon]
- Medical Guidance: [Coming Soon]

## 🙏 Acknowledgments

This system was developed in collaboration with ophthalmologists and follows the latest International Classification of Retinopathy of Prematurity (ICROP3) guidelines.

---

<div align="center">
Built with ❤️ for improving premature infant care worldwide
</div>
