<?php
/* Aqui debes escribir los datos de la db
y eliminar el '.sample' del nombre del archivo*/
// DB CONFIG
const DBSERVER = '';
const DBNAME = '';
const DBUSER = '';
const DBPASS = '';

const DSN = 'mysql:host='.DBHOST.';dbname='.DBNAME;

/* Aqui debes agregar el valor que prefieras para la encriptacion de los datos (password, ids, etc)
No modificar luego de agregar registros a la db*/
// ENCRYPTION CONFIG
const METHOD = 'AES-256-CBC'; // NO MODIFICAR
const SECRET_KEY = '';
const SECRET_IV = '';