# 🐳 Tilalr Docker Deployment Guide

## دليل نشر Tilalr باستخدام Docker

---

## 📁 هيكل الملفات

### Backend (Laravel)
```
tilalr-backend/
├── Dockerfile                    # ملف بناء Docker
├── .dockerignore                 # ملفات مستثناة من Docker
├── docker-compose.yml            # للتطوير المحلي
├── docker-compose.prod.yml       # للإنتاج
├── docker-compose.full-stack.yml # لتشغيل كل الخدمات معاً
├── .env.docker.example           # نموذج متغيرات البيئة
└── docker/
    ├── nginx/
    │   ├── nginx.conf
    │   └── default.conf
    ├── php/
    │   └── php.ini
    ├── supervisor/
    │   └── supervisord.conf
    └── entrypoint.sh
```

### Frontend (Next.js)
```
tilalr-frontend/
├── Dockerfile
├── .dockerignore
├── docker-compose.yml
├── docker-compose.prod.yml
└── .env.docker.example
```

---

## 🚀 البدء السريع

### 1. التطوير المحلي (Development)

#### تشغيل Backend فقط:
```bash
cd tilalr-backend

# نسخ ملف البيئة
cp .env.docker.example .env

# تعديل المتغيرات حسب الحاجة
nano .env

# تشغيل الخدمات
docker-compose up -d

# مع phpMyAdmin
docker-compose --profile dev up -d
```

#### تشغيل Frontend فقط:
```bash
cd tilalr-frontend

# نسخ ملف البيئة
cp .env.docker.example .env

# تشغيل
docker-compose up -d
```

#### تشغيل كل الخدمات معاً:
```bash
cd tilalr-backend

# تشغيل Full Stack
docker-compose -f docker-compose.full-stack.yml up -d
```

---

## 🌐 النشر على الإنتاج (Production)

### الخطوة 1: إعداد الخادم

```bash
# تثبيت Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# تثبيت Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### الخطوة 2: رفع الملفات

```bash
# على الخادم
git clone https://github.com/NextFuturesa/tilalr-backend.git
git clone https://github.com/NextFuturesa/tilalr-frontend.git
```

### الخطوة 3: إعداد متغيرات البيئة

```bash
cd tilalr-backend
cp .env.docker.example .env

# تعديل المتغيرات
nano .env
```

#### متغيرات مهمة للإنتاج:
```env
# App
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key

# Database (استخدم كلمات مرور قوية)
DB_ROOT_PASSWORD=super_secure_root_password_123
DB_PASSWORD=super_secure_password_456

# Stripe (مفاتيح الإنتاج)
STRIPE_KEY=pk_live_xxx
STRIPE_SECRET=sk_live_xxx

# Frontend URL
NEXT_PUBLIC_API_URL=https://api.tilalr.com
```

### الخطوة 4: توليد مفتاح التطبيق

```bash
# على جهازك المحلي
php artisan key:generate --show
# انسخ المفتاح إلى ملف .env
```

### الخطوة 5: بناء وتشغيل الحاويات

```bash
# بناء الصور
docker-compose -f docker-compose.prod.yml build

# تشغيل الخدمات
docker-compose -f docker-compose.prod.yml up -d
```

---

## 🔧 أوامر مفيدة

### عرض الحاويات النشطة
```bash
docker-compose ps
```

### عرض السجلات
```bash
# كل الخدمات
docker-compose logs -f

# خدمة محددة
docker-compose logs -f app
docker-compose logs -f mysql
```

### الدخول إلى الحاوية
```bash
# Backend
docker exec -it tilalr-backend sh

# تشغيل أوامر Laravel
docker exec -it tilalr-backend php artisan migrate
docker exec -it tilalr-backend php artisan cache:clear
```

### إعادة بناء الصور
```bash
docker-compose build --no-cache
docker-compose up -d
```

### إيقاف الخدمات
```bash
docker-compose down

# مع حذف البيانات
docker-compose down -v
```

---

## 🔐 إعداد SSL/HTTPS

### باستخدام Certbot (Let's Encrypt)

```bash
# تثبيت Certbot
sudo apt install certbot

