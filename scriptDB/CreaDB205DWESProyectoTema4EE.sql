USE dbs9174047;

CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento VARCHAR(3) NOT NULL PRIMARY KEY,
  T02_DescDepartamento VARCHAR (255) NOT NULL,
  T02_FechaCreacionDepartamento DATETIME NOT NULL,
  T02_FechaBaja DATETIME,
  T02_VolumenNegocio FLOAT NOT NULL) ENGINE = INNODB;




