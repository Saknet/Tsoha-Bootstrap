-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Person (name, password, admin) VALUES ('Ope1', 'Ope1', TRUE);
INSERT INTO Person (name, password) VALUES ('Ope2', 'Ope2');

INSERT INTO Course (name) VALUES ('Ohjelmointi');
INSERT INTO Course (name) VALUES ('Tietokantasovellus');
INSERT INTO Course (name) VALUES ('Tietorakenteet ja algoritmit');

INSERT INTO Topic (name, description) VALUES ('Shakki', 'yksinkertainen shakki');
INSERT INTO Topic (name, description) VALUES ('Laivanupotus', 'laivanupotus peli');
INSERT INTO Topic (name, description) VALUES ('Työaihekanta', 'Harjoitustöiden aiheiden tietokanta');
INSERT INTO Topic (name, description) VALUES ('Drinkkiarkisto', 'Tehtävänä on laatia www-sivulla toimiva drinkinhakulomake. Drinkkireseptit kuvaavat cocktaileja ja muita juomasekoituksia. Reseptejä voi hakea juoman nimeen liittyvällä hakusanalla tai jonkin tietyn osa-aineen mukaan. Resepteistä voi pyytää myös listan aakkosjärjestyksen, ainesosan tai juomalajin (alkudrinkki, cocktail, shotti,…) mukaan.');
INSERT INTO Topic (name, description) VALUES ('Tiedon tiivistys', 'Tiedoston pakkausta eri algoritmeilla');

INSERT INTO Credit (interrupted, startdate, grade) VALUES (TRUE, '2014-11-11', 0);
INSERT INTO Credit (interrupted, startdate, enddate, grade) VALUES (FALSE, '2015-9-9', '2015-11-9', 5);
INSERT INTO Credit (interrupted, startdate, enddate, grade) VALUES (FALSE, '2016-1-9', '2015-3-12', 3);
INSERT INTO Credit (interrupted, startdate, grade) VALUES (TRUE, '2017-11-11', 0);
INSERT INTO Credit (interrupted, startdate, enddate, grade) VALUES (FALSE, '2016-1-9', '2015-5-30', 1);

