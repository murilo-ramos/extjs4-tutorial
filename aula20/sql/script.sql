CREATE TABLE Contact (
    ID    INTEGER PRIMARY KEY AUTOINCREMENT
                  NOT NULL,
    name  VARCHAR NOT NULL,
    email VARCHAR NOT NULL
);

INSERT INTO Contact (ID, name, email) VALUES ('1', 'Contact1', 'contact1@email.com');
INSERT INTO Contact (ID, name, email) VALUES ('2', 'Contact2', 'contact2@email.com');