CREATE DATABASE IF NOT EXISTS biblioteca
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca;

CREATE TABLE autori (
  id_autor   INT AUTO_INCREMENT PRIMARY KEY,
  nume       VARCHAR(100) NOT NULL,
  tara       VARCHAR(60),
  an_nastere SMALLINT,
  an_deces   SMALLINT NULL,
  biografie  TEXT
) ENGINE=InnoDB;

CREATE TABLE genuri (
  id_gen    INT AUTO_INCREMENT PRIMARY KEY,
  nume      VARCHAR(60) NOT NULL UNIQUE,
  descriere TEXT
) ENGINE=InnoDB;

CREATE TABLE carti (
  id_carte        INT AUTO_INCREMENT PRIMARY KEY,
  id_autor        INT NOT NULL,
  titlu           VARCHAR(150) NOT NULL,
  an_aparitie     SMALLINT,
  nr_pagini       SMALLINT,
  descriere       TEXT,
  imagine_coperta VARCHAR(255),
  FOREIGN KEY (id_autor) REFERENCES autori(id_autor)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE carti_genuri (
  id_carte INT NOT NULL,
  id_gen   INT NOT NULL,
  PRIMARY KEY (id_carte, id_gen),
  FOREIGN KEY (id_carte) REFERENCES carti(id_carte) ON DELETE CASCADE,
  FOREIGN KEY (id_gen)   REFERENCES genuri(id_gen)
) ENGINE=InnoDB;

CREATE TABLE contact_mesaje (
  id_mesaj        INT AUTO_INCREMENT PRIMARY KEY,
  nume            VARCHAR(100) NOT NULL,
  email           VARCHAR(150) NOT NULL,
  mesaj           TEXT NOT NULL,
  data_trimiterii DATETIME NOT NULL
) ENGINE=InnoDB;

INSERT INTO autori (id_autor, nume, tara, an_nastere, an_deces) VALUES
(1,  'Feodor Dostoievski', 'Rusia',          1821, 1881),
(2,  'Arthur Conan Doyle', 'Marea Britanie', 1859, 1930),
(3,  'Agatha Christie',    'Marea Britanie', 1890, 1976),
(4,  'Daphne du Maurier',  'Marea Britanie', 1907, 1989),
(5,  'Umberto Eco',        'Italia',         1932, 2016),
(6,  'Thomas Harris',      'SUA',            1940, NULL),
(7,  'Dan Brown',          'SUA',            1964, NULL),
(8,  'Stieg Larsson',      'Suedia',         1954, 2004),
(9,  'Gillian Flynn',      'SUA',            1971, NULL),
(10, 'Paula Hawkins',      'Marea Britanie', 1972, NULL),
(11, 'Colleen Hoover',     'SUA',            1979, NULL),
(12, 'Alex Michaelides',   'Cipru',          1977, NULL);

INSERT INTO genuri (id_gen, nume) VALUES
(1, 'Roman psihologic'),
(2, 'Mister polițist clasic'),
(3, 'Thriller gotic'),
(4, 'Mister istoric'),
(5, 'Thriller psihologic'),
(6, 'Thriller de conspirație'),
(7, 'Thriller nordic');

INSERT INTO carti (id_carte, id_autor, titlu, an_aparitie) VALUES
(1,  1,  'Crimă și pedeapsă',        1866),
(2,  2,  'Câinele din Baskerville',  1902),
(3,  3,  'Crima din Orient Express', 1934),
(4,  4,  'Rebecca',                  1938),
(5,  5,  'Numele trandafirului',     1980),
(6,  6,  'Tăcerea mieilor',          1988),
(7,  7,  'Codul lui Da Vinci',       2003),
(8,  8,  'Fata cu un dragon tatuat', 2005),
(9,  9,  'Fata dispărută',           2012),
(10, 10, 'Fata din tren',            2015),
(11, 11, 'Verity',                   2018),
(12, 12, 'Pacienta tăcută',          2019);

INSERT INTO carti_genuri (id_carte, id_gen) VALUES
(1,1),(2,2),(3,2),(4,3),(5,4),(6,5),(7,6),(8,7),(9,5),(10,5),(11,5),(12,5);