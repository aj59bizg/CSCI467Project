drop table if exists inventory;
drop table if exists orders;
drop table if exists customer;
drop table if exists orderedItems;

create table inventory (
    id int auto_increment,
    quantity int,
    primary key (id)
);

create table orders (
    id int auto_increment,
    customerId int,
    orderStatus int,
    combinedWeight decimal(5,2),
    shippingCharges decimal(5,2),
    totalPrice decimal(5,2),
    PRIMARY KEY (id),
    foreign key (customerId) references customer(id)
);

create table orderedItems(
    orderId int,
    quantity int,
    productId int,
    primary key (orderId, productId),
    foreign key (orderId) references orders(id)
);

create table customer (
    id int auto_increment,
    name varchar(30),
    email varchar(30),
    mailingAddress varchar(30),
    creditCardNumber int,
    expirationDate date,
    primary key (id)
);
