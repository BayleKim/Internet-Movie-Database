create table Movie ( id int, title varchar(100), year int, rating varchar(10), company varchar(50), primary key(id));
create table Actor ( id int, last varchar(20), first varchar(20), sex varchar(6), dob date, dod date, primary key(id));
create table MovieGenre ( mid int, genre varchar(20));
create table MovieActor ( mid int, aid int, role varchar(50));
create table Review ( name varchar(20), time datetime, mid int, rating int, comment text);