DROP TABLE games;
DROP TABLE accessories;
DROP TABLE customer;
DROP TABLE storefront;
DROP TABLE orders;
DROP TABLE items;

CREATE TABLE games(
g_gameid decimal(10,0) not null,
g_name char(25) not null,
g_solo char(1) not null,
g_genre char(25) not null,
g_rating char(3) not null,
g_year decimal(4,0) not null
);

CREATE TABLE accessories(
a_accid decimal(10,0) not null,
a_name char(25) not null,
a_type char(25) not null
);

CREATE TABLE customer(
c_custid decimal(10,0) not null,
c_name varchar(40) not null,
c_addy varchar(100) not null,
c_phone char(15) not null
);

CREATE TABLE storefront(
s_storeid decimal(10,0) not null,
s_name char(25) not null,
s_addy varchar(50) not null,
s_phone char(14) not null
);

CREATE TABLE orders (
o_orderid decimal(12,0) not null,
o_custid decimal(10,0) not null,
o_storeid decimal(10,0) not null,
o_receiptdate date not null,
o_shipdate date not null,
o_orderstatus char(1) not null
);

CREATE TABLE items(
i_itemid decimal(10,0) not null,
i_genericid decimal(10,0) not null,
i_name varchar(25) not null,
i_platform varchar(25) not null,
i_type char(25) not null
);

.mode "csv"
.separator "|"
.import data/customer.csv customer

SELECT *
FROM customer;
