# 🚀 Quick Start Guide - Laravel Backend Controlling Next.js Frontend

## ✅ What's Been Set Up

### Backend (Laravel) - `C:\xampp\htdocs\tilrimal-backend`
- ✅ 8 Database tables created (pages, services, products, trips, cities, testimonials, team_members, settings)
- ✅ 8 API Controllers with full CRUD operations
- ✅ 40 API endpoints (GET, POST, PUT, DELETE)
- ✅ CORS configured for Next.js
- ✅ Models with relationships and fillable fields

### Frontend (Next.js) - `C:\Users\win\Documents\Github\tilalr`
- ✅ API service created (`lib/api.js`)
- ✅ Environment configuration (`.env.local`)
- ✅ Ready to fetch data from Laravel

## 🏃 Running the Applications

### 1. Start Laravel Backend:
```powershell
cd C:\xampp\htdocs\tilrimal-backend
php artisan serve
```
**Backend URL:** http://localhost:8000

### 2. Start Next.js Frontend:
```powershell
cd C:\Users\win\Documents\Github\tilalr
npm run dev
```
**Frontend URL:** http://localhost:3000

## 📊 Adding Content (Choose One Method)

### Method 1: Using Laravel Tinker (Recommended)
```powershell
cd C:\xampp\htdocs\tilrimal-backend
php artisan tinker
```

Then in tinker:
```php
// Add a service
App\Models\Service::create([
    'title' => 'خدمات السياحة',
    'slug' => 'tourism-services',
    'description' => 'نوفر أفضل خدمات السياحة في المملكة',
    'lang' => 'ar',
    'order' => 1,
    'is_active' => true
]);

// Add a city
App\Models\City::create([
    'name' => 'الرياض',
    'slug' => 'riyadh',
    'description' => 'عاصمة المملكة العربية السعودية',
    'country' => 'Saudi Arabia',
    'lang' => 'ar',
    'order' => 1,
    'is_active' => true
]);

// Add a trip
App\Models\Trip::create([
    'title' => 'جولة الرياض التاريخية',
    'slug' => 'riyadh-historical-tour',
    'description' => 'استكشف معالم الرياض التاريخية',
    'price' => 500.00,
    'duration' => 3,
    'lang' => 'ar',
    'city_id' => 1,
    'is_active' => true
]);

// Add testimonial
App\Models\Testimonial::create([
    'name' => 'أحمد محمد',
    'content' => 'تجربة رائعة، الخدمة ممتازة',
    'rating' => 5,
    'lang' => 'ar',
    'is_active' => true
]);
```

### Method 2: Using API (POST requests)
```powershell
# Create a service
Invoke-RestMethod -Uri "http://localhost:8000/api/admin/services" `
  -Method POST `
  -Headers @{"Content-Type"="application/json"} `
  -Body '{"title":"خدمة السياحة","slug":"tourism","description":"خدمات سياحية متميزة","lang":"ar","is_active":true}'
```

### Method 3: Using MySQL/phpMyAdmin
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select database: `tilalrimal`
3. Insert data directly into tables

## 🔌 Using API in Next.js Components

### Example: Fetch Services
```javascript
// In any Next.js component
import api from '@/lib/api';
import { useEffect, useState } from 'react';

export default function Services() {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const data = await api.getServices('ar');
        setServices(data);
      } catch (error) {
        console.error('Error fetching services:', error);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  if (loading) return <div>جاري التحميل...</div>;

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

### Example: Fetch Trips with Cities
```javascript
import api from '@/lib/api';

export default async function TripsPage() {
  const trips = await api.getTrips('ar', 'saudi');
  
  return (
    <div>
      {trips.map(trip => (
        <div key={trip.id}>
          <h2>{trip.title}</h2>
          <p>{trip.description}</p>
          <p>المدينة: {trip.city?.name}</p>
          <p>السعر: {trip.price} ريال</p>
          <p>المدة: {trip.duration} أيام</p>
        </div>
      ))}
    </div>
  );
}
```

## 🧪 Testing the API

### Test with PowerShell:
```powershell
# Get all services
Invoke-RestMethod -Uri "http://localhost:8000/api/services?lang=ar"

# Get all trips
Invoke-RestMethod -Uri "http://localhost:8000/api/trips?lang=ar"

# Get all cities
Invoke-RestMethod -Uri "http://localhost:8000/api/cities?lang=ar"

# Get testimonials
Invoke-RestMethod -Uri "http://localhost:8000/api/testimonials?lang=ar"
```

### Test with Browser:
- Services: http://localhost:8000/api/services?lang=ar
- Trips: http://localhost:8000/api/trips?lang=ar
- Cities: http://localhost:8000/api/cities?lang=ar
- Settings: http://localhost:8000/api/settings

## 📁 Available API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/pages?lang=ar` | GET | Get all pages |
| `/api/services?lang=ar` | GET | Get all services |
| `/api/products?lang=ar&category=...` | GET | Get products |
| `/api/trips?lang=ar&type=...` | GET | Get trips |
| `/api/cities?lang=ar` | GET | Get cities |
| `/api/testimonials?lang=ar` | GET | Get testimonials |
| `/api/team-members?lang=ar` | GET | Get team members |
| `/api/settings?group=...` | GET | Get settings |

## 🔐 Admin Endpoints (Add Later with Authentication)

All admin endpoints are in `/api/admin/...`:
- POST `/api/admin/services` - Create service
- PUT `/api/admin/services/{id}` - Update service
- DELETE `/api/admin/services/{id}` - Delete service
(Similar for all other content types)

## 🎯 Next Steps

1. **Add Sample Data** using tinker or API
2. **Update Next.js Components** to use the API instead of hardcoded data
3. **Test the Integration** by viewing data on frontend
4. **Add Authentication** for admin endpoints (Laravel Sanctum)
5. **Build Admin Panel** for easy content management

## 💡 Pro Tips

- Use `lang` parameter for multi-language support
- Use `order` field to control display order
- Set `is_active` to false to hide content
- Use relationships (e.g., trips belong to cities)
- Store complex data in JSON fields (images, social_links)

## 📞 Need Help?

Check these files for reference:
- **API Service:** `tilalr/lib/api.js`
- **API Routes:** `tilrimal-backend/routes/api.php`
- **Controllers:** `tilrimal-backend/app/Http/Controllers/Api/`
- **Models:** `tilrimal-backend/app/Models/`

---

**Your Laravel backend is now controlling your Next.js frontend! 🎉**
