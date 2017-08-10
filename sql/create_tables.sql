-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Person(
  id SERIAL PRIMARY KEY, 
  name varchar(50) NOT NULL, 
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  admin boolean DEFAULT FALSE
);

CREATE TABLE Course(
  id SERIAL PRIMARY KEY, 
  name varchar(50) NOT NULL,
  incharge INTEGER REFERENCES Person(id)
);

CREATE TABLE Topic(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL, 
  description varchar(500),
  course INTEGER REFERENCES Course(id)
);

CREATE TABLE Credit(
  id SERIAL PRIMARY KEY, 
  givenBy INTEGER REFERENCES Person(id),
  topic INTEGER REFERENCES Topic(id),
  interrupted boolean DEFAULT FALSE,
  startDate DATE,
  endDate DATE,
  grade INTEGER
);

CREATE TABLE Person_Topic(
  person INTEGER REFERENCES Person(id),
  topic INTEGER REFERENCES Topic(id)
);
