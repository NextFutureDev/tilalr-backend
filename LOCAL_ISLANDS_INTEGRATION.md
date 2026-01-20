# Local Islands - Complete Setup & Integration Guide

## 🎯 Overview

This document explains the complete integration of Local Island Destinations with backend seeder data. The system is fully connected where:

- **Frontend**: Components fetch data from API
- **Backend**: API serves data from database
- **Database**: Seeder populates initial data

---

## 📊 Architecture

### Frontend Components
```
├── components/IslandDestinations/
│   ├── IslandDestinationslocal.jsx        (List view - carousel)
│   └── [international version]
│
└── app/[lang]/local-islands/[slug]/
    └── page.jsx                           (Detail view - single destination)
```

### Backend API
```
GET /api/island-destinations?type=local        (List local destinations)
GET /api/island-destinations/local/{slug}      (Get single destination)
GET /api/island-destinations                   (List by query param)
```

### Database & Seeder
```
Database Table: island_destinations
├── Records with type='local'
├── Bilingual fields (en/ar)
└── Populated by IslandDestinationsLocalSeeder
```

---

## 🗄️ Database Schema

The `island_destinations` table contains:

```
- id                  (Primary Key)
- slug                (Unique identifier for routes)
- title_en, title_ar  (Destination names)
- type                ('local' or 'international')
- description_en/ar   (Full descriptions)
- duration_en/ar      (Trip duration)
- location_en/ar      (Location names)
- groupSize_en/ar     (Group size info)
- group_size          (Stored as string)
- price_en/ar         (Pricing info)
- price               (Numeric price)
- rating              (0-5 decimal)
- reviews             (Integer count)
- image               (File path to image)
- features_en/ar      (JSON array of features)
- features            (JSON array of features)
- badge               (e.g., "Most Popular")
- discount            (e.g., "25%")
- city_id             (Foreign key to cities table)
- active              (Boolean - only active records returned)
- created_at/updated_at
```

---

## 📍 Seeded Local Destinations

### 1. Trip to AlUla (1 Day)
- **Slug**: `trip-to-alula`
- **Price**: 354 SAR/person
- **Rating**: 4.9/5
- **Group Size**: 2-15 Persons
- **Type**: Heritage Tour
- **Badge**: Most Popular
- **Discount**: 25%

**Features (EN)**:
- Hotel accommodation
- All transportation
- Professional guide
- Desert safari
- Camping experience
- All meals included

**Features (AR)**:
- سكن فندقي
- جميع المواصلات
- مرشد محترف
- سفاري صحراوي
- تجربة التخييم
- جميع الوجبات مشمولة

---

### 2. Two Days AlUla Adventure
- **Slug**: `alula-two-days`
- **Price**: 1800 SAR/person
- **Rating**: 4.7/5
- **Group Size**: 4-20 Persons
- **Duration**: 2 Days 1 Night
- **Type**: Heritage Tour
- **Badge**: Limited Spots
- **Discount**: 25%

**Features (EN)**:
- Luxury desert accommodation
- All meals included
- Professional guide
- Desert camping
- Cultural experience
- Photography service

---

### 3. Three Days AlUla Experience
- **Slug**: `alula-three-days`
- **Price**: 3200 SAR/person
- **Rating**: 4.8/5
- **Group Size**: 4-20 Persons
- **Duration**: 3 Days 2 Nights
- **Type**: Heritage Experience
- **Badge**: New Experience
- **Discount**: 20%

**Features (EN)**:
- Luxury desert lodge
- Expert archaeologist guide
- All meals included
- Desert camping
- Star gazing
- Cultural experiences

---

## 🚀 Running the Seeder

### Run All Seeders
```bash
cd c:\xampp\htdocs\tilrimal-backend
php artisan db:seed
```

### Run Only Local Islands Seeder
```bash
php artisan db:seed --class=IslandDestinationsLocalSeeder
```

### Fresh Seed (Warning: Wipes database)
```bash
php artisan migrate:fresh --seed
```

### Verify Data
```bash
php artisan tinker
>>> IslandDestination::where('type', 'local')->get();
```

---

## 🔗 API Endpoints

