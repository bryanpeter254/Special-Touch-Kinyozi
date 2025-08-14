# Special-Touch-Kinyozi
A Barbershop system showing details for day to day activities 


CREATE TABLE barbershop.revenue (
    id INT(11) NOT NULL AUTO_INCREMENT,
    date DATE NOT NULL,
    client_name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    service_id INT(11) DEFAULT NULL,
    service VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    offered_by_id INT(11) DEFAULT NULL,
    offered_by VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE barbershop.advances (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE barbershop.barbers (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    commission_rate FLOAT DEFAULT NULL,
    phone VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
CREATE TABLE barbershop.client_checkins (
    id INT(11) NOT NULL AUTO_INCREMENT,
    client_name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    service VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    amount_paid DECIMAL(10,2) NOT NULL,
    date_of_visit DATE NOT NULL,
    barber VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE barbershop.debts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    client_name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    amount_paid DECIMAL(10,2) DEFAULT 0.00,
    date DATE NOT NULL,
    status ENUM('Paid', 'Not Paid', 'Partially Paid') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Not Paid',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE barbershop.expenses (
    id INT(11) NOT NULL AUTO_INCREMENT,
    expense_date DATE NOT NULL,
    item VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    paid_by VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    notes TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    PRIMARY KEY (id)
);




CREATE TABLE barbershop.users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    password VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    PRIMARY KEY (id),
    INDEX (username)
);

CREATE TABLE barbershop.services (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE barbershop.monthly_record (
    id INT(11) NOT NULL AUTO_INCREMENT,
    date DATE NOT NULL,
    client VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    service VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    cash DECIMAL(10,2) NOT NULL,
    notes TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
    PRIMARY KEY (id)
);

