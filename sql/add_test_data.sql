INSERT INTO Person (name, username, password, admin) VALUES ('Ope1', 'ano', 'nyymi', TRUE);
INSERT INTO Person (name, username, password) VALUES ('Ope2', 'nyymi', 'ano');

INSERT INTO Course (name, incharge) VALUES ('Ohjelmointi', 1);
INSERT INTO Course (name, incharge) VALUES ('Tietokantasovellus', 1);
INSERT INTO Course (name, incharge) VALUES ('Tietorakenteet ja algoritmit', 2);

INSERT INTO Topic (name, addedby, description, course) VALUES ('Shakki', 1, 'yksinkertainen shakki', 1);
INSERT INTO Topic (name, addedby, description, course) VALUES ('Laivanupotus', 2, 'laivanupotus peli', 1);
INSERT INTO Topic (name, addedby, description, course) VALUES ('Työaihekanta', 1, 'Harjoitustöiden aiheiden tietokanta', 2);
INSERT INTO Topic (name, addedby, description, course) VALUES ('Drinkkiarkisto', 1, 'Tehtävänä on laatia www-sivulla toimiva drinkinhakulomake. Drinkkireseptit kuvaavat cocktaileja ja muita juomasekoituksia. Reseptejä voi hakea juoman nimeen liittyvällä hakusanalla tai jonkin tietyn osa-aineen mukaan. Resepteistä voi pyytää myös listan aakkosjärjestyksen, ainesosan tai juomalajin (alkudrinkki, cocktail, shotti,…) mukaan.', 2);
INSERT INTO Topic (name, addedby, description, course) VALUES ('Tiedon tiivistys', 2, 'Tiedoston pakkausta eri algoritmeilla', 3);

INSERT INTO Credit (givenby, topic, interrupted, startdate, grade) VALUES (1, 2, TRUE, '2014-11-11', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (1, 1, FALSE, '2015-9-9', '2015-11-9', 5);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (2, 5, FALSE, '2016-1-9', '2015-3-12', 3);
INSERT INTO Credit (givenby, topic, interrupted, startdate, grade) VALUES (1, 4, TRUE, '2017-11-11', 0);
INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (1, 3, FALSE, '2016-1-9', '2015-5-30', 1);

