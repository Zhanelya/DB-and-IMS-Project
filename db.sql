SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `comp3013` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `comp3013`;

CREATE TABLE IF NOT EXISTS users (acc_id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), 
                                  name VARCHAR(30), pswd VARCHAR(30), email VARCHAR(30), date DATE);

CREATE TABLE IF NOT EXISTS adm (acc_id INT NOT NULL, PRIMARY KEY(id), is_admin INT);

CREATE TABLE IF NOT EXISTS profile (acc_id INT NOT NULL, PRIMARY KEY(acc_id), fname VARCHAR(30), 
                                    lname VARCHAR(30), dob DATE, gender CHAR(1) NOT NULL, country VARCHAR(30), 
                                    city VARCHAR(30), status INT, prof_img INT, privacy_id INT);

CREATE TABLE IF NOT EXISTS privacy (id INT NOT NULL, PRIMARY KEY (id), type VARCHAR(30));
INSERT INTO privacy VALUES (1, "Public");
INSERT INTO privacy VALUES (2, "Friends");
INSERT INTO privacy VALUES (3, "Only me");

CREATE TABLE IF NOT EXISTS status (id INT NOT NULL, PRIMARY KEY (id), status_val VARCHAR(30)); 
INSERT INTO status VALUES (1, "Single");
INSERT INTO status VALUES (2, "In a relationship");
INSERT INTO status VALUES (3, "Married");
INSERT INTO status VALUES (4, "It's complicated");

CREATE TABLE IF NOT EXISTS friendship (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),  
                                       user1_id INT NOT NULL, user2_id INT NOT NULL, status_approved INT);

CREATE TABLE IF NOT EXISTS circle (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), acc_id INT, type_id INT, friendship_id INT);  

CREATE TABLE IF NOT EXISTS circle_type (type_id INT NOT NULL, PRIMARY KEY(id), c_type VARCHAR(30));
INSERT INTO circle_type VALUES (1, "Colleague");
INSERT INTO circle_type VALUES (2, "Family");
INSERT INTO circle_type VALUES (3, "Classmate");

CREATE TABLE IF NOT EXISTS activity (acc_id INT NOT NULL, PRIMARY KEY(acc_id), timestmp DATETIME, category_id INT, a_id INT);
CREATE TABLE IF NOT EXISTS activity_category (id INT NOT NULL, PRIMARY KEY(id), category VARCHAR(30)); 
INSERT INTO activity_category VALUES (1, "Friend");
INSERT INTO activity_category VALUES (2, "Circle");
INSERT INTO activity_category VALUES (3, "Profile");
INSERT INTO activity_category VALUES (4, "Post");
INSERT INTO activity_category VALUES (5, "Photo");

CREATE TABLE IF NOT EXISTS message(sender_id INT NOT NULL, PRIMARY KEY(sender_id, recipient_id, timestmp), 
                                   recipient_id INT NOT NULL, timestmp DATETIME, conversation_id INT, msg VARCHAR(1000));

CREATE TABLE IF NOT EXISTS blog (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), acc_id INT);
CREATE TABLE IF NOT EXISTS post (blog_id INT NOT NULL , PRIMARY KEY(blog_id, timestmp), timestmp DATETIME, post VARCHAR(2000));

CREATE TABLE IF NOT EXISTS album(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), acc_id INT, name VARCHAR(30), privacy_id INT);

CREATE TABLE IF NOT EXISTS photo(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), acc_id INT, album_id INT, img BLOB, description VARCHAR(50));

CREATE TABLE IF NOT EXISTS photo_comment(sender_id INT NOT NULL, PRIMARY KEY(sender_id, timestmp), 
                                         timestmp DATETIME, photo_id INT, comment VARCHAR(500));
