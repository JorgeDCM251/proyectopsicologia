-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2024 a las 17:41:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectopsicologia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario`
--

CREATE TABLE `cuestionario` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `instrucciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuestionario`
--

INSERT INTO `cuestionario` (`id`, `titulo`, `descripcion`, `instrucciones`) VALUES
(13, 'Caracterización del paciente', 'Este cuestionario tiene como objetivo la caracterización inicial del paciente que será sometido a pruebas psicológicas. A través de las preguntas, se recopilarán datos importantes sobre la persona, como su historial personal, familiar, académico y de salud, los cuales serán esenciales para un análisis detallado y la mejora de las estrategias terapéuticas a aplicar. La información proporcionada será tratada con total confidencialidad y se utilizará únicamente para fines clínicos.', 'Para completar el cuestionario, es esencial responder todas las preguntas, tanto de selección múltiple como abiertas, con total sinceridad, ya que esto permitirá un análisis efectivo y una mejor atención psicológica. Si tiene dudas sobre alguna pregunta, no dude en consultar al psicólogo encargado, quien está disponible para ayudarle. Recuerde que toda la información proporcionada será tratada de manera confidencial y solo se utilizará con fines clínicos. Tómese su tiempo para reflexionar sobre sus respuestas.'),
(14, 'Cuestionario de experiencias adversas en la niñes ', 'Este cuestionario tiene como objetivo explorar las experiencias vividas durante la niñez, enfocándose en identificar posibles situaciones adversas que el individuo pudo haber experimentado. A través de preguntas cuidadosamente diseñadas, se busca obtener una visión integral del entorno familiar, social y emocional en la etapa infantil, con el fin de comprender mejor el impacto que estas experiencias pudieron tener en el desarrollo posterior. La información recopilada será tratada con total confidencialidad y utilizada únicamente para fines clínicos y de mejora en el proceso terapéutico.', 'Por favor, responda las preguntas de este cuestionario con total sinceridad, enfocándose únicamente en experiencias vividas ANTES DE LOS 18 AÑOS. \r\nEsto nos ayudará a comprender mejor su niñez y adolescencia. Si tiene alguna duda, puede consultar al profesional encargado. Recuerde que toda la información será tratada de manera confidencial y solo se utilizará con fines clínicos.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(15, 'Escala de Autocuidado', 'La escala de autocuidado se refiere a formas en las que habitualmente nos tratamos a nosotros mismos. Esto abarca distintas áreas. Deberá leer cada frase, y ver hasta qué punto está de acuerdo con ella, rodeando con un círculo el número correspondiente. Conteste en base a la manera en la que funciona usted de modo habitual, no a una etapa en particular. Por favor, no deje ninguna pregunta sin responder. Si tiene dudas, pregunte al evaluador. ', 'Por favor, en las preguntas de selección múltiple, elija un número del 1 al 7 que mejor refleje su opinión. Use la siguiente escala: [1] es totalmente en desacuerdo, [2] bastante en desacuerdo, [3] algo en desacuerdo, [4] ni de acuerdo ni en desacuerdo, [5] algo de acuerdo, [6] bastante de acuerdo, y [7] totalmente de acuerdo. Seleccione la opción que mejor describa su respuesta para cada afirmación.'),
(16, 'Escala de experiencias disociativas ', 'Este formulario tiene como objetivo evaluar la frecuencia y naturaleza de las experiencias disociativas que una persona puede haber experimentado. A través de una serie de preguntas, se exploran diferentes tipos de desconexiones emocionales, cognitivas o sensoriales, que pueden haber ocurrido en diversas situaciones de la vida cotidiana. La información proporcionada permitirá un análisis detallado para identificar patrones y determinar el impacto de dichas experiencias en el bienestar psicológico. Toda la información será tratada con confidencialidad y utilizada exclusivamente para fines clínicos.', 'seleccione la opción que mejor describa su experiencia en cada pregunta de selección múltiple. Es importante responder con sinceridad, ya que esto permitirá un análisis más preciso. Si tiene alguna duda, puede consultar al profesional encargado. Toda la información será tratada con estricta confidencialidad y se utilizará únicamente con fines clínicos.'),
(17, 'ESCALA DE ANSIEDAD Y DEPRESIÓN HOSPITALARIA', 'Este cuestionario ha sido diseñado para saber cómo se siente usted. Lea cada frase y marque la respuesta que más se ajusta, mire cómo se ha sentido usted durante la ultima semana.', 'Lo más seguro es que si responde rápido sus respuestas se ajustarán mucho más a cómo se ha sentido durante la semana pasada. Por favor responda de manera honesta y sin sobre pensar las respuestas.'),
(18, 'PCL- 5', 'Este cuestionario pregunta acerca de los problemas que usted pudo haber tenido después de una experiencia muy estresante que implica la muerte real o amenaza, lesiones graves o violencia sexual. Podría ser algo que le haya pasado directamente, algo que fue testigo, o algo que le haya pasado a un familiar cercano o un amigo cercano. Algunos ejemplos son un grave accidente, fuego, desastre como un huracán, tornado o terremoto, ataque o abuso físico o sexual; guerra; homicidio; o el suicidio. ', 'Primero por favor responda a algunas preguntas acerca de su peor caso, que para este cuestionario significa el caso que en la actualidad le molesta más. Esto podría ser uno de los ejemplos anteriores o alguna otra experiencia estresante. También podría ser un solo evento (por ejemplo, un accidente de coche) o múltiples eventos similares (por ejemplo, múltiples eventos estresantes en zona de guerra o abuso sexual repetido).');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionarios_resueltos`
--

