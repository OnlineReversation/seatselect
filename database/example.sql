USE db_seat_select;

INSERT INTO db_users (user_login, user_password, user_email, is_admin)
VALUES 
    ('Ganna', 'qwerty', 'ganna@example.com', true),
    ('Timi', 'qwerty', 'timi@example.com', true),
    ('Ameer', 'qwerty', 'ameer@example.com', true),
    ('Sai', 'qwerty', 'sai@example.com', true),
    ('Ekene', 'qwerty', 'ekene@example.com', true),
    ('Lucy', 'qwerty', 'lucy@example.com', true);

	
INSERT INTO restaurant_tables (capacity) 
VALUES 
    (2), (2), (2), (2), (2), 
    (4), (4), (4), (4), (4), 
    (6), (6), (6), (6), (6), 
    (12), (12), (12), (12), (12);
	 	
INSERT INTO reservations (table_id, user_id, reservation_date, reservation_time)
VALUES
    (1, 1, '2025-03-01', '12:00:00'),
    (2, 2, '2025-03-01', '13:00:00'),
    (3, 3, '2025-03-01', '14:00:00'),
    (4, 4, '2025-03-01', '15:00:00'),
    (5, 5, '2025-03-01', '16:00:00');	 	
    
INSERT INTO reviews (user_id, table_id, rating, review_text, review_date)
VALUES
    (1, 1, 5, 'Perfect table', '2025-02-25'),
    (2, 2, 4, 'Good table', '2025-02-26'),
    (3, 3, 3, 'Too noisy', '2025-02-27'),
    (4, 4, 5, 'Great for groups', '2025-02-28'),
    (5, 5, 4, 'Good but cramped', '2025-02-25');    
