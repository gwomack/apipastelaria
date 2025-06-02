#create database from env file
CREATE DATABASE ${POSTGRES_DB};

#create user from env file
CREATE USER ${POSTGRES_USER} WITH PASSWORD '${POSTGRES_PASSWORD}';

#grant all privileges on database to user
GRANT ALL PRIVILEGES ON DATABASE ${POSTGRES_DB} TO ${POSTGRES_USER};