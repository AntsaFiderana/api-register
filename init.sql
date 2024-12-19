DO
$$
BEGIN
   IF NOT EXISTS (SELECT 1 FROM pg_database WHERE datname = 'apiuser') THEN
      CREATE DATABASE apiuser;
   END IF;
END
$$;
\c apiuser;


CREATE TABLE role(
   id SERIAL,
   val VARCHAR(300) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE utilisateur(
   id SERIAL,
   email VARCHAR(255) NOT NULL,
   mdp VARCHAR(300) NOT NULL,
   nom VARCHAR(300) NOT NULL,
   isverified BOOLEAN NOT NULL,
   tentative INT NOT NULL DEFAULT 0,
   idrole INT NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(email),
   FOREIGN KEY(idrole) REFERENCES role(id)
);

CREATE TABLE tokenutilisateur(
   id SERIAL,
   expiration TIMESTAMP NOT NULL,
   token VARCHAR(300) NOT NULL,
   daty TIMESTAMP NOT NULL,
   idutilisateur INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idutilisateur) REFERENCES utilisateur(id)
);

CREATE TABLE pinutilisateur(
   id SERIAL,
   daty TIMESTAMP NOT NULL,
   code INT NOT NULL,
   expiration TIMESTAMP,
   idutilisateur INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idutilisateur) REFERENCES utilisateur(id)
);

alter table utilisateur add dateinscription TIMESTAMP;
alter table utilisateur drop idrole;
alter table tokenutilisateur add CONSTRAINT uniquetoken UNIQUE(token);

drop table role;