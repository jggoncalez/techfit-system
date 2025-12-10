-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: techfitdatabase
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aulas`
--

DROP TABLE IF EXISTS `aulas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aulas` (
  `AU_ID` int NOT NULL AUTO_INCREMENT,
  `FU_ID` int NOT NULL,
  `AU_NOME` varchar(255) NOT NULL,
  `AU_DATA` date NOT NULL,
  `AU_HORA_INICIO` time NOT NULL,
  `AU_HORA_FIM` time NOT NULL,
  `AU_VAGAS_DISPONIVEIS` int NOT NULL,
  `AU_VAGAS_TOTAIS` int NOT NULL,
  `AU_SALA` varchar(100) DEFAULT NULL,
  `AU_STATUS` enum('AGENDADA','EM_ANDAMENTO','CONCLUIDA','CANCELADA') NOT NULL DEFAULT 'AGENDADA',
  `AU_OBSERVACOES` text,
  PRIMARY KEY (`AU_ID`),
  UNIQUE KEY `AU_NOME` (`AU_NOME`),
  KEY `FU_ID` (`FU_ID`),
  CONSTRAINT `aulas_ibfk_1` FOREIGN KEY (`FU_ID`) REFERENCES `funcionarios` (`FU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aulas`
--

LOCK TABLES `aulas` WRITE;
/*!40000 ALTER TABLE `aulas` DISABLE KEYS */;
INSERT INTO `aulas` VALUES (1,1,'Zumba para Iniciantes','2025-01-15','18:00:00','19:00:00',20,20,'Sala 1','AGENDADA',NULL),(2,2,'Cross Fit Avançado','2025-01-16','19:00:00','20:00:00',15,15,'Box 1','AGENDADA',NULL),(3,3,'Pilates Correção Postural','2025-01-17','08:00:00','09:00:00',10,10,'Estúdio 2','AGENDADA',NULL),(4,1,'Yoga Relaxante','2025-01-18','07:00:00','08:00:00',15,15,'Sala Zen','AGENDADA',NULL);
/*!40000 ALTER TABLE `aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercicios`
--

DROP TABLE IF EXISTS `exercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercicios` (
  `EX_NOME` varchar(255) NOT NULL,
  `EX_DIFICULDADE` int NOT NULL,
  `EX_ID` int NOT NULL AUTO_INCREMENT,
  `EX_TIPO` enum('PEITO','COSTAS','PERNAS','OMBROS','BRACOS','ABDOMEN','CARDIO','FUNCIONAL') NOT NULL,
  `EX_DESCRICAO` text,
  `EX_PONTUACAO` int DEFAULT '10',
  `EX_TEMPO_DESCANSO` int DEFAULT '60',
  `EX_EQUIPAMENTO` varchar(100) DEFAULT NULL,
  `EX_MIN_REPETICOES` int DEFAULT '8',
  `EX_MAX_REPETICOES` int DEFAULT '20',
  PRIMARY KEY (`EX_ID`),
  UNIQUE KEY `EX_NOME` (`EX_NOME`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercicios`
--

