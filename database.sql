CREATE DATABASE IF NOT EXISTS VOTACIONES_ULEAM;
USE VOTACIONES_ULEAM;


-- TABLAS

-- ROLES

CREATE TABLE ROLES (
    ID     INT(255) AUTO_INCREMENT NOT NULL,
    TYPE_ROLE   VARCHAR(100) NOT NULL,
    CONSTRAINT PK_ROLE PRIMARY KEY (ID)
)ENGINE=InnoDb;


-- CAREER 

CREATE TABLE CAREER (
    ID       INT(255) AUTO_INCREMENT NOT NULL,
    NAME_CAREER      VARCHAR(255) NOT NULL,
    CONSTRAINT PK_CAREER PRIMARY KEY (ID)
)ENGINE=InnoDb;

-- STUDIES

CREATE TABLE SEMESTER (
    ID      INT(255) AUTO_INCREMENT NOT NULL,
    NUM_SEMESTER       INT(255) NOT NULL,
    CONSTRAINT PK_SEMESTER PRIMARY KEY (ID)
)ENGINE=InnoDb;

-- STUDIES

CREATE TABLE STUDIES (
    ID      INT(255) AUTO_INCREMENT NOT NULL,
    ID_CAREER      INT(255) NOT NULL,
    ID_SEMESTER    INT(255) NOT NULL,
    CONSTRAINT PK_STUDY PRIMARY KEY (ID),
    CONSTRAINT FK_STUDIES_CAREER FOREIGN KEY (ID_CAREER) REFERENCES CAREER(ID),
    CONSTRAINT FK_STUDIES_SEMESTER FOREIGN KEY (ID_SEMESTER) REFERENCES SEMESTER(ID)

)ENGINE=InnoDb;





-- USERS

CREATE TABLE USERS (
    ID            INT(255) AUTO_INCREMENT NOT NULL,
    IDENTIFICATION_CARD   VARCHAR(100) NOT NULL,
    NAME                  VARCHAR(100) NOT NULL,
    LASTNAME              VARCHAR(100) NOT NULL,
    EMAIL                 VARCHAR(255) NOT NULL,
    PASSWORD              VARCHAR(255) NOT NULL,
    IMAGE_PROFILE         VARCHAR(255) NOT NULL,
    ID_ROLE               INT(255) 	   NOT NULL,
    ID_STUDY              INT(255)     NOT NULL,
    CREATED_AT            DATETIME DEFAULT NULL,
    UPDATED_AT            DATETIME DEFAULT NULL,
    REMEMBER_TOKEN        VARCHAR(255),
    CONSTRAINT PK_USER PRIMARY KEY (ID),
    CONSTRAINT FK_ROLE_USER FOREIGN KEY (ID_ROLE) REFERENCES ROLES(ID),
    CONSTRAINT FK_STUDIES_USER FOREIGN KEY (ID_STUDY) REFERENCES STUDIES(ID)


)ENGINE=InnoDb;




-- CERTIFICATES

CREATE TABLE CERTIFICATES (
    ID    INT(255) AUTO_INCREMENT NOT NULL,
    EXPEDITION_DATE   DATETIME DEFAULT NULL,
    EXPIRATION_DATE   DATETIME DEFAULT NULL,
    ID_USER              INT(255) NOT NULL,
    CONSTRAINT PK_CERTIFICATE PRIMARY KEY (ID),
    CONSTRAINT FK_CERTIFICATE_USER FOREIGN KEY (ID_USER) REFERENCES USERS(ID)

)ENGINE=InnoDb;

-- LISTS

CREATE TABLE LISTS (
    ID            INT(255) AUTO_INCREMENT NOT NULL,
    LIST_DESCRIPTION    VARCHAR(255) NOT NULL,
    IMAGE               VARCHAR(255) NOT NULL,
    CREATED_AT            DATETIME DEFAULT NULL,
    UPDATED_AT            DATETIME DEFAULT NULL,
    CONSTRAINT PK_LIST PRIMARY KEY (ID)
)ENGINE=InnoDb;

-- TYPE_CANDIDATES

CREATE TABLE TYPE_CANDIDATES (
    ID    INT(255) AUTO_INCREMENT NOT NULL,
    TYPE_CANDIDATE    VARCHAR(255) NOT NULL,
    CONSTRAINT PK_TYPE_CANDIDATE PRIMARY KEY (ID)
)ENGINE=InnoDb;




-- CANDIDATES

CREATE TABLE CANDIDATES (
    ID       INT(255) AUTO_INCREMENT NOT NULL,
    NAME_CANDIDATE     VARCHAR(255) NOT NULL,
    LASTNAME_CANDIDATE VARCHAR(255) NOT NULL,
    IMAGE_CANDIDATE    VARCHAR(255) NOT NULL,
    ID_TYPE_CANDIDATE INT(255) NOT NULL,
    ID_LIST            INT(255) NOT NULL,
    CREATED_AT            DATETIME DEFAULT NULL,
    UPDATED_AT            DATETIME DEFAULT NULL,
    CONSTRAINT PK_CANDIDATE PRIMARY KEY (ID),
    CONSTRAINT FK_CANDIDATE_LIST FOREIGN KEY (ID_LIST) REFERENCES LISTS(ID),
    CONSTRAINT FK_TYPE_CANDIDATE FOREIGN KEY (ID_TYPE_CANDIDATE) REFERENCES TYPE_CANDIDATES(ID)

)ENGINE=InnoDb;




-- VOTES
CREATE TABLE VOTES (
    ID           INT(255) AUTO_INCREMENT NOT NULL,
    ID_LIST    INT(255) NOT NULL,
    NUM_VOTE            INT(255) NOT NULL,
    CONSTRAINT PK_VOTE PRIMARY KEY (ID),
    CONSTRAINT FK_CANDIDATE_VOTE FOREIGN KEY (ID_LIST) REFERENCES LISTS(ID)
)ENGINE=InnoDb;


-- COUNT



