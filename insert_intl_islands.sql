-- Insert international islands if not exist
INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, city_id, type, price, rating, image, features, active, created_at, updated_at)
SELECT 'Island near Jeddah', 'جزيرة بالقرب من جدة', 'A beautiful island destination near Jeddah.', 'وجهة جزيرة جميلة بالقرب من جدة.', 'island-jeddah', 1, 'island', 199.00, 4.5, 'islands/example-jeddah.jpg', JSON_ARRAY('Snorkeling','Boat','Camping'), 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM island_destinations WHERE slug = 'island-jeddah');

INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, city_id, type, price, rating, image, features, active, created_at, updated_at)
SELECT 'Island near Dammam', 'جزيرة بالقرب من الدمام', 'A beautiful island destination near Dammam.', 'وجهة جزيرة جميلة بالقرب من الدمام.', 'island-dammam', 2, 'island', 199.00, 4.5, 'islands/example-dammam.jpg', JSON_ARRAY('Snorkeling','Boat','Camping'), 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM island_destinations WHERE slug = 'island-dammam');

INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, city_id, type, price, rating, image, features, active, created_at, updated_at)
SELECT 'Island near Jazan', 'جزيرة بالقرب من جازان', 'A beautiful island destination near Jazan.', 'وجهة جزيرة جميلة بالقرب من جازان.', 'island-jazan', 3, 'island', 199.00, 4.5, 'islands/example-jazan.jpg', JSON_ARRAY('Snorkeling','Boat','Camping'), 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM island_destinations WHERE slug = 'island-jazan');

-- Check results
SELECT type, COUNT(*) as count FROM island_destinations GROUP BY type;