CREATE TABLE `cuestionarios_resueltos` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_cuestionario` int(11) NOT NULL,
  `fecha_resolucion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `observacion` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` varchar(255) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `op_pregunta1` varchar(255) DEFAULT NULL,
  `op_pregunta2` varchar(255) DEFAULT NULL,
  `op_pregunta3` varchar(255) DEFAULT NULL,
  `op_pregunta4` varchar(255) DEFAULT NULL,
  `op_pregunta5` varchar(255) DEFAULT NULL,
  `op_pregunta6` varchar(255) DEFAULT NULL,
  `op_pregunta7` varchar(255) DEFAULT NULL,
  `tipo_pregunta` varchar(20) DEFAULT NULL,
  `op_pregunta8` varchar(255) DEFAULT NULL,
  `op_pregunta9` varchar(255) DEFAULT NULL,
  `op_pregunta10` varchar(255) DEFAULT NULL,
  `op_pregunta11` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `pregunta`, `op_pregunta1`, `op_pregunta2`, `op_pregunta3`, `op_pregunta4`, `op_pregunta5`, `op_pregunta6`, `op_pregunta7`, `tipo_pregunta`, `op_pregunta8`, `op_pregunta9`, `op_pregunta10`, `op_pregunta11`) VALUES
('ACE001', '¿Alguno de sus padres u otro adulto en su casa, con frecuencia  le insulto, le ofendió, lo derribo, le dijo groserías, o lo humillo, o Algún adulto actuó de tal manera que le hizo sentir miedo a ser físicamente lastimado?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE002', '¿Alguno de sus padres u otro adulto en su casa, con frecuencia, lo empujo, lo agarro, lo abofeteo, le lanzo algún objeto, o Alguna vez le golpeo tan duro que le quedaron marcas o fue herido?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE003', '¿Algún adulto o persona, al menos 5 años mayor que usted, alguna vez: Le toco, o lo frotó, o lo hizo tocar su cuerpo de manera sexual o trató de tener, o de hecho tuvo, sexo oral, anal, o vaginal con usted?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE004', 'Con frecuencia sintió que... ¿Nadie en su familia lo amaba o pensó que usted no era importante o especial? o ¿En su familia no se cuidaron mutuamente, no se sintieron cercanos, o no se apoyaron?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE005', 'Con frecuencia sintió que… ¿No tuvo suficiente comida, tuvo que usar ropa sucia, y no tuvo a nadie que lo protegiera? o ¿Sus padres estaban demasiado ebrios o drogados para cuidarle o llevarle con el doctor cuando lo necesitó?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE006', '¿Alguna vez sus padres se separaron o divorciaron?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE007', 'A su madre o madrastra: ¿Con frecuencia la empujaron, agarraron, abofetearon, o le lanzaron algo? o ¿A veces o con frecuencia la patearon, mordieron, pegaron con el puño cerrado, o le pegaron con algo duro? o ¿Alguna vez le pegaron repetidamente una y otr', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE008', '¿Vive usted con alguien que tenga un problema con la bebida, o sea un alcohólico, o drogadicto?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE009', '¿Algún miembro de la familia tiene depresión o está mentalmente enfermo o algún miembro de la familia intentó suicidarse?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('ACE010', '¿Algún miembro de la familia ha ido a prisión?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT001', 'Nombre completo', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT002', 'Documento de identidad:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT003', 'Fecha de hoy:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT004', 'Fecha del trauma:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT005', 'Tiempo desde el trauma:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT006', 'Seleccione su sexo: ', 'Masculino', 'Femenino', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT007', 'Lugar de nacimiento:  ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT008', 'Fecha de nacimiento:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT009', 'Edad:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT010', '¿Reside actualmente en Bogotá?     ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT011', '¿ Vive solo ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT012', '¿ Vive con miembros de la familia ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT013', 'Quienes son:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT014', '¿ Vive con amigos ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT015', '¿ Actualmente esta en una vivienda compartida ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT016', '¿ Actualmente esta en una residencia temporal ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT017', 'Teléfono de contacto:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT018', 'Correo electrónico: ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT019', '¿ Usted esta soltero ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT020', '¿Estas usted en una relación de unión libre?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT021', '¿Ha contraído matrimonio nuevamente?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT022', '¿Podría indicarme cuál es el grado académico más alto que ha obtenido?', 'Primaria', 'Secundaria', 'Técnica', 'Tecnológica', 'Profesional', 'Posgrado', 'Doctorado', 'multiple', '', '', '', ''),
('CRT023', '¿ Esta usted empleado ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT024', '¿ Usted trabaja independiente ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT025', '¿ Ha presentado o presenta alguna enfermedad física ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT026', 'Cual: ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT027', '¿ Requiere de medicación ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT028', 'Especifique cual medicación :', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT029', 'Especifique fecha de inicio de toma de la medicación:', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT030', '¿ Ha sufrido lesiones físicas ? ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT031', 'Especifique tipo y gravedad', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT032', 'Nivel de funcionamiento  ( en comparación con lo habitual ), donde 1 es bajo y 4 es alto.', '1', '2', '3', '4', '', '', '', 'multiple', '', '', '', ''),
('CRT033', '¿ Ha presentado alguna enfermedad mental ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT034', '¿ Ha tenido tratamiento psicológico previo ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT035', '¿ Sufre o ha sufrido de epilepsia ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT036', '¿ Tiene algún dolor de ojos?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT037', '¿Algún daño cerebral? ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT038', '¿Problemas cardiacos y neurológicos?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT039', '¿Está en embarazo? (primero consulta médica)', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT040', '¿ Sufre de episodios psicóticos por trauma ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT041', '¿ Sufre esquizofrenia y puede modular el afecto ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT042', '¿ sufre Trastorno Bipolar ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT043', '¿ Tiene trastorno del sueño ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT044', '¿ Tiene trastorno disociativo ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT045', '¿El padre de su familia forma parte de su núcleo familiar ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT046', '¿La Madre de su familia forma parte de su núcleo familiar ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT047', '¿Tiene usted hermanos?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT048', '¿ Cuantos hermanos tiene ?', '1', '2', '3', '4', '5', '6', '7', 'multiple', '8', '9', '10', 'más de 10'),
('CRT049', '¿ Usted qué lugar ocupa en su núcleo familiar ?', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT050', '¿ Usted tiene amistades ocasiónales? ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT051', '¿ Usted tiene amistad con compañeros de trabajo ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT052', '¿ Usted tiene amigos de confianza ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT053', '¿ Usted tiene un confidente ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT054', 'En su historia y/o en el presente ha presentado alguno de estos riesgo de Auto mutilación ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT055', '¿ Ideación o intención suicida u homicida ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT056', '¿ Cual ?', 'Auto mutilación', 'Ideación o intención suicida u homicida', 'Ambas', '', '', '', '', 'multiple', '', '', '', ''),
('CRT057', '¿ Hace cuanto tiempo ?', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT058', '¿ Ha presentado usted Conductas para suicidas; atracones, promiscuidad, alcoholismo, adicción a sustancia, anorexia. etc ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT059', '¿ Cuales ?', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('CRT060', '¿ Tiene conductas que ponen en riesgo a los demás ?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('CRT061', '¿ Cual ?', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('DES001', 'Algunas personas tienen la experiencia de manejar un automóvil y de repente percatarse de que no recuerdan qué ha pasado durante todo o parte del viaje. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES002', 'Algunas personas encuentran que a veces están escuchando a alguien hablar y de repente se percatan que no estaban escuchando parte o todo de lo que se estaba diciendo. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede ', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES003', 'Algunas personas tienen la experiencia de encontrarse a sí mismos en un lugar y no tener idea de cómo llegaron allí. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES004', 'Algunas personas tienen la experiencia de encontrase a sí mismos vestidos con ropas que no recuerdan habérsela puesto. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES005', 'Algunas personas tienen la experiencia de encontrar nuevas cosas entre sus pertenencias que no recuerdan haber comprado. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES006', 'Algunas personas en ocasiones encuentran que son abordados por personas que no conocen quien lo llama por otro nombre o insiste en que se han conocido antes. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES007', 'Algunas personas a veces tienen la experiencia de sentirse como si estuvieran cerca de ellos o viéndose a sí mismo y en realidad se ven a si mismo como si estuvieran mirando a otra persona. Seleccione el número que muestre qué porcentaje ', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES008', 'A algunas personas se les ha dicho que en ocasiones no reconocen amigos o miembros de su familia. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES009', 'lgunas personas encuentran que no tienen recuerdos de algunos eventos importantes de su vida (por ejemplo, una boda o graduación). Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES010', 'Algunas personas tienen la experiencia de haber sido acusados de mentir cuando ellos no creen haber mentido. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES011', 'Algunas personas tienen la experiencia de mirarse en el espejo y no reconocerse a sí mismos. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES012', 'Algunas personas tienen la experiencia de sentir que otras personas, objetos y el mundo alrededor de ellos no es real. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES013', 'Algunas personas tienen la experiencia que sus cuerpos no les pertenecen a ellos. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES014', 'Algunas personas tienen la experiencia de que en ocasiones están recordando un evento pasado tan vívidamente que sienten como si es tuvieran reviviendo ese evento. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede ', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES015', 'Algunas personas tienen la experiencia de no estar seguros de si las cosas que ellos recuerdan sucedieron realmente o si solo lo soñaron. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES016', 'Algunas personas tienen la experiencia de estar en un sitio familiar pero encontrarlo como extraño o desconocido. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES017', 'Algunas personas encuentran que cuando están viendo televisión o una película están tan absortos en la historia que no se dan cuenta de otros eventos que suceden a su alrededor. Seleccione el número que muestre qué porcentaje del tiempo es', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES018', 'Algunas personas encuentran que se involucran tanto en una fantasía que sienten como si realmente les estuviera sucediendo a ellos. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES019', 'Algunas personas encuentran que en ocasiones son capaces de ignorar el dolor. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES020', 'Algunas personas encuentran que en ocasiones están mirando fijamente al espacio, sin pensar en nada, y no se percatan del paso del tiempo. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES021', 'Algunas personas en ocasiones encuentran que cuando están solos hablan en voz alta a sí mismos. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES022', 'Algunas personas encuentran que en una situación ellos pueden actuar tan diferente comparado con otra situación que sienten casi como si fueran dos personas diferentes. Seleccione el número que muestre qué porcentaje del tiempo esto le su', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES023', 'Algunas personas en ocasiones encuentran que en ciertas situaciones son capaces de hacer cosas con tal facilidad y espontaneidad que usualmente serían difíciles para ellos (por ejemplo, deportes, trabajo, situaciones sociales, etc.). ', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES024', 'Algunas personas en ocasiones encuentran que no pueden recordar si han hecho algo o que solo pensaron en hacerlo (por ejemplo, no saber si han enviado una carta o solo haber pensado en enviarla). Seleccione el número que muestre qué porcentaje del tiempo ', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES025', 'Algunas personas encuentran evidencias de haber hecho cosas que no recuerdan haber hecho. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES026', 'Algunas persona encuentran escritos, dibujos o notas entre sus pertenencias que ellos deben haber hecho pero no pueden recordar haberlas hecho. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES027', 'Algunas personas a veces encuentran que escuchan voces dentro de su cabeza que les dice que hagan cosas o comentarios sobre cosas que ellos están haciendo. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('DES028', 'Algunas personas a veces sienten como si estuvieran mirando al mundo a través de una niebla de manera que las personas y objetos parecen alejados o borrosos. Seleccione el número que muestre qué porcentaje del tiempo esto le sucede a UD.', '0%', '10%', '20%', '30%', '40%', '50%', '60%', 'multiple', '70%', '80%', '90%', '100%'),
('EAD001', 'Me siento tenso@ o nervios@.', 'Todos los días', 'Muchas veces', 'A veces', 'Nunca', '', '', '', 'multiple', '', '', '', ''),
('EAD002', 'Todavía disfruto con lo que me ha gustado hacer', 'Como siempre', 'No lo bastante', 'Solo un poco', 'Nada', '', '', '', 'multiple', '', '', '', ''),
('EAD003', 'Tengo una sensación de miedo, como si algo horrible fuera a suceder', 'Definitivamente y es muy fuerte', 'Sí, pero no es muy fuerte', 'Un poco pero no me preocupa', 'Nada', '', '', '', 'multiple', '', '', '', ''),
('EAD004', 'Puedo reírme y ver el lado positivo de las cosas.', 'Al igual que siempre lo hice', 'No tanto ahora', 'Casi nunca', 'Nunca', '', '', '', 'multiple', '', '', '', ''),
('EAD005', 'Tengo la cabeza llena de preocupaciones', 'La mayoría de las veces', 'Con bastante frecuencia', 'A veces, aunque no muy seguido', 'Solo en ocasiones', '', '', '', 'multiple', '', '', '', ''),
('EAD006', 'Me siento alegre', 'Nunca', 'No muy seguido', 'A veces', 'Casi siempre', '', '', '', 'multiple', '', '', '', ''),
('EAD007', 'Puedo estar sentad@ tranquilamente y sentirme relajad@.', 'Siempre', 'Por lo general', 'No muy seguido', 'Nunca', '', '', '', 'multiple', '', '', '', ''),
('EAD008', 'Siento como si yo cada día estuviera más lent@.', 'Por lo general en todo momento', 'Muy seguido', 'A veces', 'Nunca', '', '', '', 'multiple', '', '', '', ''),
('EAD009', 'Tengo una sensación extraña, como de aleteo de mariposas o vacío en el estomago', 'Nunca', 'En ciertas ocasiones ', 'Con bastante frecuencia', 'Muy seguido', '', '', '', 'multiple', '', '', '', ''),
('EAD010', 'He perdido el deseo de estar bien arreglad@ o presentad@.', 'Totalmente', 'No me preocupa como debiera', 'Podría tener un poco más de cuidado', 'Me preocupo al igual que siempre', '', '', '', 'multiple', '', '', '', ''),
('EAD011', 'Me siento inquiet@, como si no pudiera parar de moverme', 'Mucho', 'Bastante', 'No mucho', 'Nada', '', '', '', 'multiple', '', '', '', ''),
('EAD012', 'Me siento con esperanzas respecto al futuro', 'Igual que siempre', 'Menos de lo que acostumbraba', 'Mucho menos de lo que acostumbraba', 'Nada', '', '', '', 'multiple', '', '', '', ''),
('EAD013', 'Presento una sensación de miedo muy intenso de un momento a otro', 'Muy frecuentemente', 'Bastante seguido', 'No muy seguido', 'Nada', '', '', '', 'multiple', '', '', '', ''),
('EAD014', 'Me divierto con un buen libro, la radio, o un programa de televisión', 'Seguido', 'A veces', 'No muy seguido', 'Rara vez', '', '', '', 'multiple', '', '', '', ''),
('EDA001', 'Cuando estoy mal hago cosas que me hacen sentir aún peor', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA002', 'Los elogios me hacen sentir incómodo', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA003', 'No me dejo ayudar', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA004', 'Siento que me tratan injustamente y no sé por qué', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA005', 'No dedico tiempo a actividades agradables o divertidas', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA006', 'No me fío de la gente que me dice cosas positivas sobre mi', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA007', 'Las cosas que hago tienen que ser útiles a otras personas', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA008', 'Me echo siempre la culpa de todo', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA009', 'Nadie me reconoce lo mucho que hago por ellos', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA010', 'Las necesidades de los demás están por delante de las mías', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA011', 'No soy capaz de pedir ayuda', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA012', 'Me comporto de forma autodestructiva', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA013', 'Los demás deberían estar ahí cuando los necesito', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA014', 'Puedo llegar a disculpar cualquier cosa que me hagan', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA015', 'Me creo más fácilmente una crítica que un cumplido', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA016', 'Me critico internamente todo el tiempo', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA017', 'Mis problemas me los guardo para mí', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA018', 'La gente es muy desagradecida', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA019', 'Me cuesta defender mis derechos', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA020', 'Me siento más cómodo ayudando a los demás que a la inversa', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA021', 'No tengo relaciones que me resulten gratificantes', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA022', 'Permito que la gente invada mi espacio personal', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA023', 'Hago cosas que sé que me perjudican', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA024', 'Me molesta que los demás no respondan en seguida a mis necesidades', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA025', 'No hago ejercicio físico', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA026', 'Soy incapaz de decir que no', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA027', 'Neutralizo los cumplidos diciendo \"no es para tanto\" o cosas así', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA028', 'Cuando estoy mal me enfado conmigo mismo por estar así', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA029', 'No puedo pedir lo que necesito', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA030', 'No se disfrutar del tiempo libre', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('EDA031', 'Me alimento mal', '1', '2', '3', '4', '5', '6', '7', 'multiple', '', '', '', ''),
('PCL001', 'Brevemente identifique el peor de los casos (si usted se siente cómodo haciéndolo) ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('PCL002', '¿Hace cuánto tiempo paso? (Realice un estimado si usted no está seguro)', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('PCL003', '¿Hubo muerte real o amenaza, lesiones graves o violencia sexual?', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL004', '¿Cómo lo experimento? ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('PCL005', 'Me pasó a mí directamente ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL006', 'Fui testigo de ello', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL007', 'Supe que le paso a un familiar cercado o un amigo cercano ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL008', 'Yo estaba expuesto en repetidas ocasiones sobre detalles al respecto como parte de mí trabajo (por ejemplo, paramédico, policía, militar, ayuda de primera respuesta) ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL009', 'De otra forma, por favor describa ', '', '', '', '', '', '', '', 'abierta', '', '', '', ''),
('PCL010', 'Si el evento involucra la muerte de un familiar cercano o un amigo cercano ¿fue debido a algún tipo de accidente o violencia, o fue por causas naturales? ', 'Accidente', 'Violencia', 'Causas naturales', '', '', '', '', 'multiple', '', '', '', ''),
('PCL011', 'No aplicable (el evento no involucra la muerte de un familiar o amistad cercana) ', 'SI', 'NO', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL012', 'En segundo lugar, teniendo este evento en mente, lea cada uno de los problemas que aparecen en la página siguiente y luego marque el número a la derecha para indicar cuanto le ha molestado este problema en el último mes.', 'Entiendo', '', '', '', '', '', '', 'multiple', '', '', '', ''),
('PCL013', 'Durante el pasado mes, cuánta molestia ha sentido por. ¿Recuerdos repetitivos, inquietantes o no deseados de la experiencia estresante? ', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL014', '¿Sueños repetitivos e inquietantes de la experiencia estresante?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL015', '¿Repentinamente sintiéndose o actuando como si la experiencia estresante está pasando en realidad? (Como si estuviera en realidad reviviendo la experiencia)', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL016', '¿Sintiendo enojo cuando algo le recuerda esa experiencia estresante?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL017', '¿Tiene fuertes reacciones físicas cuando algo le recuerda esa experiencia estresante? (Por ejemplo, fuertes latidos del corazón, problemas para respirar, sudor)', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL018', ' ¿El evitar recuerdos, pensamientos o sentimientos relacionados con la experiencia estresante?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL019', ' ¿Evitar cosas externas que le recuerden experiencia estresante? (Por ejemplo personas, lugares, conversaciones, actividades, objetos u otras situaciones)', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL020', ' ¿Problemas recordando hechos importantes de la experiencia estresante?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL021', '¿Tener fuertes convicciones negativas de usted mismo, otras personas, o el mundo (por ejemplo si tiene pensamientos como: Soy malo, hay algo seriamente malo conmigo, no puedo confiar en nadie, nuestro mundo es sumamente peligroso)?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL022', '¿Culpa a sí mismo o a alguien por la experiencia estresante o lo que ocurrió después de eso?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL023', '¿Tener fuertes sentimientos negativos como temor, horror, enojo, culpabilidad o vergüenza?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL024', '¿Perdida de interés en actividades que usted disfrutaba?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL025', '¿Al sentirse distante o separado de otras personas?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL026', '¿Dificultad para experimentar sentimientos positivos (por ejemplo, al ser incapaz de sentirse feliz o tener sentimientos de amor para las personas cercanas a usted)?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL027', '¿Comportamiento irritable, arranques de enojo comportamiento agresivo?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL028', '¿Tomar muchos riesgos o hacer cosas que puedan causar daño?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL029', ' ¿Estar en “sobre alerta” o vigilante o en guardia?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL030', '¿Sentir nerviosismo o fácilmente asustado?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL031', '¿Al tener dificultad para concentrarse?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', ''),
('PCL032', '¿Dificultad para dormir o quedarse dormido?', 'No del todo', 'Un Poco', 'Moderado', 'Mucho', 'Extremadamente', '', '', 'multiple', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntascuestionario`
--

