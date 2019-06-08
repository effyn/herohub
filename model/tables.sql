CREATE TABLE `herohub-user` (
    id int AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(8) NOT NULL,
    email VARCHAR(254) NOT NULL,
    passhash VARCHAR(256) NOT NULL,
    tag VARCHAR(64) NOT NULL,
    region VARCHAR(16),
    micpref int NOT NULL,
    leaderpref int NOT NULL
);

CREATE TABLE `herohub-premiumuser` (
    id int PRIMARY KEY NOT NULL,
    role int NOT NULL,
    hero1 VARCHAR(32),
    hero2 VARCHAR(32),
    hero3 VARCHAR(32),
    FOREIGN KEY (id) REFERENCES `herohub-user` (id)
);