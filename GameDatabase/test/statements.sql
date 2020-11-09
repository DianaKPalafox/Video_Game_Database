DROP TABLE games;
DROP TABLE accessories;
DROP TABLE customer;
DROP TABLE storefront;
DROP TABLE orders;
DROP TABLE items;
DROP TABLE sells;
DROP TABLE prefers;
DROP TABLE contains;
--DROP TABLE supplies;
--DROP TABLE makes;

CREATE TABLE games(
g_gameid decimal(10,0) not null,
g_name char(25) not null,
g_solo char(1) not null,
g_genre char(25) not null,
g_rating char(4) not null,
g_year decimal(4,0) not null
);

-- HAHA CHANGE THIS

CREATE TABLE accessories(
a_accid decimal(10,0) not null,
a_name char(25) not null,
a_type char(25) not null,
a_color char(25) not null
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

CREATE TABLE orders(
o_orderid decimal(12,0) not null,
o_custid decimal(10,0) not null,
o_storeid decimal(10,0) not null,
o_orderdate date not null,
o_orderstatus char(1) not null
);

CREATE TABLE items(
i_itemid decimal(10,0) not null,
i_genericid decimal(10,0) not null,
i_name varchar(25) not null,
i_platform varchar(25) not null,
i_type char(1) not null
);

CREATE TABLE sells(
se_storeid decimal(10,0) not null,
se_stockid decimal(10,0) not null,
se_itemid decimal(10,0) not null,
se_price decimal(6,2) not null,
se_quantity decimal(5,0) not null,
se_preowned char(1) not null
);

CREATE TABLE contains(
co_orderid decimal(12,0) not null,
co_storeid decimal(10,0) not null,
co_stockid decimal(10,0) not null,
co_quantity decimal(5,0) not null
);

CREATE TABLE prefers(
p_custid decimal(10,0) not null,
p_genre char(25) not null
);

.mode "csv"
.separator "|"
.import data/customer.csv customer
.import data/storefront.csv storefront
.import data/games.csv games
.import data/items.csv items
.import data/orders.csv orders
.import data/prefers.csv prefers
.import data/sells.csv sells
.import data/contains.csv contains
.import data/accessories.csv accessories

SELECT '---------------------------------#1------------------------------------';
SELECT 'Show all items purchased by customer Uma Shaw.';

SELECT i_name
FROM customer, orders, contains, items, sells
WHERE c_custid = o_custid AND o_orderid = co_orderid AND co_stockid = se_stockid AND co_storeid = se_storeid AND se_itemid = i_itemid AND c_name = "Uma Shaw";

SELECT '---------------------------------#2------------------------------------';
SELECT 'Show all items that are games with any genre linked to Horror';

SELECT i_name, i_platform
FROM items, games
WHERE (i_type = 'G' AND i_genericid = g_gameid) AND lower(g_genre) LIKE lower('%Horror%');

SELECT '---------------------------------#3------------------------------------';
SELECT 'Show all items that have II in the title';

SELECT i_name, i_platform
FROM items
WHERE lower(i_name) LIKE ('%II%');

SELECT '---------------------------------#4------------------------------------';
