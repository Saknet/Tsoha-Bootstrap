-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Person(
  id SERIAL PRIMARY KEY, 
  name varchar(50) NOT NULL, 
  password varchar(50) NOT NULL,
  admin boolean DEFAULT FALSE
);

CREATE TABLE Topic(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL, 
  addedBy INTEGER REFERENCES Person(id),
  description varchar(500),
  courseName varchar(50)
);

CREATE TABLE Credit(
  id SERIAL PRIMARY KEY, 
  givenBy INTEGER REFERENCES Person(id),
  topic_id INTEGER REFERENCES Topic(id),
  interrupted boolean DEFAULT FALSE,
  startDate DATE,
  endDate DATE,
  grade INTEGER
);
