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
--Show all items purchased by customer Uma Shaw.

SELECT i_name
FROM customer, orders, contains, items, sells
WHERE c_custid = o_custid AND o_orderid = co_orderid AND co_stockid = se_stockid AND co_storeid = se_storeid AND se_itemid = i_itemid AND c_name = "Uma Shaw";

SELECT '---------------------------------#2------------------------------------';
--Show all items that are games with any genre linked to Horror

SELECT i_name, i_platform
FROM items, games
WHERE (i_type = 'G' AND i_genericid = g_gameid) AND lower(g_genre) LIKE lower('%Horror%');

SELECT '---------------------------------#3------------------------------------';
--Show all items that have II in the title

SELECT i_name, i_platform
FROM items
WHERE lower(i_name) LIKE lower('%II%');

SELECT '---------------------------------#4------------------------------------';
--Show all items related to the PS4

SELECT *
FROM items
WHERE lower(i_platform) LIKE lower('playstation 4');

SELECT '---------------------------------#5------------------------------------';
--Storefront TotallyLegitShop (ID#1) wants to list a new item, 5 pre-owned quantities of The Last of Us Part II for PlayStation 4 (ID#1) at 69.99

INSERT INTO sells VALUES(1, 4, 1, 69.99, 5, 'Y');
SELECT *
FROM sells;

SELECT '---------------------------------#6, #7, #8------------------------------------';
--A new video game, Cyberpunk 2077 is coming out soon for PS4 and Xbox One, so the website is adding it into the game database so that sellers can list it.

INSERT INTO games VALUES(6, 'Cyberpunk 2077', 'B', 'First Person Shooter RPG', 'RP', 2020);
INSERT INTO items VALUES(13, 6, 'Cyberpunk 2077', 'PlayStation 4', 'G');
INSERT INTO items VALUES(13, 6, 'Cyberpunk 2077', 'Xbox One', 'G');

SELECT *
FROM games
WHERE g_gameid = 6;
SELECT '-----------------------------------------------------------------------';

SELECT *
FROM items;

SELECT '---------------------------------#9------------------------------------';
--Hypothetically, Cyperpunk 2077 is rated M so the database should reflect that

UPDATE games
SET g_rating = 'M'
WHERE g_name = 'Cyberpunk 2077';
SELECT *
FROM games;

SELECT '---------------------------------#10------------------------------------';
--A new storefront registers to the website

INSERT INTO storefront VALUES(8, 'Sweet Spot Games', '252 W North Dr', '(359) 349-5043');

SELECT *
FROM storefront;

SELECT '---------------------------------#11------------------------------------';
--Output the phone number of the store that Customer ID#20 ordered from

SELECT s_phone
FROM customer, orders, storefront
WHERE o_custid = c_custid AND s_storeid = o_storeid AND c_custid = 20;
