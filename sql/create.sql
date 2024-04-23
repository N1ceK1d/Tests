CREATE TABLE Criterions (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE Questions (
  	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    question_text LONGTEXT NOT NULL,
    criterion_id INT NOT NULL,
    FOREIGN KEY (criterion_id) REFERENCES Criterions (id)
);

CREATE TABLE Answers (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL,
    anser_text VARCHAR(255) NOT NULL,
    points INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES Questions (id)
);

CREATE TABLE Companies (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    is_anon BOOLEAN NOT NULL,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE Users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    second_name VARCHAR(255),
    last_name VARCHAR(255),
    post_position VARCHAR(255),
    is_anon BOOLEAN NOT NULL,
    company_id INT NOT NULL,
    FOREIGN KEY (company_id) REFERENCES Companies (id)
);

CREATE TABLE UserAnswers (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    anser_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (id),
    FOREIGN KEY (anser_id) REFERENCES Answers (id)
);

CREATE TABLE Admins (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    password LONGTEXT NOT NULL
);

CREATE TABLE Supervisor (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    second_name VARCHAR(255),
    last_name VARCHAR(255),
    company_id INT NOT NULL,
    FOREIGN KEY (company_id) REFERENCES Companies (id)
);

CREATE TABLE SupervisorAnswers (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    supervisor_id INT NOT NULL,
    anser_id INT NOT NULL,
    FOREIGN KEY (supervisor_id) REFERENCES Supervisor (id),
    FOREIGN KEY (anser_id) REFERENCES Answers (id)
);