create database registro;
	use registro;

	create table productos(
	id_producto int(4) not null auto_increment primary key,
	producto varchar(20) not null,
	descripcion varchar(140) not null,
	existencias int(4) not null,
	precio_compra double(7,2) not null,
	precio_venta double(7,2) not null
	);
