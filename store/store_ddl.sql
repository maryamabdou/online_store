drop database if exists store;
create database store;
use store;

create table users(
    id int primary key auto_increment,
    name varchar(255) not null,
    email varchar(255) not null unique,
    password varchar(255) not null,
    phone varchar(255) unique,
    created_at datetime default CURRENT_TIMESTAMP(),
    role enum("admin", "user", "vendor") default "user",
    created_user int,
    token varchar(255) unique;
    foreign key (created_user) references users(id)
);

create table vendors(
    id int primary key auto_increment,
    vendor_id int,
    national_id varchar(255) not null,
    storeName varchar(255) not null,
    taxNo int unique,
    foreign key (vendor_id) references users(id)
);

create table categories(
    id int primary key auto_increment,
    name varchar(255) not null,
    referenced_id int,
    foreign key (referenced_id) references categories(id)
);

create table product(
    id int primary key auto_increment,
    name varchar(255) not null,
    price float not null,
    quantity int,
    category_id int,
    vendor_id int,
    img_src varchar(255),
    enable_prod int default 1;
    foreign key (category_id) references categories(id),
    foreign key (vendor_id) references vendors(id)
);

create table order_details(
    id int primary key auto_increment,
    product_id int,
    quantity int,
    order_id int,
    foreign key (product_id) references product(id),
    foreign key (order_id) references orders(id)
);

create table orders(
    id int primary key auto_increment,
    user_id int,
    price int,
    status enum("ordered", "delivered") default "ordered",
    foreign key (user_id) references users(id)
);
    
create trigger decrease after insert on order_details 
for each row
update product
    set product.quantity = product.quantity - 
    (select order_details.quantity from order_details join product 
    on order_details.product_id = product.id);


update product
set product.quantity = product.quantity - 
(select new.quantity from order_details join product 
on new.product_id = product.id 
where product.quantity > 0 and order_details.quantity < product.quantity);


drop TRIGGER if EXISTS decrease;
create trigger decrease before insert on order_details 
for each row
select quantity into @quantity from product join order_details on new.product_id = product.id;
SELECT @quantity;
if q > 0 then
    begin
    select new.quantity into @entered from order_details;
    if select @entered <= select @quantity then
        update product
        set product.quantity = product.quantity - select @entered;
    end if;
    end;
end if;
