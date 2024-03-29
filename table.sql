-- Create the subscribers table
CREATE TABLE subscribers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

-- Create the zones table
CREATE TABLE zones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

-- Create the boxes table
CREATE TABLE boxes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    zone_id INT,
    has_voice_over BOOLEAN,
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);

-- Create the subscriber_boxes (pivot) table
CREATE TABLE subscriber_boxes (
    subscriber_id INT,
    box_id INT,
    PRIMARY KEY (subscriber_id, box_id),
    FOREIGN KEY (subscriber_id) REFERENCES subscribers(id),
    FOREIGN KEY (box_id) REFERENCES boxes(id)
);

-- Create the praying_name table
CREATE TABLE praying_name (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    json_key VARCHAR(15) NOT NULL,
    praying_seq INT
);

-- Create the songs table
CREATE TABLE songs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    praying_id INT,
    box_id INT,
    praying_time DATETIME,
    FOREIGN KEY (praying_id) REFERENCES praying_name(id),
    FOREIGN KEY (box_id) REFERENCES boxes(id)
);

-- Create View For Subscriber With Boxes
CREATE VIEW `subscriber_with_boxes` AS SELECT
   `subscriber_boxes`.`subscriber_id` AS `subscriber_id`,
   `subscriber_boxes`.`box_id` AS `box_id`,
   `zones`.`name` AS `zone`,
   `subscribers`.`name` AS `subscriber`,
   `boxes`.`name` AS `boxes`,
   `boxes`.`has_voice_over` AS `has_voice_over`,
   `boxes`.`zone_id` AS `zone_id`
FROM
   (((
       `subscriber_boxes`
           JOIN `subscribers` ON ((
           `subscriber_boxes`.`subscriber_id` = `subscribers`.`id`
           )))
       JOIN `boxes` ON ((
       `subscriber_boxes`.`box_id` = `boxes`.`id`
       )))
       JOIN `zones` ON ((
       `boxes`.`zone_id` = `zones`.`id`
       )));

-- Create view for praying_time_data
CREATE VIEW `praying_time_data` AS SELECT
   date_format( `songs`.`praying_time`, '%Y-%m-%d' ) AS `praying_date`,
   date_format( `songs`.`praying_time`, '%h:%i %p' ) AS `praying_time`,
   concat( `praying_name`.`name`, ' (', date_format( `songs`.`praying_time`, '%m-%d' ), ')' ) AS `praying_name_with_date`,
   `praying_name`.`name` AS `praying_name`,
   `praying_name`.`praying_seq` AS `praying_seq`,
   `boxes`.`name` AS `box`,
   `zones`.`name` AS `zone`,
   `subscribers`.`name` AS `subscriber`,
   `subscriber_boxes`.`subscriber_id` AS `subscriber_id`,
   `songs`.`box_id` AS `box_id`
FROM
   (((((
       `songs`
           JOIN `praying_name` ON ((
           `songs`.`praying_id` = `praying_name`.`id`
           )))
       JOIN `boxes` ON ((
       `songs`.`box_id` = `boxes`.`id`
       )))
       JOIN `zones` ON ((
       `boxes`.`zone_id` = `zones`.`id`
       )))
       JOIN `subscriber_boxes` ON ((
       `boxes`.`id` = `subscriber_boxes`.`box_id`
       )))
       JOIN `subscribers` ON ((
       `subscriber_boxes`.`subscriber_id` = `subscribers`.`id`
       )))
ORDER BY
   `praying_name`.`praying_seq`
