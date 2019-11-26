CREATE TABLE user(
	id int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name varchar(20) NOT NULL,
	num varchar(30) NOT NULL UNIQUE,
	uname varchar(20) NOT NULL UNIQUE,
	pwd varchar(20) NOT NULL,
	single varchar(256) NOT NULL DEFAULT '0,0,0',
	multi varchar(256) NOT NULL DEFAULT '0,0,0',
	node varchar(10) NOT NULL,
	active BIT DEFAULT 0
);

CREATE TABLE room(
	id int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pwd varchar(20) NOT NULL,
	p1 varchar(20),
	p2 varchar(20),
	move varchar(256) NOT NULL DEFAULT '',
	turn int(1) NOT NULL DEFAULT 0,
	start int(1) DEFAULT 0
);