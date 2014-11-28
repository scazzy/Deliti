DROP DATABASE IF EXISTS db_vroom
CREATE DATABASE db_vroom


CREATE TABLE settings(
	set_id INT NOT NULL AUTO_INCREMENT,
	set_name VARCHAR (50) NOT NULL,
	set_value INT (50)
}

CREATE TABLE countries (
	country_id INT PRIMARY KEY AUTO_INCREMENT,
	country_name  VARCHAR (20)
)

CREATE TABLE security_questions (
	secQ_id INT PRIMARY KEY AUTO_INCREMENT,
	sec_question VARCHAR (50)
)

CREATE TABLE user_details (
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	usr_fname VARCHAR (30),
	usr_lname VARCHAR (30),
	usr_email VARCHAR (50),
	usr_pwd VARCHAR (80),
	usr_phone INTEGER,
	usr_gender CHAR (1),
	usr_country INT,
	usr_city VARCHAR (25),
	usr_job VARCHAR (30),
	usr_org VARCHAR (30),
	usr_secQuestion INT,
	usr_secQ_Answer VARCHAR (30),
	FOREIGN KEY (usr_country) REFERENCES countries(country_id),
	FOREIGN KEY (usr_secQuestion) REFERENCES securityQuestions(secQ_id)

)

CREATE TABLE room_details (
	room_key VARCHAR (15) PRIMARY KEY,
	user_id INT,
	title VARCHAR (78),
	agenda VARCHAR (255),
	start_dt DATETIME,
	end_dt DATETIME,
	chat_script_url TEXT,
	drawpad_url TEXT,
	video_recorded_url TEXT,
	FOREIGN KEY (user_id) REFERENCES user_details(user_id)
)

CREATE TABLE participant_details (
	participant_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	prt_name VARCHAR (50),
	prt_email VARCHAR (50),
	room_key VARCHAR (15),
	user_id INT,
	prt_gender CHAR (1),
	prt_job VARCHAR (30),
	prt_org VARCHAR (30),
	prt_enter_dt DATETIME,
	prt_leave_dt DATETIME,
	prt_noteText LONGTEXT,
	prt_feedback TEXT,
	prt_geo_location VARCHAR (25),
	prt_IP VARCHAR (19),
	prt_browser VARCHAR (100),
	prt_OS VARCHAR (20),
	FOREIGN KEY (room_key) REFERENCES room_details(room_key),
	FOREIGN KEY (user_id) REFERENCES user_details(user_id)	
)
CREATE TABLE live_attendees(
	participant_id INT,
	room_key VARCHAR (15),	
	user_id INT,
	FOREIGN KEY (room_key) REFERENCES room_detail(room_key),
	FOREIGN KEY (participant_id) REFERENCES participant_details(participant_id),
	FOREIGN KEY (user_id) REFERENCES user_details(user_id)
)

CREATE TABLE chat_message (
	msg_id INTEGER PRIMARY KEY,
	participant_id INT,
	room_key VARCHAR (15),
	message VARCHAR (225),
	timeStamp DATETIME,
	FOREIGN KEY (participant_id) REFERENCES participant_details(participant_id),
	FOREIGN KEY (room_key) REFERENCES room_detail(room_key)
)

CREATE TABLE invitees (
	invitee_id INT PRIMARY KEY AUTO_INCREMENT,
	inv_email VARCHAR (50),
	room_key VARCHAR (15),
	FOREIGN KEY (room_key) REFERENCES room_details(room_key)
)

CREATE TABLE user_log (
	log_id INT PRIMARY KEY AUTO_INCREMENT,
	user_id INT,
	log_detail VARCHAR (100),
	location VARCHAR (50),
	browser VARCHAR (50),
	IPaddr VARCHAR (20),
	FOREIGN KEY (user_id) REFERENCES user_details(user_id)
)


//optional///////////////////////////////////////////////
CREATE TABLE waiting_room (
	wr_id INT PRIMARY KEY AUTO_INCREMENT,
	participant_id INT,
	room_key VARCHAR (15),
	FOREIGN KEY (participant_id) REFERENCES participant_details(participant_id),
	FOREIGN KEY (room_key) REFERENCES room_detail(room_key)
	

)

//optional///////////////////////////////////////////////
CREATE TABLE user_settings (
	setting_id INT PRIMARY KEY AUTO_INCREMENT,
	set_name VARCHAR (20),
	set_value VARCHAR (20)
)