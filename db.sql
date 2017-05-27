CREATE DATABASE bookingDB;

USE bookingDB;

-- SET @@auto_increment_increment=2;
-- SET @@auto_increment_offset=2;

CREATE TABLE  `users` (
`user_id` INTEGER NOT NULL AUTO_INCREMENT,
`Fname` VARCHAR(15),
`Lname` VARCHAR(15),
`user_name` VARCHAR(15) NOT NULL,
`user_type` VARCHAR(15) NOT NULL,
`user_pass` VARCHAR(255) NOT NULL,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `users` (Fname, Lname, user_name, user_type, user_pass) VALUES   ('ali', 'joo', 'admin','administrator','1234');
INSERT INTO `users` (Fname, Lname, user_name, user_type, user_pass) VALUES   ('moe', 'soo', 'zoro','employee','1234');
INSERT INTO `users` (Fname, Lname, user_name, user_type, user_pass) VALUES   ('Abdo', 'saif', 'moe','employee','1234');
INSERT INTO `users` (Fname, Lname, user_name, user_type, user_pass) VALUES   ('saif', 'abdo', 'tough','employee','1234');


CREATE TABLE `days` (
`dayID` INTEGER NOT NULL,
`dayName` VARCHAR(20),
PRIMARY KEY (dayID)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `days` (dayID, dayName) VALUES   (1, 'Monday');
INSERT INTO `days` (dayID, dayName) VALUES   (2, 'Tuesday');
INSERT INTO `days` (dayID, dayName) VALUES   (3, 'Wednesday');
INSERT INTO `days` (dayID, dayName) VALUES   (4, 'Thursday');
INSERT INTO `days` (dayID, dayName) VALUES   (5, 'Friday');
INSERT INTO `days` (dayID, dayName) VALUES   (6, 'Saturday');
INSERT INTO `days` (dayID, dayName) VALUES   (7, 'Sunday');


CREATE TABLE `flights` (
`flightID` INTEGER NOT NULL AUTO_INCREMENT,
`airline` VARCHAR(50),
`flightNo` VARCHAR(15),
`current` VARCHAR(50),
`destination` VARCHAR(50),
`class` VARCHAR(50) ,
`price` DECIMAL(6,2),
`dayID` INTEGER  ,
`flightTime` VARCHAR(10),
PRIMARY KEY (flightID),
FOREIGN KEY (dayID) REFERENCES `days` (dayID)
)ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;


-- DATA FOR flights --
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Qatar Airlines', 'QA9555', 'kuala lumpur', 'dubai','Business', 4000.0,1, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Qatar Airlines', 'QA9565', 'kuala lumpur', 'dubai','Economic', 2500.0,2, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Qatar Airlines', 'QA9585', 'kuala lumpur', 'riyadh','Economic', 901.16,1, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Qatar Airlines', 'QA9595', 'kuala lumpur', 'new york','Business', 4000.0,2, '11:00am');

INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Fly Emirates', 'FE73456', 'kuala lumpur', 'dubai','Business', 901.16,4, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Fly Emirates', 'FE73457', 'kuala lumpur', 'new york','Economic', 6000.0,5, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Fly Emirates', 'FE73458', 'kuala lumpur', 'london','Economic', 5400.0,6, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Fly Emirates', 'FE73459', 'kuala lumpur', 'riyadh','Business', 4200.0,4, '11:00am');

INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Malaysia Airlines', 'MY42452', 'kuala lumpur', 'dubai','Business', 3800.0,3, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Malaysia Airlines', 'MY42453', 'kuala lumpur', 'london','Economic', 2400.0,2, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Malaysia Airlines', 'MY42454', 'kuala lumpur', 'new york','Economic', 6200.0,5, '11:00am');
INSERT INTO `flights` (airline, flightNo, current,destination, class, price, dayID, flightTime) VALUES   ('Malaysia Airlines', 'MY42455', 'kuala lumpur', 'riyadh','Business', 2100.0,2, '11:00am');

CREATE TABLE `booking` (
`bookingID` INTEGER NOT NULL AUTO_INCREMENT,
`price` DECIMAL(6,2),
`flightID` INTEGER ,
`cusFullName` VARCHAR(50),
`cusPassportNo` VARCHAR(10),
`cusCitizenship` VARCHAR(50),
`cusPhoneNo` VARCHAR(15),
`dateOfFlight` DATE,
`user_id` INTEGER ,
`bookingTime` timestamp DEFAULT CURRENT_TIMESTAMP,
`commission` INTEGER DEFAULT 20,
PRIMARY KEY (bookingID),
FOREIGN KEY (flightID) REFERENCES `flights` (flightID),
FOREIGN KEY (user_id) REFERENCES `users` (user_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
