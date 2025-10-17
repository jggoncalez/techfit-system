-- ------------------------- --
-- Geração de Modelo físico  --
-- Sql ANSI 2003 - brModelo. -- 
-- ------------------------- --

-- Iniciando o Banco de Dados
create database TechFitDatabase;
use TechFitDatabase;

-- Criando as Tabelas
-- Tabela Agendamento
CREATE TABLE AGENDAMENTO (
AU_NOME VARCHAR(255) NOT NULL,
AU_HORARIO TIME NOT NULL,
AU_ID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
AU_VAGAS INT NOT NULL
);

-- Tabela Funcionários
CREATE TABLE FUNCIONARIOS (
FU_ID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
FU_GENERO CHAR DEFAULT 'M'  NOT NULL,
FU_NIVEL_ACESSO INT DEFAULT '1' NOT NULL,
FU_SENHA VARCHAR(255) NOT NULL,
FU_NOME VARCHAR(255) NOT NULL,
AU_ID INT NOT NULL,
FOREIGN KEY(AU_ID) REFERENCES AGENDAMENTO (AU_ID)
);

-- Tabela Exercicios
CREATE TABLE EXERCICIOS (
EX_QTTFEITA INT NOT NULL,
EX_NOME VARCHAR(255) NOT NULL,
EX_MAX_VALOR INT DEFAULT '999' NOT NULL,
EX_DIFICULDADE INT DEFAULT '1' NOT NULL,
EX_ID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
EX_TIPO VARCHAR(255) NOT NULL,
EX_MIN_VALOR INT DEFAULT '10'  NOT NULL,
EX_PONTUACAO JSON not null
);

-- Tabela Planos
CREATE TABLE PLANOS (
PL_ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL PRIMARY KEY,
PL_NOME VARCHAR(20) NOT NULL,
PL_PRECO DECIMAL(5,2) NOT NULL,
PL_BENEFICIOS JSON not null
);
-- Tabela Usuarios
CREATE TABLE USUARIOS (
US_PESO DECIMAL(5,2) NOT NULL,
US_DATA_NASCIMENTO DATE NOT NULL,
US_ID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
US_NOME VARCHAR(25) NOT NULL,
US_GENERO CHAR DEFAULT 'M'  NOT NULL,
US_IDADE INT NOT NULL,
US_ALTURA INT NOT NULL,
US_PORC_MASSA_MAGRA FLOAT NOT NULL,
US_TREINO_ANTERIOR BOOLEAN NOT NULL,
US_TEMPO_TREINOANT INT,
US_ENDERECO VARCHAR(9) NOT NULL,
US_DISPONIBILIDADE 	JSON not null,
EX_ID INT NOT NULL,
PL_ID INT NOT NULL,
foreign key (PL_ID) references planos(PL_ID),
FOREIGN KEY(EX_ID) REFERENCES EXERCICIOS (EX_ID)
);

-- Tabela Treinos
CREATE TABLE TREINOS (
TR_ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL PRIMARY KEY,
TR_DATA_CRIACAO DATE NOT NULL,
US_ID INT NOT NULL,
foreign key (US_ID) references Usuarios(US_ID)
);

-- Tabela Pontuacao
CREATE TABLE PONTUACAO (
PT_MUSCULO VARCHAR(50) NOT NULL,
PT_ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL PRIMARY KEY,
PT_PONTOS INT DEFAULT 0,
TR_ID INT NOT NULL,
US_ID INT NOT NULL,
FOREIGN KEY(TR_ID) REFERENCES TREINOS (TR_ID),
FOREIGN KEY(US_ID) REFERENCES USUARIOS (US_ID)
);

-- Relação Seleciona
CREATE TABLE SELECIONA (
TR_ID INT NOT NULL,
EX_ID INT NOT NULL,
FOREIGN KEY(TR_ID) REFERENCES TREINOS (TR_ID),
FOREIGN KEY(EX_ID) REFERENCES EXERCICIOS (EX_ID)
);

