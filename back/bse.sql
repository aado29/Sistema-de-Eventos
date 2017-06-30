

create table usuarios(
    id_usuario int primary key,
    cedula_u int,
    nombre_u varchar(150),
    contra_u varchar(150),
    telefono_u numeric,
    correo_u varchar(150),
    tipo_u varchar(150)
);

create table Equipos(
    id_equipo int primary key,
    nombre_e varchar(150),
    desc_e varchar(150),
    estado_e varchar(150)
);

create table grupos(
    id_grupo int primary key,
    nombre_g varchar(150),
    tipo_g varchar(150),
    desc_g varchar(150),
    telefono_g numeric,
    direccion_g varchar(150),
    correo_g varchar(150),
    num_miemb int ,
    estado_g varchar(150)
);

create table voluntarios(
    id_voluntario int primary key,
    cedula_v int,
    nombre_v varchar(150),
    apellido_v varchar(150),
    direccion_v varchar(150),
    correo_v varchar(150),
    talla_camisa varchar(150),
    talla_pantalon varchar(150),
    talla_zapatos varchar(150),
    cargo_v varchar(150),
    profesion_v varchar(150),
    especialidad_v varchar(150),
    ocupacion_V varchar(150),
    tipo_v varchar(150),
    estado_v varchar(150),
    -- foraneas
    id_equipo int,
    id_vehiculo int
);

create table vehiculos(
    id_vehiculo int primary key,
    placa varchar(150),
    marca varchar(150),
    modelo varchar(150),
    color varchar(150),
    ano int,
    num_carroceria numeric,
    num_motor numeric,
    num_chasis numeric,
    estado_vh varchar(150)
);

create table eventos(
    id_evento int primary key,
    tipo_ev varchar(150),
    f_incio date,
    f_fin date,
    lugar_ev varchar(150),
    -- foraneas
    id_grupo int,
    id_voluntario int,
    id_equipo int
);

create table reportes(
    id_reporte int,
    fecha_r int,
    -- foraneas
    id_evento int
);