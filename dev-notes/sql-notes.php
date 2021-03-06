// GO AHEAD AND RUN THESE QUERIES IN YOUR sample_db DATABASE

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_category_id` int(11) NOT NULL,
  `notes` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `transaction_categories` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('Income','Expense') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
`user_id` int(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 user_email varchar(100) NOT NULL,
  user_passwordvarchar(100) NOT NULL,
  user_display_name varchar(100) NOT NULL,
  user_role varchar(100) NOT NULL,
  user_active varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO transaction_categories (name, type) VALUES 
('Pay Check', 'Income'),
('Rent', 'Expense'),
('Car Payment','Expense');

INSERT INTO transactions (date, amount, transaction_category_id, notes) VALUES 
('2016-2-22', 200.00, 1, 'TGIF!!!'),
('2016-2-22', 200.00, 2, 'There goes my pay check!'),
('2016-2-22', 100.00, 3, 'Maybe I should walk!');

INSERT INTO users (user_email, user_password, user_display_name, user_role, user_active)
value
('donovan@yahoo.com','123456','Donovan','admin','yes');