CREATE TABLE `preguntascuestionario` (
  `id` int(11) NOT NULL,
  `id_cuestionario` int(11) DEFAULT NULL,
  `id_pregunta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntascuestionario`
--

INSERT INTO `preguntascuestionario` (`id`, `id_cuestionario`, `id_pregunta`) VALUES
(54, 13, 'CRT001'),
(55, 13, 'CRT002'),
(56, 13, 'CRT003'),
(57, 13, 'CRT004'),
(58, 13, 'CRT005'),
(59, 13, 'CRT006'),
(60, 13, 'CRT007'),
(61, 13, 'CRT008'),
(62, 13, 'CRT009'),
(63, 13, 'CRT010'),
(64, 13, 'CRT011'),
(65, 13, 'CRT012'),
(66, 13, 'CRT013'),
(67, 13, 'CRT014'),
(68, 13, 'CRT015'),
(69, 13, 'CRT016'),
(70, 13, 'CRT017'),
(71, 13, 'CRT018'),
(72, 13, 'CRT019'),
(73, 13, 'CRT020'),
(74, 13, 'CRT021'),
(75, 13, 'CRT022'),
(76, 13, 'CRT023'),
(77, 13, 'CRT024'),
(78, 13, 'CRT025'),
(79, 13, 'CRT026'),
(80, 13, 'CRT027'),
(81, 13, 'CRT028'),
(82, 13, 'CRT029'),
(83, 13, 'CRT030'),
(84, 13, 'CRT031'),
(85, 13, 'CRT032'),
(86, 13, 'CRT033'),
(87, 13, 'CRT034'),
(88, 13, 'CRT035'),
(89, 13, 'CRT036'),
(90, 13, 'CRT037'),
(91, 13, 'CRT038'),
(92, 13, 'CRT039'),
(93, 13, 'CRT040'),
(94, 13, 'CRT041'),
(95, 13, 'CRT042'),
(96, 13, 'CRT043'),
(97, 13, 'CRT044'),
(98, 13, 'CRT045'),
(99, 13, 'CRT046'),
(100, 13, 'CRT047'),
(101, 13, 'CRT048'),
(102, 13, 'CRT049'),
(103, 13, 'CRT050'),
(104, 13, 'CRT051'),
(105, 13, 'CRT052'),
(106, 13, 'CRT053'),
(107, 13, 'CRT054'),
(108, 13, 'CRT055'),
(109, 13, 'CRT056'),
(110, 13, 'CRT057'),
(111, 13, 'CRT058'),
(112, 13, 'CRT059'),
(113, 13, 'CRT060'),
(114, 13, 'CRT061'),
(115, 14, 'ACE001'),
(116, 14, 'ACE002'),
(117, 14, 'ACE003'),
(118, 14, 'ACE004'),
(119, 14, 'ACE005'),
(120, 14, 'ACE006'),
(121, 14, 'ACE007'),
(122, 14, 'ACE008'),
(123, 14, 'ACE009'),
(124, 14, 'ACE010'),
(125, 15, 'EDA001'),
(126, 15, 'EDA002'),
(127, 15, 'EDA003'),
(128, 15, 'EDA004'),
(129, 15, 'EDA005'),
(130, 15, 'EDA006'),
(131, 15, 'EDA007'),
(132, 15, 'EDA008'),
(133, 15, 'EDA009'),
(134, 15, 'EDA010'),
(135, 15, 'EDA011'),
(136, 15, 'EDA012'),
(137, 15, 'EDA013'),
(138, 15, 'EDA014'),
(139, 15, 'EDA015'),
(140, 15, 'EDA016'),
(141, 15, 'EDA017'),
(142, 15, 'EDA018'),
(143, 15, 'EDA019'),
(144, 15, 'EDA020'),
(145, 15, 'EDA021'),
(146, 15, 'EDA022'),
(147, 15, 'EDA023'),
(148, 15, 'EDA024'),
(149, 15, 'EDA025'),
(150, 15, 'EDA026'),
(151, 15, 'EDA027'),
(152, 15, 'EDA028'),
(153, 15, 'EDA029'),
(154, 15, 'EDA030'),
(155, 15, 'EDA031'),
(156, 16, 'DES001'),
(157, 16, 'DES002'),
(158, 16, 'DES003'),
(159, 16, 'DES004'),
(160, 16, 'DES005'),
(161, 16, 'DES006'),
(162, 16, 'DES007'),
(163, 16, 'DES008'),
(164, 16, 'DES009'),
(165, 16, 'DES010'),
(166, 16, 'DES011'),
(167, 16, 'DES012'),
(168, 16, 'DES013'),
(169, 16, 'DES014'),
(170, 16, 'DES015'),
(171, 16, 'DES016'),
(172, 16, 'DES017'),
(173, 16, 'DES018'),
(174, 16, 'DES019'),
(175, 16, 'DES020'),
(176, 16, 'DES021'),
(177, 16, 'DES022'),
(178, 16, 'DES023'),
(179, 16, 'DES024'),
(180, 16, 'DES025'),
(181, 16, 'DES026'),
(182, 16, 'DES027'),
(183, 16, 'DES028'),
(185, 17, 'EAD001'),
(186, 17, 'EAD002'),
(187, 17, 'EAD003'),
(188, 17, 'EAD004'),
(189, 17, 'EAD005'),
(190, 17, 'EAD006'),
(191, 17, 'EAD007'),
(192, 17, 'EAD008'),
(193, 17, 'EAD009'),
(194, 17, 'EAD010'),
(195, 17, 'EAD011'),
(196, 17, 'EAD012'),
(197, 17, 'EAD013'),
(198, 17, 'EAD014'),
(199, 18, 'PCL001'),
(200, 18, 'PCL002'),
(201, 18, 'PCL003'),
(202, 18, 'PCL004'),
(203, 18, 'PCL005'),
(204, 18, 'PCL006'),
(205, 18, 'PCL007'),
(206, 18, 'PCL008'),
(207, 18, 'PCL009'),
(208, 18, 'PCL010'),
(209, 18, 'PCL011'),
(210, 18, 'PCL012'),
(211, 18, 'PCL013'),
(212, 18, 'PCL014'),
(213, 18, 'PCL015'),
(214, 18, 'PCL016'),
(215, 18, 'PCL017'),
(216, 18, 'PCL018'),
(217, 18, 'PCL019'),
(218, 18, 'PCL020'),
(219, 18, 'PCL021'),
(220, 18, 'PCL022'),
(221, 18, 'PCL023'),
(222, 18, 'PCL024'),
(223, 18, 'PCL025'),
(224, 18, 'PCL026'),
(225, 18, 'PCL027'),
(226, 18, 'PCL028'),
(227, 18, 'PCL029'),
(228, 18, 'PCL030'),
(229, 18, 'PCL031'),
(230, 18, 'PCL032');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestaestudiante`
--

CREATE TABLE `respuestaestudiante` (
  `id` int(11) NOT NULL,
  `id_preguntacuestionario` int(11) DEFAULT NULL,
  `respuesta1` text DEFAULT NULL,
  `id_respuestaestudiante` int(11) DEFAULT NULL,
  `id_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `tipo_usuario`) VALUES
