-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/05/2025 às 23:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `car_rent`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '2022-06-23 09:59:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblboleto`
--

CREATE TABLE `tblboleto` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `nosso_numero` varchar(20) NOT NULL,
  `linha_digitavel` varchar(100) DEFAULT NULL,
  `vencimento` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `url_boleto` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblbooking`
--

CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL,
  `BookingNumber` bigint(12) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `VehicleId` int(11) DEFAULT NULL,
  `FromDate` varchar(20) DEFAULT NULL,
  `ToDate` varchar(20) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `InsuranceIncluded` tinyint(1) NOT NULL DEFAULT 0,
  `TotalPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discountValue` decimal(10,2) DEFAULT 0.00,
  `insuranceValue` decimal(10,2) DEFAULT 0.00,
  `boleto_gerado` tinyint(1) NOT NULL DEFAULT 0,
  `boleto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblbooking`
--

INSERT INTO `tblbooking` (`id`, `BookingNumber`, `userEmail`, `VehicleId`, `FromDate`, `ToDate`, `message`, `Status`, `PostingDate`, `LastUpdationDate`, `InsuranceIncluded`, `TotalPrice`, `discountValue`, `insuranceValue`, `boleto_gerado`, `boleto_url`) VALUES
(179, NULL, 'teste@gmail.com', 2, '2025-05-04', '2025-05-06', 'teste 1', 1, '2025-05-05 00:57:04', '2025-05-05 00:59:16', 1, 3450.00, 0.00, 450.00, 0, NULL),
(180, NULL, 'teste@gmail.com', 3, '2222-02-22', '2222-02-22', 'teste 2', 1, '2025-05-05 00:57:39', '2025-05-05 00:59:48', 0, 1000.00, 0.00, 0.00, 0, NULL),
(181, NULL, 'teste@gmail.com', 4, '2025-05-10', '2025-05-31', 'teste 3', 1, '2025-05-05 00:58:14', '2025-05-05 00:59:55', 0, 17600.00, 0.00, 0.00, 0, NULL),
(182, NULL, 'teste@gmail.com', 5, '2025-06-04', '2025-06-05', 'teste 5', 1, '2025-05-05 00:58:54', '2025-05-05 01:00:18', 1, 4250.00, 50.00, 300.00, 0, NULL),
(183, NULL, 'teste@gmail.com', 9, '2025-05-31', '2025-06-03', 'teste 5', 0, '2025-05-05 01:00:39', NULL, 0, 800.00, 0.00, 0.00, 0, NULL),
(184, NULL, 'teste@gmail.com', 6, '8888-08-08', '8888-08-08', 'teteetete', 0, '2025-05-06 09:58:16', NULL, 0, 400.00, 0.00, 0.00, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblbrands`
--

CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblbrands`
--

INSERT INTO `tblbrands` (`id`, `BrandName`, `CreationDate`, `UpdationDate`) VALUES
(2, 'BMW', '2017-06-18 16:24:50', NULL),
(3, 'Audi', '2017-06-18 16:25:03', NULL),
(4, 'Nissan', '2017-06-18 16:25:13', NULL),
(5, 'Toyota', '2017-06-18 16:25:24', NULL),
(8, 'Volkswagen', '2025-04-01 00:13:22', NULL),
(9, 'Fiat', '2025-04-01 13:33:16', NULL),
(10, 'Chevrolet', '2025-05-04 21:51:12', NULL),
(11, 'Porsche', '2025-05-04 21:59:51', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblcontactusinfo`
--