# الحصول على شهادة
sudo certbot certonly --standalone -d api.tilalr.com -d tilalr.com

# الشهادات ستكون في:
# /etc/letsencrypt/live/tilalr.com/fullchain.pem
# /etc/letsencrypt/live/tilalr.com/privkey.pem
```

### إعداد Nginx للـ SSL:
```nginx
server {
    listen 443 ssl http2;
    server_name api.tilalr.com;
    
    ssl_certificate /etc/letsencrypt/live/tilalr.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/tilalr.com/privkey.pem;
    
    location / {
        proxy_pass http://backend:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}

server {
    listen 443 ssl http2;
    server_name tilalr.com www.tilalr.com;
    
    ssl_certificate /etc/letsencrypt/live/tilalr.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/tilalr.com/privkey.pem;
    
    location / {
        proxy_pass http://frontend:3000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

---

## ☁️ النشر على منصات سحابية

### AWS (ECS/ECR)

```bash
# تسجيل الدخول إلى ECR
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com

# بناء ورفع الصور
docker build -t tilalr-backend ./tilalr-backend
docker tag tilalr-backend:latest YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com/tilalr-backend:latest
docker push YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com/tilalr-backend:latest
```

### Google Cloud (Cloud Run)

```bash
# تسجيل الدخول
gcloud auth configure-docker

# بناء ورفع
docker build -t gcr.io/YOUR_PROJECT/tilalr-backend ./tilalr-backend
docker push gcr.io/YOUR_PROJECT/tilalr-backend

# نشر على Cloud Run
gcloud run deploy tilalr-backend \
    --image gcr.io/YOUR_PROJECT/tilalr-backend \
    --platform managed \
    --region us-central1 \
    --allow-unauthenticated
```

### DigitalOcean (App Platform)

```yaml
# .do/app.yaml
name: tilalr
services:
  - name: backend
    dockerfile_path: tilalr-backend/Dockerfile
    source_dir: tilalr-backend
    http_port: 80
    instance_size_slug: basic-xxs
    
  - name: frontend
    dockerfile_path: tilalr-frontend/Dockerfile
    source_dir: tilalr-frontend
    http_port: 3000
    instance_size_slug: basic-xxs

databases:
  - name: db
    engine: MYSQL
    version: "8"
```

---

## 📊 المراقبة والصيانة

### Health Checks

```bash
# Backend
curl http://localhost:8000/api/health

# Frontend
curl http://localhost:3000/api/health
```

### النسخ الاحتياطي للقاعدة

```bash
# نسخ احتياطي
docker exec tilalr-mysql mysqldump -u root -p tilalr > backup.sql

# استعادة
docker exec -i tilalr-mysql mysql -u root -p tilalr < backup.sql
```

### تحديث الحاويات

```bash
# سحب آخر التغييرات
git pull origin main

# إعادة البناء والتشغيل
docker-compose build
docker-compose up -d
```

---

## 🐛 حل المشاكل

### مشكلة: الحاوية لا تعمل
```bash
# عرض السجلات
docker-compose logs app

# فحص حالة الحاوية
docker inspect tilalr-backend
```

### مشكلة: خطأ في قاعدة البيانات
```bash
# انتظار تشغيل MySQL
docker-compose up -d mysql
sleep 30
docker-compose up -d app
```

### مشكلة: ذاكرة غير كافية
```bash
# زيادة الذاكرة في docker-compose.yml
deploy:
  resources:
    limits:
      memory: 1G
```

---

## ✅ قائمة التحقق للنشر

- [ ] نسخ ملفات .env وتعديلها
- [ ] توليد APP_KEY جديد
- [ ] إعداد قاعدة البيانات
- [ ] إعداد مفاتيح Stripe
- [ ] إعداد Firebase (للـ Frontend)
- [ ] إعداد SSL/HTTPS
- [ ] اختبار Health Checks
- [ ] إعداد النسخ الاحتياطي التلقائي
- [ ] إعداد المراقبة

---

## 📞 الدعم

للمساعدة أو الاستفسارات:
- GitHub Issues: https://github.com/NextFuturesa/tilalr-backend/issues
