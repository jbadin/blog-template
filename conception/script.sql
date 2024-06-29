#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

CREATE DATABASE `pf-blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pf-blog`;

#------------------------------------------------------------
# Table: usersroles
#------------------------------------------------------------

CREATE TABLE p79k8_usersroles(
        id   Int  Auto_increment  NOT NULL ,
        name Varchar (20) NOT NULL
	,CONSTRAINT usersroles_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE p79k8_users(
        id                  Int  Auto_increment  NOT NULL ,
        username            Varchar (20) NOT NULL ,
        firstname           Varchar (30) NOT NULL ,
        lastname            Varchar (30) NOT NULL ,
        email               Varchar (50) NOT NULL ,
        password            Varchar (255) NOT NULL ,
        locationName        Varchar (50) NOT NULL ,
        registrationDate    Datetime NOT NULL ,
        id_usersroles       Int NOT NULL
	,CONSTRAINT users_PK PRIMARY KEY (id)

	,CONSTRAINT users_usersroles_FK FOREIGN KEY (id_usersroles) REFERENCES p79k8_usersroles(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: postsCategories
#------------------------------------------------------------

CREATE TABLE p79k8_postsCategories(
        id   Int  Auto_increment  NOT NULL ,
        name Varchar (20) NOT NULL
	,CONSTRAINT postsCategories_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: posts
#------------------------------------------------------------

CREATE TABLE p79k8_posts(
        id                 Int  Auto_increment  NOT NULL ,
        content            Text NOT NULL ,
        publicationDate    Datetime NOT NULL ,
        id_postsCategories Int NOT NULL ,
        id_users           Int NOT NULL
	,CONSTRAINT posts_PK PRIMARY KEY (id)

	,CONSTRAINT posts_postsCategories_FK FOREIGN KEY (id_postsCategories) REFERENCES p79k8_postsCategories(id)
	,CONSTRAINT posts_users_FK FOREIGN KEY (id_users) REFERENCES p79k8_users(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: comments
#------------------------------------------------------------

CREATE TABLE p79k8_comments(
        id              Int  Auto_increment  NOT NULL ,
        content         Text NOT NULL ,
        publicationDate Datetime NOT NULL ,
        id_posts        Int NOT NULL
	,CONSTRAINT comments_PK PRIMARY KEY (id)

	,CONSTRAINT comments_posts_FK FOREIGN KEY (id_posts) REFERENCES p79k8_posts(id)
)ENGINE=InnoDB;