### List All Local Destinations
```
GET /api/island-destinations?type=local
```

**Response**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "slug": "trip-to-alula",
      "title_en": "Trip to AlUla",
      "title_ar": "رحلة العلا يوم واحد",
      "price": 354.00,
      "rating": 4.9,
      "image": "http://localhost/storage/islands/354.jpeg",
      "type": "local",
      "active": true,
      ...
    }
  ],
  "message": "Island destinations retrieved successfully"
}
```

### Get Single Destination
```
GET /api/island-destinations/trip-to-alula
```

**Response**:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "slug": "trip-to-alula",
    "title_en": "Trip to AlUla",
    ...
    "features_en": ["Hotel accommodation", "All transportation", ...],
    "features_ar": ["سكن فندقي", "جميع المواصلات", ...]
  },
  "message": "Island destination retrieved successfully"
}
```

---

## 🎨 Frontend Data Flow

### List Component (IslandDestinationslocal.jsx)

1. **Fetch Data**:
```javascript
useEffect(() => {
  const fetchUrl = `${API_URL}/island-destinations?type=local`;
  const res = await fetch(fetchUrl);
  const data = await res.json();
  if (data.success) setDestinations(data.data);
}, []);
```

2. **Display Data**:
```javascript
{destinations.map((destination) => (
  <Card key={destination.id}>
    <Image src={getImageUrl(destination.image)} />
    <Title>{getText(destination, 'title')}</Title>
    <Price>{getText(destination, 'price')}</Price>
    <Rating>{destination.rating}/5</Rating>
    <Features>
      {parseList(getText(destination, 'features')).map(f => ...)}
    </Features>
  </Card>
))}
```

3. **Navigation**:
```javascript
const handleViewDetails = (destination) => {
  router.push(`/${lang}/local-islands/${destination.slug}`);
};
```

---

### Detail Component (page.jsx)

1. **Fetch Single Destination**:
```javascript
useEffect(() => {
  const fetchUrl = `${API_URL}/island-destinations/local/${slug}`;
  const res = await fetch(fetchUrl);
  const data = await res.json();
  if (data.success) setDestination(data.data);
}, [slug]);
```

2. **Display All Details**:
```javascript
<Title>{getText(destination, 'title')}</Title>
<Price>{getText(destination, 'price')}</Price>
<Duration>{getText(destination, 'duration')}</Duration>
<GroupSize>{getText(destination, 'group_size')}</GroupSize>
<Location>{getText(destination, 'location')}</Location>
<Description>{getText(destination, 'description')}</Description>
<Features>
  {parseList(getText(destination, 'features')).map(f => ...)}
</Features>
```

3. **Booking**:
```javascript
const handleBookNow = () => {
  openBookingOrAuth({
    slug: destination.slug,
    title: getText(destination, 'title'),
    amount: destination.price
  });
};
```

---

## 🔄 Data Synchronization

### Bilingual Field Access
Helper function in components:
```javascript
const getText = (obj, field) => {
  const fieldKey = lang === "ar" ? `${field}_ar` : `${field}_en`;
  return obj[fieldKey] || "";
};

// Usage:
getText(destination, 'title')   // Returns title_en or title_ar
getText(destination, 'price')   // Returns price_en or price_ar
```

### Safe Array Parsing
```javascript
const parseList = (value) => {
  if (!value) return [];
  if (Array.isArray(value)) return value;
  if (typeof value === 'string') {
    try {
      const parsed = JSON.parse(value);
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) {
      return value.split(",").map(s => s.trim()).filter(Boolean);
    }
  }
  return [];
};

// Usage:
parseList(destination.features_en)  // Returns array of features
```

---

## ✅ Verification Checklist

- [x] Database seeder created with complete local destination data
- [x] IslandDestinationsLocalSeeder.php registered in DatabaseSeeder
- [x] API endpoint `/api/island-destinations?type=local` returns data
- [x] IslandDestinationslocal.jsx fetches from API (no static data)
- [x] Local island detail page fetches from `/api/island-destinations/local/{slug}`
- [x] Bilingual support for all fields (en/ar)
- [x] Features as JSON arrays
- [x] Image paths properly handled
- [x] Rating and pricing included
- [x] All required fields populated

