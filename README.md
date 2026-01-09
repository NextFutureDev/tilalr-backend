# 🌍 Sensing Nature - Geological & Geophysical Solutions

A modern, bilingual (English/Arabic) web application built with Laravel and Filament, providing innovative geological and geophysical solutions.

## 🚀 Features

- **🌐 Bilingual Support**: Full English and Arabic localization
- **📱 Responsive Design**: Mobile-first approach with modern UI/UX
- **🔧 Admin Panel**: Powerful Filament-based administration interface
- **📁 File Management**: Organized file uploads with proper directory structure
- **💬 WhatsApp Integration**: Direct contact through WhatsApp
- **📊 Portfolio Management**: Showcase geological projects and services
- **👥 Team Management**: Team member profiles and information
- **📧 Contact System**: Integrated contact forms and messaging

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x
- **Admin Panel**: Filament 3.x
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (development) / MySQL (production)
- **Localization**: Laravel Localization + Spatie Translatable
- **Build Tool**: Vite with Tailwind CSS

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite/MySQL

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Diab999/Sensing-Nature.git
   cd Sensing-Nature
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Start development server**
   ```bash
   php artisan serve
   npm run dev
   ```

## 🔧 Configuration

### Environment Variables
```env
APP_NAME="Sensing Nature"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

WHATSAPP_PHONE=+1234567890
```

### Admin Access
- **URL**: `/admin`
- **Default Email**: `admin@example.com`
- **Default Password**: `admin123`

## 📁 Project Structure

```
├── app/
│   ├── Filament/Resources/     # Admin panel resources
│   ├── Http/Controllers/       # Web controllers
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
├── resources/
│   ├── views/                  # Blade templates
│   ├── lang/                   # Language files
│   └── css/                    # Tailwind CSS
├── storage/
│   └── app/public/             # File uploads
│       ├── portfolio/          # Portfolio images
│       ├── projects/images/    # Project images
│       ├── team-members/images/ # Team member images
│       └── services/icons/     # Service icons
└── routes/
    └── web.php                 # Web routes
```

## 🌍 Localization

The application supports both English and Arabic:

- **English Routes**: `/en/*`
- **Arabic Routes**: `/ar/*`
- **Language Switching**: Available on all pages
- **RTL Support**: Full Arabic RTL layout support

## 📱 WhatsApp Integration

- **Floating Button**: Always visible WhatsApp contact button
- **Direct Messaging**: One-click access to WhatsApp chat
- **Phone Configuration**: Configurable via environment variables

## 🔒 Security Features

- **Admin Access Control**: Middleware-based admin protection
- **File Upload Security**: Secure file handling and validation
- **CSRF Protection**: Built-in Laravel security features
- **Input Validation**: Comprehensive form validation

## 🚀 Deployment

### Production Checklist
- [x] Code debugged and optimized
- [x] File uploads properly organized
- [x] Unused code removed
- [x] Performance optimizations applied
- [x] Security configurations set

### Deployment Commands
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
php artisan migrate --force
```

## 📊 Admin Panel Features

- **Portfolio Management**: Add/edit portfolio items
- **Project Management**: Manage geological projects
- **Service Management**: Configure services and icons
- **Team Management**: Team member profiles
- **Contact Management**: Handle contact messages
- **Settings Management**: Application configuration

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📞 Support

- **Email**: ma4482604@gmail.com
- **GitHub**: [@Diab999](https://github.com/Diab999)
- **WhatsApp**: Available through the website

## 🎯 Roadmap

- [ ] API endpoints for mobile apps
- [ ] Advanced analytics dashboard
- [ ] Multi-language content management
- [ ] Advanced file management system
- [ ] Performance monitoring integration

---

**Built with ❤️ using Laravel & Filament**
