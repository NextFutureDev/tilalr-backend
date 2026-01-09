-- First, ensure cities exist
INSERT INTO cities (name, slug, lang, is_active, created_at, updated_at)
VALUES 
('Jeddah', 'jeddah', 'en', 1, NOW(), NOW()),
('Dammam', 'dammam', 'en', 1, NOW(), NOW()),
('Jazan', 'jazan', 'en', 1, NOW(), NOW()),
('Farasan', 'farasan', 'en', 1, NOW(), NOW()),
('Umluj', 'umluj', 'en', 1, NOW(), NOW()),
('Al Lith', 'al-lith', 'en', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE is_active=1;

-- Now insert international islands (these reference cities by slug pattern)
DELETE FROM island_destinations WHERE type='island';

INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, type, price, rating, image, features, active, created_at, updated_at)
VALUES 
('Island near Jeddah', 'جزيرة بالقرب من جدة', 'A beautiful island destination near Jeddah.', 'وجهة جزيرة جميلة بالقرب من جدة.', 'island-jeddah', 'island', 199.00, 4.5, 'islands/example-jeddah.jpg', '["Snorkeling","Boat","Camping"]', 1, NOW(), NOW()),
('Island near Dammam', 'جزيرة بالقرب من الدمام', 'A beautiful island destination near Dammam.', 'وجهة جزيرة جميلة بالقرب من الدمام.', 'island-dammam', 'island', 199.00, 4.5, 'islands/example-dammam.jpg', '["Snorkeling","Boat","Camping"]', 1, NOW(), NOW()),
('Island near Jazan', 'جزيرة بالقرب من جازان', 'A beautiful island destination near Jazan.', 'وجهة جزيرة جميلة بالقرب من جازان.', 'island-jazan', 'island', 199.00, 4.5, 'islands/example-jazan.jpg', '["Snorkeling","Boat","Camping"]', 1, NOW(), NOW());

-- Show what we have
SELECT 'International Islands:' as type_check;
SELECT id, title_en, type, active FROM island_destinations WHERE type='island';

SELECT 'Local Islands:' as type_check;
SELECT id, title_en, type, active FROM island_destinations WHERE type='local';