-- Relação Agendam
CREATE TABLE AGENDAM (
US_ID INT NOT NULL,
AU_ID INT NOT NULL,
FOREIGN KEY(US_ID) REFERENCES USUARIOS (US_ID),
FOREIGN KEY(AU_ID) REFERENCES AGENDAMENTO (AU_ID)
);

-- Criando Inserts 
INSERT INTO Planos (PL_ID, PL_NOME, PL_PRECO, PL_BENEFICIOS) 
VALUES (
    1,
    "Starter",
    60,
    '{"Beneficio1":"First Training","Beneficio2":"Acesso a Uma academia","Beneficio3":"Sistema de Rankings"}'
);

INSERT INTO Planos (PL_ID, PL_NOME, PL_PRECO, PL_BENEFICIOS) VALUES
(2, 'Basic', 100.00, '{
  "Beneficio1": "First Training",
  "Beneficio2": "Acesso a todas as academias",
  "Beneficio3": "Treinos Personalizados",
  "Beneficio4": "Sistema de Rankings",
  "Beneficio5": "Sistema de Rendimento por Treino"
}'),
(3, 'Advanced', 150.00, '{
  "Beneficio1": "First Training",
  "Beneficio2": "Acesso a todas as academias",
  "Beneficio3": "Treinos Personalizados",
  "Beneficio4": "Sistema de Rankings",
  "Beneficio5": "Sistema de Rendimento por treino",
  "Beneficio6": "1 treino com personal por semana"
}');

INSERT INTO AGENDAMENTO (AU_NOME, AU_HORARIO, AU_VAGAS) VALUES
('Treino Manhã', '06:00:00', 10),
('Treino Tarde', '14:00:00', 15),
('Treino Noite', '19:00:00', 12),
('Treino Extra', '20:00:00', 8),
('Treino Funcional', '07:30:00', 10),
('Treino Cardio', '09:00:00', 20),
('Treino Força', '16:00:00', 15),
('Treino HIIT', '18:00:00', 10),
('Treino Yoga', '08:00:00', 12),
('Treino Pilates', '17:30:00', 10);

INSERT INTO FUNCIONARIOS (FU_GENERO, FU_NIVEL_ACESSO, FU_SENHA, FU_NOME, AU_ID) VALUES
('M', 1, 'senha1', 'Carlos Silva', 1),
('F', 2, 'senha2', 'Ana Maria', 2),
('M', 1, 'senha3', 'João Pedro', 3),
('F', 3, 'senha4', 'Mariana Costa', 4),
('M', 2, 'senha5', 'Paulo Henrique', 5),
('F', 1, 'senha6', 'Juliana Souza', 6),
('M', 3, 'senha7', 'Ricardo Alves', 7),
('F', 2, 'senha8', 'Fernanda Lima', 8),
('M', 1, 'senha9', 'Lucas Oliveira', 9),
('F', 2, 'senha10', 'Amanda Rocha', 10);

INSERT INTO EXERCICIOS (EX_QTTFEITA, EX_NOME, EX_MAX_VALOR, EX_DIFICULDADE, EX_TIPO, EX_MIN_VALOR, EX_PONTUACAO) VALUES
(10, 'Supino Reto', 100, 3, 'Força', 20, '{"pontos": 10}'),
(15, 'Agachamento', 150, 4, 'Força', 30, '{"pontos": 15}'),
(20, 'Corrida', 60, 2, 'Cardio', 10, '{"pontos": 8}'),
(12, 'Flexão', 80, 3, 'Força', 15, '{"pontos": 12}'),
(8, 'Abdominal', 50, 1, 'Resistência', 5, '{"pontos": 6}'),
(25, 'Pular Corda', 70, 2, 'Cardio', 10, '{"pontos": 9}'),
(18, 'Levantamento Terra', 120, 5, 'Força', 25, '{"pontos": 20}'),
(30, 'Yoga', 40, 1, 'Flexibilidade', 5, '{"pontos": 5}'),
(22, 'Remada', 90, 3, 'Força', 20, '{"pontos": 14}'),
(14, 'Burpee', 75, 4, 'Cardio', 15, '{"pontos": 13}');