---

## 🧪 Testing Commands

### Test API Response
```bash
# PowerShell
$response = Invoke-RestMethod -Uri "http://localhost/tilrimal-backend/public/api/island-destinations?type=local"
$response.data | ConvertTo-Json

# OR via curl
curl "http://localhost/tilrimal-backend/public/api/island-destinations?type=local" | jq
```

### Test Single Destination
```bash
curl "http://localhost/tilrimal-backend/public/api/island-destinations/trip-to-alula" | jq '.data | {title_en, price, rating}'
```

### Check Database
```bash
php artisan tinker
>>> IslandDestination::where('type', 'local')->count();
=> 3

>>> IslandDestination::where('slug', 'trip-to-alula')->first();
```

---

## 📝 Frontend URLs

### List Pages
- **English**: `http://localhost:3000/en/islands` (International)
- **Arabic**: `http://localhost:3000/ar/islands` (International)
- **English Local**: `http://localhost:3000/en/local-islands` (List)
- **Arabic Local**: `http://localhost:3000/ar/local-islands` (List)

### Detail Pages
- **English**: `http://localhost:3000/en/local-islands/trip-to-alula`
- **Arabic**: `http://localhost:3000/ar/local-islands/trip-to-alula`
- **English**: `http://localhost:3000/en/local-islands/alula-two-days`
- **English**: `http://localhost:3000/en/local-islands/alula-three-days`

---

## 🛠️ Troubleshooting

### No Data Showing in Component
1. Check browser console for fetch errors
2. Verify API endpoint: `curl http://localhost/tilrimal-backend/public/api/island-destinations?type=local`
3. Run seeder: `php artisan db:seed --class=IslandDestinationsLocalSeeder`
4. Check database: `php artisan tinker` → `IslandDestination::where('type', 'local')->count()`

### Images Not Loading
1. Verify file path in database: `php artisan tinker` → `IslandDestination::first()->image`
2. Check storage folder: `c:\xampp\htdocs\tilrimal-backend\storage\app\public\islands\`
3. Run: `php artisan storage:link` (if not already done)

### Bilingual Content Not Showing
1. Check lang parameter in URL: `/en/local-islands/...` or `/ar/local-islands/...`
2. Verify database has both `*_en` and `*_ar` fields
3. Test getText helper in browser console

### Detail Page Shows "Not Found"
1. Check slug matches database: `php artisan tinker` → `IslandDestination::pluck('slug')`
2. Verify route exists: `php artisan route:list | grep island`
3. Test API directly: `curl http://localhost/tilrimal-backend/public/api/island-destinations/trip-to-alula`

---

## 📚 File Locations

```
Backend:
├── app/Http/Controllers/Api/IslandDestinationController.php
├── app/Models/IslandDestination.php
├── database/seeders/IslandDestinationsLocalSeeder.php
├── database/migrations/2025_12_30_000000_create_island_destinations_table.php
└── routes/api.php

Frontend:
├── components/IslandDestinations/IslandDestinationslocal.jsx
├── app/[lang]/local-islands/
│   ├── page.jsx (list)
│   └── [slug]/page.jsx (detail)
└── lib/api.js (API_URL configuration)
```

---

## 🔐 Important Notes

1. **Data is stored in the database seeder** - Changes made in Filament admin panel will persist in the database
2. **All components use API** - No hardcoded data in frontend components
3. **Bilingual support** - All text fields have both English and Arabic versions
4. **Active flag** - Only records with `active=true` are returned by API
5. **Image management** - Images stored in `storage/app/public/islands/` and served via API

---

## 🎯 Next Steps

1. Run seeder: `php artisan db:seed --class=IslandDestinationsLocalSeeder`
2. Test API: `curl http://localhost/tilrimal-backend/public/api/island-destinations?type=local`
3. Visit frontend: `http://localhost:3000/en/local-islands`
4. Check detail page: `http://localhost:3000/en/local-islands/trip-to-alula`

---

**Last Updated**: January 7, 2026  
**Status**: ✅ Fully Configured and Ready to Use