(4, '1030628744', '$2y$10$qUt4DVhvZB4EouSA8bbn/OWBEHYvOWHAwhGKHK0les5ajaqGdiR56', '2024-10-02 20:40:28', 'admin'),
(7, '83220595', '$2y$10$PZCXsB18UUtwrQobMeEI7ODKHx4HAyunTLQrv8DtpKF5D6lhBZfEe', '2024-10-08 21:06:13', 'estudiante'),
(8, '1010060619', '$2y$10$N1j6nrTtYiOzaiitybUEJe9.UK.0Gy7IzJqyXjvL10y5FPHfp1N2u', '2024-10-11 03:51:28', 'admin'),
(12, '17055714', '$2y$10$t2w1NzYdFkHuthAQ/kmcN.mB7SGVMwPP6yzHhFvs5I9ingTiO3Q9.', '2024-10-14 17:07:08', 'admin'),
(13, '41532592', '$2y$10$HYwBL81bcxyC9FZcZpuzruoolVfnOQ/TotDwm3aGUEd4aWDVTshnO', '2024-10-14 17:26:41', 'estudiante');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuestionarios_resueltos`
--
ALTER TABLE `cuestionarios_resueltos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estudiante` (`id_estudiante`),
  ADD KEY `fk_cuestionario` (`id_cuestionario`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntascuestionario`
