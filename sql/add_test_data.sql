-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Person (name, password, admin) VALUES ('Ope1', 'Ope1', TRUE);
INSERT INTO Person (name, password) VALUES ('Ope2', 'Ope2');

INSERT INTO Topic (name, description, courseName) VALUES ('Shakki', 'yksinkertainen shakki', 'Ohjelmointi');
INSERT INTO Topic (name, description, courseName) VALUES ('Työaihekanta', 'Harjoitustöiden aiheiden tietokanta', 'Tietokantasovellus');
INSERT INTO Topic (name, description, courseName) VALUES ('Tiedon tiivistys', 'Tiedoston pakkausta eri algoritmeilla', 'Tietorakenteet ja algoritmit');

INSERT INTO Credit (interupted, startdate, grade) VALUES (TRUE, '2014-11-11', 0);

