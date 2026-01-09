# TilRimal - Laravel + Next.js Integration

## System Overview

This project integrates a **Laravel backend** (with MySQL database) to fully control a **Next.js frontend**. All content, settings, and data are managed from the Laravel backend through API endpoints.

## Project Structure

```
tilrimal-backend/     → Laravel 12 API Backend
tilalr/               → Next.js Frontend
```

## Backend Setup (Laravel)

### Prerequisites
- PHP 8.2+
- MySQL Database (XAMPP)
- Composer

### Installation

1. **Navigate to backend folder:**
   ```bash
   cd C:\xampp\htdocs\tilrimal-backend
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure database in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tilalrimal
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Start Laravel server:**
   ```bash
   php artisan serve
   ```
   Backend will run on: `http://localhost:8000`

## Frontend Setup (Next.js)

### Prerequisites
- Node.js 18+
- npm or yarn

### Installation

1. **Navigate to frontend folder:**
   ```bash
   cd C:\Users\win\Documents\Github\tilalr
   ```

2. **Install dependencies:**
   ```bash
   npm install
   ```

3. **Configure API URL in `.env.local`:**
   ```env
   NEXT_PUBLIC_API_URL=http://localhost:8000/api
   ```

4. **Start Next.js development server:**
   ```bash
   npm run dev
   ```
   Frontend will run on: `http://localhost:3000`

## Database Tables

The backend manages the following content types:

| Table | Description |
|-------|-------------|
| `pages` | Website pages content |
| `services` | Services offered |
| `products` | Products/Offerings |
| `trips` | Trip packages |
| `cities` | City destinations |
| `testimonials` | Customer testimonials |
| `team_members` | Team member profiles |
| `settings` | Site-wide settings |

## API Endpoints

### Public Endpoints (GET)

```
GET /api/pages?lang=ar
GET /api/pages/{slug}
GET /api/services?lang=ar
GET /api/services/{slug}
GET /api/products?lang=ar&category=tourism
GET /api/products/{slug}
GET /api/trips?lang=ar&type=saudi
GET /api/trips/{slug}
GET /api/cities?lang=ar
GET /api/cities/{slug}
GET /api/testimonials?lang=ar
GET /api/team-members?lang=ar
GET /api/settings?group=general
```

### Admin Endpoints (POST/PUT/DELETE)

```
POST   /api/admin/pages
PUT    /api/admin/pages/{id}
DELETE /api/admin/pages/{id}

POST   /api/admin/services
PUT    /api/admin/services/{id}
DELETE /api/admin/services/{id}

POST   /api/admin/products
PUT    /api/admin/products/{id}
DELETE /api/admin/products/{id}

POST   /api/admin/trips
PUT    /api/admin/trips/{id}
DELETE /api/admin/trips/{id}

... (similar for other content types)
```

## Using the API in Next.js

### Import the API service:

```javascript
import api from '@/lib/api';
```

### Fetch data:

```javascript
// Get services
const services = await api.getServices('ar');

// Get a specific trip
const trip = await api.getTrip('riyadh-tour');

// Get settings
const settings = await api.getSettings('general');
```

### Example Component:

```javascript
'use client';
import { useEffect, useState } from 'react';
import api from '@/lib/api';

export default function Services() {
  const [services, setServices] = useState([]);

  useEffect(() => {
    const fetchServices = async () => {
      const data = await api.getServices('ar');
      setServices(data);
    };
    fetchServices();
  }, []);

  return (
    <div>
      {services.map(service => (
        <div key={service.id}>
          <h2>{service.title}</h2>
          <p>{service.description}</p>
        </div>
      ))}
    </div>
  );
}
```

## Adding Content from Backend

### Using MySQL or phpMyAdmin:

```sql
-- Add a service
INSERT INTO services (title, slug, description, icon, lang, is_active, created_at, updated_at)
VALUES ('خدمة السياحة', 'tourism-service', 'نقدم أفضل خدمات السياحة', 'icon-tourism', 'ar', 1, NOW(), NOW());

-- Add a trip
INSERT INTO trips (title, slug, description, price, duration, image, lang, is_active, created_at, updated_at)
VALUES ('رحلة الرياض', 'riyadh-trip', 'استكشف مدينة الرياض', 500.00, 3, '/trips/riyadh.jpg', 'ar', 1, NOW(), NOW());
```

### Using Laravel Tinker:

```bash
php artisan tinker
```

```php
// Create a service
App\Models\Service::create([
    'title' => 'خدمة السياحة',
    'slug' => 'tourism-service',
    'description' => 'نقدم أفضل خدمات السياحة',
    'icon' => 'icon-tourism',
    'lang' => 'ar',
    'is_active' => true
]);

// Create a city
App\Models\City::create([
    'name' => 'الرياض',
    'slug' => 'riyadh',
    'description' => 'عاصمة المملكة العربية السعودية',
    'country' => 'Saudi Arabia',
    'lang' => 'ar',
    'is_active' => true
]);
```

## Testing the API

Test endpoints using curl or Postman:

```bash
# Get all services
curl http://localhost:8000/api/services?lang=ar

# Get a specific service
curl http://localhost:8000/api/services/tourism-service

# Create a new service (POST)
curl -X POST http://localhost:8000/api/admin/services \
  -H "Content-Type: application/json" \
  -d '{
    "title": "خدمة جديدة",
    "slug": "new-service",
    "description": "وصف الخدمة",
    "lang": "ar",
    "is_active": true
  }'
```

## Features

✅ Complete CRUD API for all content types  
✅ Multi-language support (Arabic/English)  
✅ CORS enabled for Next.js frontend  
✅ RESTful API architecture  
✅ MySQL database storage  
✅ Relationship support (Trips → Cities)  
✅ JSON field support for complex data  
✅ Active/Inactive status for content  
✅ Ordering support for lists  

## Next Steps

1. **Add Authentication:** Implement Laravel Sanctum for API authentication
2. **Build Admin Panel:** Create a simple admin interface using Laravel Blade or integrate with Next.js
3. **File Uploads:** Add support for image uploads
4. **Cache Layer:** Implement Redis caching for better performance
5. **API Documentation:** Generate API docs using Laravel Scramble or similar

## Troubleshooting

### CORS Issues:
- Ensure Laravel server is running on port 8000
- Check `.env.local` in Next.js has correct API URL
- Verify CORS middleware is properly configured in `bootstrap/app.php`

### Database Connection:
- Make sure XAMPP MySQL is running
- Verify database `tilalrimal` exists
- Check credentials in Laravel `.env` file

### API Not Found:
- Ensure `routes/api.php` is registered in `bootstrap/app.php`
- Clear Laravel cache: `php artisan config:clear && php artisan route:clear`

## Support

For issues or questions, check:
- Laravel documentation: https://laravel.com/docs
- Next.js documentation: https://nextjs.org/docs