--
ALTER TABLE `preguntascuestionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cuestionario` (`id_cuestionario`),
  ADD KEY `preguntascuestionario_ibfk_2` (`id_pregunta`);

--
-- Indices de la tabla `respuestaestudiante`
--
ALTER TABLE `respuestaestudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_preguntacuestionario` (`id_preguntacuestionario`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cuestionarios_resueltos`
--
ALTER TABLE `cuestionarios_resueltos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntascuestionario`
--
ALTER TABLE `preguntascuestionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de la tabla `respuestaestudiante`
--
ALTER TABLE `respuestaestudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuestionarios_resueltos`
--
ALTER TABLE `cuestionarios_resueltos`
  ADD CONSTRAINT `fk_cuestionario` FOREIGN KEY (`id_cuestionario`) REFERENCES `cuestionario` (`id`),
  ADD CONSTRAINT `fk_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `preguntascuestionario`
--
ALTER TABLE `preguntascuestionario`
  ADD CONSTRAINT `preguntascuestionario_ibfk_1` FOREIGN KEY (`id_cuestionario`) REFERENCES `cuestionario` (`id`),
  ADD CONSTRAINT `preguntascuestionario_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `respuestaestudiante`
--
ALTER TABLE `respuestaestudiante`
  ADD CONSTRAINT `respuestaestudiante_ibfk_1` FOREIGN KEY (`id_preguntacuestionario`) REFERENCES `preguntascuestionario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
