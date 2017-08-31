INSERT INTO Person (name, username, password, admin) VALUES ('Heimo Vesa', 'ano', 'nyymi', TRUE);
INSERT INTO Person (name, username, password, admin) VALUES ('Allan Kurma', 'nyymi', 'ano', TRUE);
INSERT INTO Person (name, username, password) VALUES ('Irma Kääriäinen', 'Ope3', 'Ope3');
INSERT INTO Person (name, username, password) VALUES ('Asko Vilenius', 'Ope4', 'Ope4');
INSERT INTO Person (name, username, password, admin) VALUES ('Rivo-Riitta', 'Ohja', 'aja', TRUE);
INSERT INTO Person (name, username, password, admin) VALUES ('Aulis Homelius', 'test', 'test', TRUE);
INSERT INTO Person (name, username, password) VALUES ('Inkeri Kääriäinen', 'Ope5', 'Ope5');
INSERT INTO Person (name, username, password, admin) VALUES ('Hessu Muhevainen', 'Ope6', 'Ope6', TRUE);
INSERT INTO Person (name, username, password) VALUES ('Sam Makkonen', 'Ope7', 'Ope7');
INSERT INTO Person (name, username, password, admin) VALUES ('Urho Puuma', 'Ope8', 'Ope8', TRUE);
INSERT INTO Person (name, username, password) VALUES ('Päivi Kankkonen', 'Ope9', 'Ope9');
INSERT INTO Person (name, username, password, admin) VALUES ('Gootti-Kustaa', 'Test', 'Test', TRUE);

INSERT INTO Course (name, incharge) VALUES ('Ohjelmointi', 1);
INSERT INTO Course (name, incharge) VALUES ('Tietokantasovellus', 1);
INSERT INTO Course (name, incharge) VALUES ('Tietorakenteet ja algoritmit', 2);
INSERT INTO Course (name, incharge) VALUES ('Tietoliikenne', 3);
INSERT INTO Course (name, incharge) VALUES ('Ruby on Rails', 4);
INSERT INTO Course (name, incharge) VALUES ('Ohjelmistotuotantoprojekti', 6);
INSERT INTO Course (name, incharge) VALUES ('Web-Palvelinohjelmointi (Java)', 9);
INSERT INTO Course (name, incharge) VALUES ('Ohjelmistoarkkitehtuurien harjoitustyö', 10);
INSERT INTO Course (name, incharge) VALUES ('Distributed Systems Project', 7);
INSERT INTO Course (name, incharge) VALUES ('Data Mining Project', 11);

INSERT INTO Topic (name, description, course) VALUES ('Shakki', 'yksinkertainen shakki', 1);
INSERT INTO Topic (name, description, course) VALUES ('Laivanupotus', 'laivanupotus peli', 1);
INSERT INTO Topic (name, description, course) VALUES ('Työaihekanta', 'Harjoitustöiden aiheiden tietokanta', 2);
INSERT INTO Topic (name, description, course) VALUES ('Drinkkiarkisto', 'Tehtävänä on laatia www-sivulla toimiva drinkinhakulomake. Drinkkireseptit kuvaavat cocktaileja ja muita juomasekoituksia. Reseptejä voi hakea juoman nimeen liittyvällä hakusanalla tai jonkin tietyn osa-aineen mukaan. Resepteistä voi pyytää myös listan aakkosjärjestyksen, ainesosan tai juomalajin (alkudrinkki, cocktail, shotti,…) mukaan.', 2);
INSERT INTO Topic (name, description, course) VALUES ('Tiedon tiivistys', 'Tiedoston pakkausta eri algoritmeilla', 3);
INSERT INTO Topic (name, description, course) VALUES ('Ratebeer', 'Kaljanrateus sivusto', 5);
INSERT INTO Topic (name, description, course) VALUES ('Verkkokauppa', 'tosi hieno aihe', 6);
INSERT INTO Topic (name, description, course) VALUES ('Web sovelluskehys', 'TODO', 8);
INSERT INTO Topic (name, description, course) VALUES ('Ohjelmistokehys grafiikkaeditoreille', 'TODO', 8);
INSERT INTO Topic (name, description, course) VALUES ('Twitter', 'tai ainakin melkein', 7);
INSERT INTO Topic (name, description, course) VALUES ('PewPew', 'TODO', 10);
INSERT INTO Topic (name, description, course) VALUES ('ManyFunnyThings', 'tldr', 9);

INSERT INTO PERSON_TOPIC (person, topic) VALUES (1, 1);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (2, 1);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (3, 1);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (4, 1);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (1, 2);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (2, 3);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (3, 4);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (4, 5);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (2, 4);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (5, 6);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (5, 4);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (2, 6);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (6, 7);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (5, 5);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (5, 7);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (7, 8);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (12, 9);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (9, 9);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (9, 10);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (8, 11);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (8, 12);
INSERT INTO PERSON_TOPIC (person, topic) VALUES (10, 12);

INSERT INTO Credit (givenby, topic, interrupted, startdate, grade) VALUES (1, 2, TRUE, '2014-11-11', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (1, 1, FALSE, '2015-9-9', '2015-11-9', 5);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (2, 5, FALSE, '2015-1-9', '2015-3-12', 3);
INSERT INTO Credit (givenby, topic, interrupted, startdate, grade) VALUES (1, 4, TRUE, '2017-11-11', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (1, 3, FALSE, '2015-1-9', '2015-5-30', 1);
INSERT INTO Credit (givenby, topic, interrupted, startdate, grade) VALUES (5, 6, TRUE, '2017-11-11', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (6, 7, FALSE, '2015-11-11', '2016-3-25', 3);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (5, 6, FALSE, '2016-2-9', '2016-5-30', 4);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (2, 3, TRUE, '2017-2-9', '2017-5-30', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (1, 5, FALSE, '2016-3-4', '2015-5-11', 2);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (6, 7, FALSE, '2015-11-11', '2016-3-25', 3);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (5, 6, FALSE, '2016-4-9', '2016-5-30', 4);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (2, 3, TRUE, '2017-2-11', '2017-5-30', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (11, 5, FALSE, '2016-4-5', '2015-5-11', 1);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (6, 12, FALSE, '2015-11-11', '2016-3-25', 3);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (5, 11, FALSE, '2016-2-9', '2016-5-30', 5);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (12, 10, TRUE, '2017-2-9', '2017-5-30', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (4, 8, FALSE, '2016-3-4', '2015-5-11', 2);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (6, 9, FALSE, '2015-11-11', '2016-3-25', 2);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (8, 10, FALSE, '2016-2-9', '2016-5-30', 4);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (9, 11, TRUE, '2017-3-9', '2017-5-20', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (10, 12, FALSE, '2016-3-4', '2015-5-11', 2);