LOCK TABLES `exercicios` WRITE;
/*!40000 ALTER TABLE `exercicios` DISABLE KEYS */;
INSERT INTO `exercicios` VALUES ('Supino Reto',2,1,'PEITO','Exercício básico para peitoral maior',15,60,'Barra e Banco',8,12),('Supino Inclinado',3,2,'PEITO','Foco no peitoral superior',16,60,'Barra e Banco Inclinado',8,12),('Crucifixo',2,3,'PEITO','Isolamento do peitoral',12,60,'Halteres',10,15),('Flexão',1,4,'PEITO','Exercício com peso corporal',10,60,'Peso Corporal',10,20),('Barra Fixa',4,5,'COSTAS','Exercício composto para dorsal',18,60,'Barra Fixa',6,12),('Remada Curvada',3,6,'COSTAS','Desenvolvimento do dorsal e trapézio',16,60,'Barra',8,12),('Pulldown',2,7,'COSTAS','Exercício para dorsal na polia',14,60,'Polia Alta',10,15),('Remada Unilateral',2,8,'COSTAS','Trabalho assimétrico das costas',13,60,'Halter',10,12),('Agachamento Livre',4,9,'PERNAS','Exercício completo para membros inferiores',20,60,'Barra',8,15),('Leg Press',2,10,'PERNAS','Exercício para quadríceps e glúteos',15,60,'Leg Press',10,15),('Cadeira Extensora',1,11,'PERNAS','Isolamento de quadríceps',10,60,'Cadeira Extensora',12,20),('Mesa Flexora',2,12,'PERNAS','Isolamento de posteriores',11,60,'Mesa Flexora',12,20),('Stiff',3,13,'PERNAS','Exercício para posteriores e glúteos',17,60,'Barra',8,12),('Desenvolvimento',3,14,'OMBROS','Exercício composto para deltoides',16,60,'Barra ou Halteres',8,12),('Elevação Lateral',2,15,'OMBROS','Isolamento do deltoide lateral',12,60,'Halteres',12,15),('Elevação Frontal',2,16,'OMBROS','Foco no deltoide anterior',12,60,'Halteres',12,15),('Rosca Direta',2,17,'BRACOS','Exercício para bíceps',12,60,'Barra',10,15),('Tríceps Testa',2,18,'BRACOS','Isolamento de tríceps',12,60,'Barra',10,15),('Rosca Martelo',2,19,'BRACOS','Trabalho de bíceps e antebraço',11,60,'Halteres',10,15),('Tríceps Corda',2,20,'BRACOS','Exercício para tríceps na polia',11,60,'Polia',12,15),('Abdominal Supra',1,21,'ABDOMEN','Exercício básico para abdômen',8,60,'Peso Corporal',15,30),('Prancha',2,22,'ABDOMEN','Exercício isométrico core',10,60,'Peso Corporal',30,60),('Abdominal Infra',2,23,'ABDOMEN','Foco na região inferior',9,60,'Peso Corporal',15,25),('Esteira',1,24,'CARDIO','Corrida ou caminhada',15,60,'Esteira',20,60),('Bicicleta',1,25,'CARDIO','Exercício cardiovascular',12,60,'Bicicleta Ergométrica',20,45),('Elíptico',1,26,'CARDIO','Exercício de baixo impacto',13,60,'Elíptico',20,40);
/*!40000 ALTER TABLE `exercicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionarios` (
  `FU_ID` int NOT NULL AUTO_INCREMENT,
  `FU_GENERO` char(1) NOT NULL DEFAULT 'M',
  `FU_NIVEL_ACESSO` int NOT NULL DEFAULT '1',
  `FU_SENHA` varchar(255) NOT NULL,
  `FU_NOME` varchar(255) NOT NULL,
  `FU_SALARIO` decimal(8,2) DEFAULT NULL,
  `FU_DATA_ADMISSAO` date NOT NULL,
  `FU_EMAIL` varchar(255) NOT NULL,
  PRIMARY KEY (`FU_ID`),
  UNIQUE KEY `FU_NOME` (`FU_NOME`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionarios`
--

LOCK TABLES `funcionarios` WRITE;
/*!40000 ALTER TABLE `funcionarios` DISABLE KEYS */;
INSERT INTO `funcionarios` VALUES (1,'M',3,'senha123','Carlos Alberto Silva',3500.00,'2023-05-10','carlos.silva@techfit.com'),(2,'F',2,'senha123','Maria Fernanda Oliveira',2800.00,'2023-07-01','maria.oliveira@techfit.com'),(3,'M',1,'senha123','João Pedro Almeida',2200.00,'2024-01-15','joao.almeida@techfit.com'),(4,'F',1,'senha123','Ana Paula Martins',2100.00,'2024-03-20','ana.martins@techfit.com'),(5,'M',2,'senha123','Ricardo Moura',2900.00,'2022-11-11','ricardo.moura@techfit.com'),(6,'F',3,'senha123','Juliana Souza',3600.00,'2023-09-30','juliana.souza@techfit.com'),(7,'M',1,'senha123','Paulo Henrique Costa',2000.00,'2024-02-12','paulo.costa@techfit.com'),(8,'F',2,'senha123','Letícia Ramos',2750.00,'2023-08-18','leticia.ramos@techfit.com'),(9,'M',1,'senha123','Diego Nascimento',2150.00,'2024-04-07','diego.nascimento@techfit.com'),(10,'F',1,'senha123','Carolina Mendes',2050.00,'2024-04-25','carolina.mendes@techfit.com');
/*!40000 ALTER TABLE `funcionarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamentos` (
  `PG_ID` int NOT NULL AUTO_INCREMENT,
  `US_ID` int NOT NULL,
  `PL_ID` int NOT NULL,
  `PG_VALOR` decimal(7,2) NOT NULL,
  `PG_DATA_VENCIMENTO` date NOT NULL,
  `PG_DATA_PAGAMENTO` date DEFAULT NULL,
  `PG_STATUS` enum('PENDENTE','PAGO','ATRASADO','CANCELADO') DEFAULT 'PENDENTE',
  `PG_METODO_PAGAMENTO` enum('DINHEIRO','CARTAO_CREDITO','CARTAO_DEBITO','PIX','BOLETO') DEFAULT NULL,
  `PG_OBSERVACOES` text,
  PRIMARY KEY (`PG_ID`),
  KEY `US_ID` (`US_ID`),
  KEY `PL_ID` (`PL_ID`),
  CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`),
  CONSTRAINT `pagamentos_ibfk_2` FOREIGN KEY (`PL_ID`) REFERENCES `planos` (`PL_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamentos`
--

LOCK TABLES `pagamentos` WRITE;
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participacoes_aula`
--

DROP TABLE IF EXISTS `participacoes_aula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participacoes_aula` (
  `PA_ID` int NOT NULL AUTO_INCREMENT,
  `AU_ID` int NOT NULL,
  `US_ID` int NOT NULL,
  `PA_DATA_INSCRICAO` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PA_STATUS` enum('INSCRITO','PRESENTE','AUSENTE','CANCELADO') DEFAULT 'INSCRITO',
  `PA_AVALIACAO` int DEFAULT NULL,
  `PA_COMENTARIO` text,
  PRIMARY KEY (`PA_ID`),
  KEY `AU_ID` (`AU_ID`),
  KEY `US_ID` (`US_ID`),
  CONSTRAINT `participacoes_aula_ibfk_1` FOREIGN KEY (`AU_ID`) REFERENCES `aulas` (`AU_ID`),
  CONSTRAINT `participacoes_aula_ibfk_2` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participacoes_aula`
--

LOCK TABLES `participacoes_aula` WRITE;
/*!40000 ALTER TABLE `participacoes_aula` DISABLE KEYS */;
/*!40000 ALTER TABLE `participacoes_aula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planos`
--

DROP TABLE IF EXISTS `planos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planos` (
  `PL_ID` int NOT NULL AUTO_INCREMENT,
  `PL_NOME` varchar(20) NOT NULL,
  `PL_PRECO` decimal(7,2) NOT NULL,
  `PL_BENEFICIOS` json NOT NULL,
  `PL_ATIVO` tinyint(1) NOT NULL DEFAULT '1',
  `PL_DATA_CRIACAO` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PL_ID`),
  UNIQUE KEY `PL_NOME` (`PL_NOME`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planos`
--

LOCK TABLES `planos` WRITE;
/*!40000 ALTER TABLE `planos` DISABLE KEYS */;
INSERT INTO `planos` VALUES (1,'Starter',60.00,'{\"beneficios\": [\"First Training\", \"Acesso a uma academia\", \"Sistema de Rankings\"]}',1,'2025-12-10 16:20:20'),(2,'Basic',100.00,'{\"beneficios\": [\"First Training\", \"Acesso a todas academias\", \"Treinos Personalizados\", \"Sistema de Rankings\", \"Rendimento por treino\"]}',1,'2025-12-10 16:20:20'),(3,'Advanced',150.00,'{\"beneficios\": [\"First Training\", \"Acesso a todas academias\", \"Treinos Personalizados\", \"Sistema de Rankings\", \"Rendimento por treino\", \"1 treino com personal/semana\", \"Aulas ilimitadas\"]}',1,'2025-12-10 16:20:20');
/*!40000 ALTER TABLE `planos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pontuacao`
--

DROP TABLE IF EXISTS `pontuacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pontuacao` (
  `PT_MUSCULO` varchar(50) NOT NULL,
  `PT_ID` int NOT NULL AUTO_INCREMENT,
  `PT_GRUPO_MUSCULAR` enum('PEITO','COSTAS','PERNAS','OMBROS','BRACOS','ABDOMEN') NOT NULL,
  `PT_PONTOS` int DEFAULT '0',
  `TR_ID` int NOT NULL,
  `US_ID` int NOT NULL,
  PRIMARY KEY (`PT_ID`),
  KEY `TR_ID` (`TR_ID`),
  KEY `US_ID` (`US_ID`),
  CONSTRAINT `pontuacao_ibfk_1` FOREIGN KEY (`TR_ID`) REFERENCES `treinos` (`TR_ID`),
  CONSTRAINT `pontuacao_ibfk_2` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pontuacao`
--

LOCK TABLES `pontuacao` WRITE;
/*!40000 ALTER TABLE `pontuacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `pontuacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_entradas`
--

DROP TABLE IF EXISTS `registro_entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_entradas` (
  `RE_ID` int NOT NULL AUTO_INCREMENT,
  `US_ID` int DEFAULT NULL,
  `RFID_ID` int DEFAULT NULL,
  `RE_DATA_HORA` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `RE_TIPO_ENTRADA` enum('RFID','MANUAL','QR_CODE') NOT NULL,
  `RE_STATUS` enum('PERMITIDO','NEGADO') NOT NULL,
  `RE_MOTIVO_NEGACAO` varchar(255) DEFAULT NULL,
  `RE_LOCALIZACAO` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`RE_ID`),
  KEY `US_ID` (`US_ID`),
  KEY `RFID_ID` (`RFID_ID`),
  CONSTRAINT `registro_entradas_ibfk_1` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`) ON DELETE SET NULL,
  CONSTRAINT `registro_entradas_ibfk_2` FOREIGN KEY (`RFID_ID`) REFERENCES `rfid_tags` (`RFID_ID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_entradas`
--

LOCK TABLES `registro_entradas` WRITE;
/*!40000 ALTER TABLE `registro_entradas` DISABLE KEYS */;
INSERT INTO `registro_entradas` VALUES (1,2,2,'2025-12-10 16:20:27','RFID','PERMITIDO',NULL,'Entrada Principal');
/*!40000 ALTER TABLE `registro_entradas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rfid_tags`
--

DROP TABLE IF EXISTS `rfid_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rfid_tags` (
  `RFID_ID` int NOT NULL AUTO_INCREMENT,
  `RFID_TAG_CODE` varchar(50) NOT NULL,
  `US_ID` int NOT NULL,
  `RFID_STATUS` enum('ATIVO','INATIVO','BLOQUEADO') DEFAULT 'ATIVO',
  `RFID_DATA_EMISSAO` date NOT NULL,
  `RFID_DATA_EXPIRACAO` date DEFAULT NULL,
  PRIMARY KEY (`RFID_ID`),
  UNIQUE KEY `RFID_TAG_CODE` (`RFID_TAG_CODE`),
  KEY `US_ID` (`US_ID`),
  CONSTRAINT `rfid_tags_ibfk_1` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rfid_tags`
--

LOCK TABLES `rfid_tags` WRITE;
/*!40000 ALTER TABLE `rfid_tags` DISABLE KEYS */;
INSERT INTO `rfid_tags` VALUES (1,'2E20F804',1,'ATIVO','2025-12-10','2026-12-10'),(2,'FAC07FBF',2,'ATIVO','2025-12-10','2026-12-10');
/*!40000 ALTER TABLE `rfid_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treino_exercicios`
--

DROP TABLE IF EXISTS `treino_exercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `treino_exercicios` (
  `TE_ID` int NOT NULL AUTO_INCREMENT,
  `TR_ID` int NOT NULL,
  `EX_ID` int NOT NULL,
  `TE_ORDEM` int NOT NULL,
  `TE_SERIES` int NOT NULL,
  `TE_REPETICOES` int NOT NULL,
  `TE_OBSERVACOES` text,
  PRIMARY KEY (`TE_ID`),
  KEY `TR_ID` (`TR_ID`),
  KEY `EX_ID` (`EX_ID`),
  CONSTRAINT `treino_exercicios_ibfk_1` FOREIGN KEY (`TR_ID`) REFERENCES `treinos` (`TR_ID`),
  CONSTRAINT `treino_exercicios_ibfk_2` FOREIGN KEY (`EX_ID`) REFERENCES `exercicios` (`EX_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treino_exercicios`
--

LOCK TABLES `treino_exercicios` WRITE;
/*!40000 ALTER TABLE `treino_exercicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `treino_exercicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treinos`
--

DROP TABLE IF EXISTS `treinos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `treinos` (
  `TR_ID` int NOT NULL AUTO_INCREMENT,
  `TR_NOME` varchar(255) NOT NULL,
  `TR_DATA_CRIACAO` date NOT NULL,
  `TR_STATUS` varchar(100) DEFAULT NULL,
  `US_ID` int NOT NULL,
  `TR_DURACAO_ESTIMADA` int NOT NULL,
  `TR_OBSERVACOES` text,
  PRIMARY KEY (`TR_ID`),
  KEY `US_ID` (`US_ID`),
  CONSTRAINT `treinos_ibfk_1` FOREIGN KEY (`US_ID`) REFERENCES `usuarios` (`US_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treinos`
--

LOCK TABLES `treinos` WRITE;
/*!40000 ALTER TABLE `treinos` DISABLE KEYS */;
/*!40000 ALTER TABLE `treinos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `US_PESO` decimal(5,2) NOT NULL,
  `US_DATA_NASCIMENTO` date NOT NULL,
  `US_ID` int NOT NULL AUTO_INCREMENT,
  `US_NOME` varchar(25) NOT NULL,
  `US_SENHA` varchar(255) NOT NULL DEFAULT '1234',
  `US_GENERO` char(1) NOT NULL DEFAULT 'M',
  `US_ALTURA` int NOT NULL,
  `US_OBJETIVO` enum('EMAGRECER','GANHAR PESO','SAÚDE') DEFAULT NULL,
  `US_TREINO_ANTERIOR` tinyint(1) NOT NULL,
  `US_TEMPO_TREINOANT` int DEFAULT NULL,
  `US_ENDERECO` varchar(255) NOT NULL,
  `US_DISPONIBILIDADE` json NOT NULL,
  `PL_ID` int NOT NULL,
  `US_STATUS_PAGAMENTO` enum('EM_DIA','ATRASADO','CANCELADO') DEFAULT 'EM_DIA',
  PRIMARY KEY (`US_ID`),
  UNIQUE KEY `US_NOME` (`US_NOME`),
  KEY `PL_ID` (`PL_ID`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`PL_ID`) REFERENCES `planos` (`PL_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (75.50,'2000-01-15',1,'Heniq','1234','M',175,'SAÚDE',1,12,'Rua Exemplo, 123 - Limeira/SP','{\"dias\": [\"SEG\", \"QUA\", \"SEX\"], \"horario\": \"MANHA\"}',2,'EM_DIA'),(75.50,'2000-01-15',2,'João','1234','M',175,'SAÚDE',1,12,'Rua Exemplo, 123 - Limeira/SP','{\"dias\": [\"SEG\", \"QUA\", \"SEX\"], \"horario\": \"MANHA\"}',2,'EM_DIA');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'techfitdatabase'
--

--
-- Dumping routines for database 'techfitdatabase'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-10 13:22:09