CREATE TABLE `tblcontactusinfo` (
  `id` int(11) NOT NULL,
  `Address` tinytext DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblcontactusinfo`
--

INSERT INTO `tblcontactusinfo` (`id`, `Address`, `EmailId`, `ContactNo`) VALUES
(1, 'R. Oswaldo Cruz, 277 - Boqueirão, Santos', 'contato@drivego.com', '1334567890');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblcontactusquery`
--

CREATE TABLE `tblcontactusquery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `ContactNumber` char(11) DEFAULT NULL,
  `Message` longtext DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblcontactusquery`
--

INSERT INTO `tblcontactusquery` (`id`, `name`, `EmailId`, `ContactNumber`, `Message`, `PostingDate`, `status`) VALUES
(2, 'tester', 'teste@gmail.com', '11111111', 'teste fale conosco', '2025-03-27 06:04:43', 1),
(3, 'tester', 'teste2@gmail.com', '2222222', 'teste 2', '2025-03-27 23:05:54', NULL),
(4, 'TESTER 2', 'teste21@gmail.com', '1111111', 'TESTE AULA', '2025-03-27 23:20:01', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblfidelidade`
--

CREATE TABLE `tblfidelidade` (
  `id` int(11) NOT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `totalReservas` int(11) DEFAULT 0,
  `pontosAcumulados` int(11) DEFAULT 0,
  `ultimoBeneficio` varchar(50) DEFAULT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblpages`
--

INSERT INTO `tblpages` (`id`, `PageName`, `type`, `detail`) VALUES
(1, 'Terms and Conditions', 'terms', '<P align=justify><FONT size=2><STRONG><FONT color=#990000>(1) ACCEPTANCE OF TERMS</FONT><BR><BR></STRONG>Welcome to Yahoo! India. 1Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: <A href=\"http://in.docs.yahoo.com/info/terms/\">http://in.docs.yahoo.com/info/terms/</A>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>'),
(2, 'Privacy Policy', 'privacy', '<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</span>'),
(3, 'Sobre nós', 'aboutus', '<p style=\"color: rgb(51, 51, 51); font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 25px;\">\r\n  Somos uma plataforma criada para facilitar a busca pelo carro ideal. Acreditamos que esse processo deve ser simples, transparente e confiável. Por isso, reunimos em um só lugar os melhores veículos disponíveis, com filtros inteligentes que permitem comparar modelos, preços, quilometragens, anos e muito mais, de forma rápida e personalizada. Nosso objetivo é oferecer uma experiência prática e eficiente, ajudando cada pessoa a encontrar o carro que melhor atende às suas necessidades e ao seu estilo de vida. Trabalhamos com seriedade e compromisso, prezando sempre pela clareza das informações, pela qualidade dos anúncios e pelo respeito ao tempo do usuário. Com tecnologia, dedicação e paixão pelo que fazemos, queremos ser o seu ponto de partida na jornada de compra do seu próximo veículo.\r\n</p>\r\n'),
(11, 'FAQs', 'faqs', '																														<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">EM DESENVOLVIMENTO</span>');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblsubscribers`
--

CREATE TABLE `tblsubscribers` (
  `id` int(11) NOT NULL,
  `SubscriberEmail` varchar(120) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblsubscribers`
--

INSERT INTO `tblsubscribers` (`id`, `SubscriberEmail`, `PostingDate`) VALUES
(6, 'teste@gmail.com', '2025-03-27 06:47:15'),
(7, 'teste2@gmail.com', '2025-03-27 23:03:32'),
(8, 'teste5@gmail.com', '2025-04-25 00:07:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbltestimonial`
--

CREATE TABLE `tbltestimonial` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tbltestimonial`
--

INSERT INTO `tbltestimonial` (`id`, `UserEmail`, `Testimonial`, `PostingDate`, `status`) VALUES
(2, 'teste@gmail.com', 'Teste de avaliação de serviço', '2025-03-27 06:06:04', 1),
(3, 'teste@gmail.com', 'teste 2', '2025-03-27 23:02:21', 1),
(4, 'teste@gmail.com', 'TESTE AVIALAÇAO ', '2025-03-27 23:16:42', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `CPF` varchar(14) DEFAULT NULL,
  `CNPJ` varchar(18) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  UNIQUE KEY `userEmail` (`EmailId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `EmailId`, `Password`, `ContactNo`, `dob`, `Address`, `City`, `Country`, `RegDate`, `UpdationDate`, `CPF`, `CNPJ`, `State`) VALUES
(1, 'Test', 'test@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '6465465465', '', 'L-890, Gaur City Ghaziabad', 'Ghaziabad', 'India', '2020-07-07 14:00:49', '2020-07-12 05:44:29', NULL, NULL, NULL),
(2, 'lucas', 'lucas.henriques7@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '12345', NULL, NULL, NULL, NULL, '2025-03-17 22:09:11', NULL, NULL, NULL, NULL),
(3, 'araujo', 'araujo@hotmail.clm', '827ccb0eea8a706c4c34a16891f84e7b', '111111', NULL, NULL, NULL, NULL, '2025-03-25 14:21:43', NULL, NULL, NULL, NULL),
(4, 'tester', 'teste@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '111111', '03/05/2025', 'R. Oswaldo Cruz, 277 - Boqueirão, Santos - SP, 11045-907\r\n', 'Santos', 'Brasil', '2025-03-25 21:01:50', '2025-05-04 02:18:10', '338.947.130-89', '', 'São Paulo'),
(5, 'rafa', 'rafa@gmail.com', '4fb122f0c090793957c648b5567815a3', '1316519819', NULL, NULL, NULL, NULL, '2025-03-31 23:11:41', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblvehicles`
--

CREATE TABLE `tblvehicles` (
  `id` int(11) NOT NULL,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `VehiclesOverview` longtext DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `ModelYear` int(6) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `Vimage4` varchar(120) DEFAULT NULL,
  `Vimage5` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `AntiLockBrakingSystem` int(11) DEFAULT NULL,
  `BrakeAssist` int(11) DEFAULT NULL,
  `PowerSteering` int(11) DEFAULT NULL,
  `DriverAirbag` int(11) DEFAULT NULL,
  `PassengerAirbag` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `CrashSensor` int(11) DEFAULT NULL,
  `LeatherSeats` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblvehicles`
--

INSERT INTO `tblvehicles` (`id`, `VehiclesTitle`, `VehiclesBrand`, `VehiclesOverview`, `PricePerDay`, `FuelType`, `ModelYear`, `SeatingCapacity`, `Vimage1`, `Vimage2`, `Vimage3`, `Vimage4`, `Vimage5`, `AirConditioner`, `PowerDoorLocks`, `AntiLockBrakingSystem`, `BrakeAssist`, `PowerSteering`, `DriverAirbag`, `PassengerAirbag`, `PowerWindows`, `CDPlayer`, `CentralLocking`, `CrashSensor`, `LeatherSeats`, `RegDate`, `UpdationDate`) VALUES
(2, ' 5 Series', 2, 'A BMW apresentou ao mercado brasileiro o i5 M60, a versão 100% elétrica da nova geração da Série 5. Com um visual sofisticado e tecnologia de ponta, o modelo se destaca pela performance impressionante: são 601 cv de potência, com aceleração de 0 a 100 km/h em apenas 3,8 segundos. A autonomia chega a até 391 km com uma carga completa, tornando-o ideal tanto para uso urbano quanto em viagens. O BMW i5 M60 chega ao país com preço inicial de R$ 759.950 e representa o compromisso da marca com  a inovação no segmento premium.\r\n\r\n', 1000, 'Gasolina', 2024, 5, 'serie frente.jpg', 'serie lateral.jpg', 'serie interior.jpg', 'seire interior  2.jpg', 'serie traseira.jpg', 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 1, 1, '2020-07-07 07:12:02', '2025-05-04 23:43:18'),
(3, 'Q8', 3, 'O novo Audi Q8 já está disponível no Brasil, com visual renovado, mais tecnologia e desempenho de sobra. A versão Performance Black chega por R$ 774.990, equipada com motor 3.0 V6 turbo de 340 cv e sistema híbrido leve de 48V, capaz de acelerar de 0 a 100 km/h em apenas 5,6 segundos. O design imponente traz grade octogonal, lanternas OLED com quatro assinaturas luminosas e rodas de até 22 polegadas.\r\n\r\nPor dentro, o SUV oferece acabamento sofisticado, bancos esportivos em couro Valcona e três telas digitais, incluindo o Audi Virtual Cockpit. Entre os itens de série estão suspensão pneumática adaptativa, câmera 360°, assistente de estacionamento e piloto automático adaptativo. O modelo ainda permite incluir opcionais como faróis Matrix LED com laser, visão noturna e retrovisores em fibra de carbono.', 1000, 'Gasolina', 2017, 5, 'Q8 frente.jpg', 'Q8 interior.jpg', 'Q8 rodas.jpg', 'Q8 traseira.jpg', 'Q8 traseira 2.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2020-07-07 07:19:21', '2025-05-04 23:44:40'),
(4, 'Kicks', 4, 'O novo Nissan Kicks chega ao Brasil entre abril e junho de 2025, com visual mais robusto, interior espaçoso e tecnologias atualizadas. A nova geração deve vir equipada com motor 1.0 turboflex de até 125 cv e câmbio automatizado de dupla embreagem. Entre os destaques, estão a central multimídia com Apple CarPlay e Android Auto sem fio. Enquanto isso, a Nissan já oferece o Kicks Play 2025 em versões com motor 1.6 aspirado e câmbio CVT, focadas em custo-benefício.\r\n\r\n', 800, 'Gasolina', 2020, 5, 'kicks frente.jpg', 'kicks interior.jpg', 'kicks lateral.jpg', 'kicks bageiro.jpg', '', 1, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-07-07 07:25:28', '2025-05-04 23:45:08'),
(5, 'Camaro', 10, 'O Chevrolet Camaro 2017 representa a sexta geração do icônico muscle car, oferecendo desempenho impressionante e design agressivo. No Brasil, a versão SS é equipada com um motor V8 6.2 litros que entrega 461 cv de potência a 6.000 rpm e torque de 62,9 kgfm a 4.400 rpm . Com transmissão automática de 8 marchas e tração traseira, o Camaro SS acelera de 0 a 100 km/h em aproximadamente 4 segundos e atinge uma velocidade máxima de 250 km/h \r\n', 2000, 'Gasolina', 2019, 2, 'camaro frente.jpg', 'camaro lateral.jpg', 'camaro interior.jpg', 'camaro motor.jpg', 'camaro traseira.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2020-07-07 07:34:17', '2025-05-04 23:31:08'),
(6, 'Versa', 4, 'O Nissan Versa 2020, também conhecido como Versa em alguns mercados, chegou com design renovado, mais moderno e elegante. Equipado com motor 1.6 de 122 cv e câmbio manual ou automático CVT, o modelo entrega bom desempenho aliado à economia de combustível. O interior foi atualizado com central multimídia, câmera de ré, chave presencial e controles de estabilidade e tração, tornando o sedã uma opção acessível, segura e bem equipada no segmento compacto.\r\n\r\n', 400, 'Álcool', 2020, 5, 'versa frente.jpg', 'versa lateral.jpg', 'versa interior.jpg', 'versa motor.jpg', 'versa traseira.jpg', 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2020-07-07 09:12:49', '2025-05-04 22:58:38'),
(7, 'Hilux', 5, 'A Toyota Hilux é uma das picapes médias mais confiáveis e populares do Brasil, conhecida por sua robustez, durabilidade e alto valor de revenda. Equipada com motor 2.8 turbodiesel de até 204 cv e câmbio automático de 6 marchas, a Hilux oferece excelente desempenho tanto na cidade quanto no off-road, com tração 4x4 e suspensão reforçada. As versões mais completas trazem central multimídia com Android Auto e Apple CarPlay, assistente de descida, controles de estabilidade e tração, além de pacote de segurança ativa Toyota Safety Sense nas configurações topo de linha.', 800, 'Gasolina', 2020, 5, '2015_Toyota_Fortuner_(New_Zealand).jpg', 'toyota-fortuner-legender-rear-quarters-6e57.jpg', 'zw-toyota-fortuner-2020-2.jpg', 'download (1).jpg', '', 1, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, '2020-07-07 09:17:46', '2025-05-04 22:12:00'),
(9, 'Corolla', 5, 'O Toyota Corolla 2024 chega com melhorias no design, tecnologia e segurança, mantendo-se como líder entre os sedãs médios. As versões trazem motor 2.0 flex de até 175 cv ou conjunto híbrido 1.8 flex de 122 cv, combinando desempenho e eficiência. Entre as novidades estão o painel digital (7\" ou 12,3\", dependendo da versão), saídas de ar-condicionado e USB-C para os passageiros traseiros, além de teto solar e rodas escurecidas na versão GR-Sport. O modelo também aprimora os sistemas de segurança, como o alerta de pré-colisão, reforçando seu destaque no mercado.', 200, 'Gasolina', 2024, 5, 'corolla frente 1.jpg', 'corolla frente 2.jpg', 'corolla interior.jpg', 'corolla traseira.jpg', 'corolla frente 3jpg.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2025-04-01 00:05:19', '2025-05-04 23:45:19'),
(11, 'Gol', 8, 'O Volkswagen Gol 2019 manteve seu posto como um dos carros mais populares do Brasil, oferecendo praticidade, baixo custo de manutenção e bom desempenho urbano. Nessa versão, o modelo passou a contar com câmbio automático de 6 marchas na motorização 1.6 MSI de 120 cv, além da opção manual. O visual simples e funcional é combinado a um interior com itens como direção hidráulica, ar-condicionado, vidros elétricos e sistema de som com Bluetooth. É uma opção econômica e confiável para o uso diário.\r\n\r\n', 250, 'Gasolina', 2019, 5, 'gol frente.jpg', 'gol interior.jpg', 'gol traseira 2.jpg', 'gol traseira.jpg', '', 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-01 13:06:51', '2025-05-04 21:21:38'),
(12, 'Jetta', 8, 'O Volkswagen Jetta 2019 marcou uma nova geração do sedã médio, com visual mais moderno, maior espaço interno e tecnologias atualizadas. Equipado com motor 1.4 TSI turbo de 150 cv e câmbio automático de 6 marchas, o modelo entrega bom desempenho com eficiência. Destaque para o acabamento refinado, central multimídia com espelhamento de smartphone, painel digital Active Info Display (nas versões superiores) e pacote completo de segurança com controles de tração e estabilidade, além de seis airbags. O Jetta 2019 reforça a proposta de elegância e desempenho no segmento.', 250, 'Gasolina', 2019, 5, 'jetta frente.jpg', 'jetta lado.jpg', 'jetta interior.jpg', 'jetta interior 2.jpg', 'jetta traseira.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, '2025-04-01 13:50:35', '2025-05-04 21:12:32'),
(13, 'Voyage', 8, 'O Voyage 2015 é a escolha ideal para quem busca um sedã compacto com excelente custo-benefício. Com um design moderno, ótimo espaço interno e porta-malas amplo, ele é perfeito tanto para viagens quanto para o dia a dia na cidade.', 200, 'Álcool', 2015, 5, '1.jpg', '2.jpg', '3.jpg', 'tras.jpg', '', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, NULL, NULL, '2025-04-21 01:54:24', '2025-04-24 16:11:04'),
(14, 'March', 4, 'O Nissan March 2020 é a opção perfeita para quem busca praticidade no dia a dia sem abrir mão de conforto e economia. Com design moderno e tamanho compacto, ele é ideal para circular com facilidade em centros urbanos e encontrar vagas com mais tranquilidade.\r\n\r\nEquipado com motor 1.0 ou 1.6 (dependendo da versão), direção elétrica, ar-condicionado, vidros e travas elétricas, o March oferece dirigibilidade leve, baixo consumo de combustível e excelente custo-benefício.', 150, 'Gasolina', 2020, 5, 'M1.jpg', 'M2.jpg', 'M3.jpg', 'M4.jpg', '', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-04-21 02:03:09', '2025-04-24 16:21:54'),
(16, 'Mobi', 9, 'O Fiat Mobi é a escolha perfeita para quem busca um carro econômico, compacto e cheio de estilo. Ideal para dirigir na cidade, fazer viagens curtas ou até mesmo para o seu deslocamento diário, o Mobi combina baixo consumo de combustível, manutenção acessível e um design moderno.', 200, 'Gasolina', 2018, 5, 'mobi frente.jpg', 'mobi frente 2.jpg', 'mobi interior 2.jpg', 'mobi interior.jpg', 'mobi traseira.jpg', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-01 05:30:13', '2025-05-04 21:40:53'),
(19, 'Toro', 9, 'A Fiat Toro é a escolha perfeita para quem busca espaço, conforto e desempenho em um único veículo. Combinando o design robusto de uma picape com o conforto e tecnologia de um SUV premium, a Toro é ideal para viagens em família, trabalho ou aventuras off-road.', 500, 'Diesel', 2024, 5, 'fiat_toro_2025_1_27012025_82245_1280_960.jpg', 'fiat_toro_2024_1_15082023_75530_1280_960.jpg', 'fiat_toro_2025_1_27012025_82246_1280_960.jpg', 'fiat_toro_2025_1_27012025_82247_1280_960.jpg', 'fiat_toro_2025_1_27012025_82249_1280_960.jpg', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-01 05:41:04', NULL),
(20, 'Amarok', 8, 'A Volkswagen Amarok é a escolha ideal para quem busca alto desempenho, capacidade off-road e conforto premium. Com seu design imponente, tecnologia avançada e motores potentes, ela é perfeita para trabalho pesado, aventuras ou viagens familiares com estilo.', 550, 'Diesel', 2022, 5, 'volkswagen_amarok_2025_1_15082024_79960_1280_960.jpg', 'volkswagen_amarok_2025_1_15082024_79961_1280_960.jpg', 'volkswagen_amarok_2025_1_15082024_79962_1280_960.jpg', 'volkswagen_amarok_2023_11_07072022_71783_1280_960.jpg', '', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-01 05:47:05', NULL),
(21, 'Nivus', 8, 'O Volkswagen Nivus é um SUV coupé que combina estilo arrojado, tecnologia avançada e desempenho eficiente, perfeito para quem busca sofisticação e praticidade no dia a dia ou em viagens. Com seu design dinâmico e interior espaçoso, o Nivus oferece uma experiência de condução premium, garantindo conforto para motorista e passageiros.', 300, 'Gasolina', 2022, 5, 'volkswagen_nivus_2025_1_14022025_82548_1280_960.jpg', 'volkswagen_nivus_2025_1_14022025_82547_1280_960.jpg', 'volkswagen_nivus_2022_1_28082021_50104_1280_960.jpg', 'volkswagen_nivus_2022_1_28082021_50108_1280_960.jpg', 'volkswagen_nivus_2022_7_29072021_49802_1280_960.jpg', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-02 02:02:09', NULL),
(22, 'Passat cc', 8, 'O Volkswagen Passat CC é um sedan de luxo que une sofisticação, tecnologia e alto desempenho, perfeito para quem busca um carro exclusivo para viagens executivas, passeios especiais ou simplesmente para desfrutar de um condução refinada. Com seu design coupé de quatro portas, interior premium e tecnologia avançada, o Passat CC oferece uma experiência de direção inigualável.', 570, 'Gasolina', 2018, 5, 'volkswagen_CC_2015_1_1112016_325_1280_960.jpg', 'volkswagen_CC_2015_1_1112016_326_1280_960.jpg', 'volkswagen_CC_2015_1_1112016_327_1280_960.jpg', 'volkswagen_CC_2015_1_1112016_328_1280_960.jpg', '', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-02 02:07:47', NULL),
(23, 'Cronos', 9, 'O Fiat Cronos é um sedã compacto que combina estilo contemporâneo, interior espaçoso e tecnologia acessível, perfeito para quem busca um carro versátil para o dia a dia, viagens em família ou deslocamentos urbanos. Com linhas arrojadas e um excelente custo-benefício, o Cronos oferece conforto e praticidade sem abrir mão do bom desempenho.', 350, 'Gasolina', 2020, 5, 'fiat_cronos_2023_1_05122022_72695_1280_960.jpg', 'fiat_cronos_2023_1_05122022_72696_1280_960.jpg', 'fiat_cronos_2023_1_05122022_72697_1280_960.jpg', 'fiat_cronos_2022_1_02072021_48554_1280_960.jpg', 'fiat_cronos_2022_1_02072021_48555_1280_960.jpg', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-02 02:15:16', NULL),
(24, 'Onix Turbo', 10, 'O Chevrolet Onix 2021 manteve sua posição como um dos carros mais vendidos do Brasil, oferecendo uma combinação de eficiência, tecnologia e segurança. Disponível em versões com motor 1.0 aspirado de até 82 cv e 1.0 turbo de 116 cv, o modelo oferece opções de câmbio manual ou automático de seis marchas. Entre os destaques estão a central multimídia MyLink com tela de 8\" compatível com Android Auto e Apple CarPlay, seis airbags, controle de estabilidade e tração, além de assistente de partida em rampas. A versão Premier adiciona itens como rodas de liga leve de 16\", faróis de LED, partida sem chave e Wi-Fi integrado. Com um design moderno e bom pacote de equipamentos, o Onix 2021 se destaca no segmento de hatches compactos.', 250, 'Álcool', 2021, 5, 'onix frente.jpg', 'onix lado.jpg', 'onix painel.jpg', 'onix painel 2.jpg', 'onix traseira.jpg', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-04 21:57:34', '2025-05-04 21:58:29'),
(25, '718 Cayman', 11, 'O Porsche 718 é um esportivo de motor central que combina design elegante, dirigibilidade precisa e alto desempenho. Disponível nas versões Boxster (conversível) e Cayman (cupê), ele oferece motores turbo de quatro cilindros — com até 300 cv — ou seis cilindros nas versões mais potentes, como o GTS 4.0 e GT4, que chegam a 420 cv. O modelo se destaca pelo equilíbrio dinâmico, tração traseira, câmbio manual ou PDK (automático de dupla embreagem), além de acabamento refinado e tecnologias de conectividade e segurança típicas da marca.', 2000, 'Gasolina', 2018, 2, 'cayman frente.jpg', 'cayman interior.jpg', 'cayman traseira.jpg', 'cayman traseira 2.jpg', '', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, '2025-05-04 22:04:18', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblboleto`
--
ALTER TABLE `tblboleto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_nosso` (`booking_id`,`nosso_numero`);

--
-- Índices de tabela `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblbrands`
--
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblfidelidade`
--
ALTER TABLE `tblfidelidade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userEmail` (`userEmail`);

--
-- Índices de tabela `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`);

--
-- Índices de tabela `tblvehicles`
--
ALTER TABLE `tblvehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tblboleto`
--
ALTER TABLE `tblboleto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de tabela `tblbrands`
--
ALTER TABLE `tblbrands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tblfidelidade`
--
ALTER TABLE `tblfidelidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tblvehicles`
--
ALTER TABLE `tblvehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tblboleto`
--
ALTER TABLE `tblboleto`
  ADD CONSTRAINT `tblboleto_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `tblbooking` (`id`);

--
-- Restrições para tabelas `tblfidelidade`
--
ALTER TABLE `tblfidelidade`
  ADD CONSTRAINT `tblfidelidade_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `tblusers` (`EmailId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