select * from usuarios;
INSERT INTO USUARIOS (US_PESO, US_DATA_NASCIMENTO, US_NOME, US_GENERO, US_IDADE, US_ALTURA, US_PORC_MASSA_MAGRA, US_TREINO_ANTERIOR, US_TEMPO_TREINOANT, US_ENDERECO, US_DISPONIBILIDADE, EX_ID, PL_ID) VALUES
(70.50, '1990-05-12', 'Lucas Silva', 'M', 35, 175, 15.5, TRUE, 12, '12345678', '{"dias":["Segunda","Quarta","Sexta"]}', 1, 2),
(65.00, '1985-10-22', 'Mariana Costa', 'F', 39, 165, 18.2, FALSE, NULL, '87654321', '{"dias":["Terça","Quinta"]}', 2, 3),
(80.00, '2000-01-15', 'Carlos Souza', 'M', 24, 180, 17.0, TRUE, 24, '11223344', '{"dias":["Segunda","Terça","Quinta"]}', 3, 2),
(55.50, '1995-07-30', 'Ana Lima', 'F', 28, 160, 20.0, FALSE, NULL, '44332211', '{"dias":["Quarta","Sexta"]}', 4, 3),
(90.00, '1988-12-10', 'Paulo Henrique', 'M', 35, 185, 16.0, TRUE, 18, '55667788', '{"dias":["Segunda","Quarta","Sexta"]}', 5, 2),
(68.75, '1992-11-05', 'Fernanda Alves', 'F', 31, 170, 19.5, TRUE, 36, '99887766', '{"dias":["Terça","Quinta"]}', 6, 3),
(77.20, '1997-03-20', 'Ricardo Gomes', 'M', 26, 178, 15.8, FALSE, NULL, '33445566', '{"dias":["Segunda","Quarta"]}', 7, 2),
(62.00, '1989-09-14', 'Juliana Rocha', 'F', 35, 165, 18.0, TRUE, 6, '55664433', '{"dias":["Terça","Quinta","Sábado"]}', 8, 3),
(85.00, '1991-08-22', 'Lucas Oliveira', 'M', 33, 182, 16.7, TRUE, 20, '66778899', '{"dias":["Segunda","Sexta"]}', 9, 2),
(58.00, '1994-06-01', 'Amanda Ferreira', 'F', 29, 160, 19.8, FALSE, NULL, '77889900', '{"dias":["Quarta","Sábado"]}', 10, 3);
ALTER TABLE USUARIOS AUTO_INCREMENT = 1;
DELETE FROM USUARIOS;

INSERT INTO TREINOS (TR_DATA_CRIACAO, US_ID) VALUES
('2025-10-01', 1),
('2025-10-02', 2),
('2025-10-03', 3),
('2025-10-04', 4),
('2025-10-05', 5),
('2025-10-06', 6),
('2025-10-07', 7),
('2025-10-08', 8),
('2025-10-09', 9),
('2025-10-10', 10);
delete from treinos;
alter table treinos auto_increment = 1;
select * from treinos;

INSERT INTO PONTUACAO (PT_MUSCULO, PT_PONTOS, TR_ID, US_ID) VALUES
('Peito', 50, 1, 1),
('Costas', 40, 2, 2),
('Pernas', 60, 3, 3),
('Braços', 45, 4, 4),
('Ombros', 30, 5, 5),
('Abdômen', 25, 6, 6),
('Glúteos', 35, 7, 7),
('Panturrilhas', 20, 8, 8),
('Trapézio', 15, 9, 9),
('Peito', 55, 10, 10);

INSERT INTO SELECIONA (TR_ID, EX_ID) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 9),
(5, 10);

INSERT INTO AGENDAM (US_ID, AU_ID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);
