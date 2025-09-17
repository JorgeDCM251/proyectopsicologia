# %%
import mysql.connector
import pandas as pd
from typing import List, Tuple, Dict

class PsicologiaDB:
    def __init__(self, host, user, password, database, port):
        self.host = host
        self.user = user
        self.password = password
        self.database = database
        self.port = port

    def connect(self):
        return mysql.connector.connect(
            host=self.host,
            user=self.user,
            password=self.password,
            database=self.database,
            port=self.port
        )

class PsicologiaAnalyzer:
    def __init__(self, db: PsicologiaDB):
        self.db = db
        
    def get_existing_results(self) -> set:
        """
        Obtiene los pares id_estudiante, id_cuestionario que ya existen en la tabla
        """
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()
            
            query = """
                SELECT DISTINCT id_estudiante, id_cuestionario 
                FROM Tabla_resultados
            """
            
            cursor.execute(query)
            resultados = cursor.fetchall()
            
            # Crear un conjunto de tuplas (id_estudiante, id_cuestionario)
            return {(str(r[0]), str(r[1])) for r in resultados}
            
        except mysql.connector.Error as err:
            print(f"Error al obtener resultados existentes: {err}")
            return set()
        finally:
            if conexion:
                conexion.close()
                
    def obtener_puntaje_final(self, id_cuestionario: int, umbral: int = 3) -> List[Tuple]:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()

            consulta = """
                SELECT 
                    id_estudiante, 
                    id_cuestionario, 
                    SUM(CASE WHEN UPPER(TRIM(respuesta1)) = 'SI' THEN 1 ELSE 0 END) AS puntaje_final
                FROM 
                    respuestaestudiante
                WHERE
                    id_cuestionario = %s
                GROUP BY 
                    id_estudiante, id_cuestionario
            """
            
            cursor.execute(consulta, (id_cuestionario,))
            resultados = cursor.fetchall()

            resultados_convertidos = [
                (
                    int(id_estudiante), 
                    int(id_cuestionario), 
                    int(puntaje_final), 
                    "SIGNIFICATIVO" if puntaje_final > umbral else "NO SIGNIFICATIVO",
                    *([None] * 15)  # Agregar 15 None para completar las 19 columnas
                ) 
                for id_estudiante, id_cuestionario, puntaje_final in resultados
            ]

            return resultados_convertidos

        except mysql.connector.Error as err:
            print(f"Error en la base de datos: {err}")
            return []
        finally:
            if conexion:
                conexion.close()

    def calcular_escala_autocuidado(self, id_cuestionario: int, codigos: Dict[str, List[str]]) -> List[Tuple]:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()

            query = """
                SELECT id_estudiante, id_cuestionario, id_pregunta, respuesta1
                FROM respuestaestudiante
                WHERE id_cuestionario = %s
            """
            
            cursor.execute(query, (id_cuestionario,))
            resultados = cursor.fetchall()

            df = pd.DataFrame(resultados, columns=['id_estudiante', 'id_cuestionario', 'id_pregunta', 'respuesta1'])
            df['respuesta1'] = pd.to_numeric(df['respuesta1'], errors='coerce')

            resultados_finales = []
            for estudiante_id in df['id_estudiante'].unique():
                datos_estudiante = df[df['id_estudiante'] == estudiante_id]
                valores = {'id_estudiante': int(estudiante_id), 'id_cuestionario': id_cuestionario}

                for categoria, codigos_cat in codigos.items():
                    suma = datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos_cat)]['respuesta1'].sum()
                    valores[categoria] = int(suma if pd.notnull(suma) else 0)
                    valores[f'%{categoria}'] = float(format((valores[categoria] * 100) / 217, '.2f'))

                valores['%RESUL'] = float(format(sum(valores[f'%{cat}'] for cat in codigos.keys()), '.2f'))
                valores['%falt'] = float(format(100 - valores['%RESUL'], '.2f'))

                tupla_resultado = (
                    valores['id_estudiante'],
                    valores['id_cuestionario'],
                    valores['AD'],
                    valores['TA'],
                    valores['PA'],
                    valores['R'],
                    valores['NP'],
                    valores['NN'],
                    valores['%AD'],
                    valores['%TA'],
                    valores['%PA'],
                    valores['%R'],
                    valores['%NP'],
                    valores['%NN'],
                    valores['%RESUL'],
                    valores['%falt'],
                    *([None] * 3)  # Agregar 3 None para completar las 19 columnas
                )
                resultados_finales.append(tupla_resultado)

            return resultados_finales

        except mysql.connector.Error as error:
            print(f"Error al conectar con la base de datos: {error}")
            return []
        except Exception as e:
            print(f"Error general: {e}")
            return []
        finally:
            if conexion:
                conexion.close()

    def calcular_escala_disociativa(self, id_cuestionario: int, codigos: Dict[str, List[str]]) -> List[Tuple]:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()

            query = """
                SELECT id_estudiante, id_cuestionario, id_pregunta, respuesta1
                FROM respuestaestudiante
                WHERE id_cuestionario = %s
            """
            
            cursor.execute(query, (id_cuestionario,))
            resultados = cursor.fetchall()

            df = pd.DataFrame(resultados, columns=['id_estudiante', 'id_cuestionario', 'id_pregunta', 'respuesta1'])
            df['respuesta_numerica'] = df['respuesta1'].apply(lambda x: float(x.strip('%')) if isinstance(x, str) and '%' in x else 0)

            resultados_finales = []
            for estudiante_id in df['id_estudiante'].unique():
                datos_estudiante = df[df['id_estudiante'] == estudiante_id]
                promedio = datos_estudiante['respuesta_numerica'].sum() / 28

                condicion = (
                    "trastorno de identidad disociativo" if promedio >= 45 else
                    "trastorno disociativo" if promedio >= 35 else
                    "estrés postraumático" if promedio >= 28 else
                    "sin trastorno"
                )

                amnesia = sum(datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos['Amnesia'])]['respuesta_numerica']) / 8
                disociacion = sum(datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos['Disociacion'])]['respuesta_numerica']) / 10
                despersonalizacion = sum(datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos['DespersonalizacionyDesrealizacion'])]['respuesta_numerica']) / 6
                muy_importante = sum(datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos['Muy_importante'])]['respuesta_numerica']) / 6
                importante = sum(datos_estudiante[datos_estudiante['id_pregunta'].isin(codigos['Importante'])]['respuesta_numerica']) / 3

                tupla_resultado = (
                    int(estudiante_id),
                    int(id_cuestionario),
                    float(format(promedio, '.2f')),
                    condicion,
                    float(format(amnesia, '.2f')),
                    float(format(disociacion, '.2f')),
                    float(format(despersonalizacion, '.2f')),
                    float(format(muy_importante, '.2f')),
                    float(format(importante, '.2f')),
                    *([None] * 10)  # Agregar 10 None para completar las 19 columnas
                )
                resultados_finales.append(tupla_resultado)

            return resultados_finales

        except mysql.connector.Error as error:
            print(f"Error al conectar con la base de datos: {error}")
            return []
        except Exception as e:
            print(f"Error general: {e}")
            return []
        finally:
            if conexion:
                conexion.close()

    def calcular_PCL5(self, id_cuestionario: int) -> List[Tuple]:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()

            # Mapeo de respuestas a valores numéricos
            respuesta_valores = {
                "No del todo": 0,
                "Un Poco": 1,
                "Moderado": 2,
                "Mucho": 3,
                "Extremadamente": 4
            }

            consulta = """
                SELECT id_estudiante, id_cuestionario, id_pregunta, respuesta1
                FROM respuestaestudiante
                WHERE id_cuestionario = %s
            """
            
            cursor.execute(consulta, (id_cuestionario,))
            resultados = cursor.fetchall()

            # Procesar resultados por estudiante
            estudiantes = {}
            for id_estudiante, id_cuestionario, id_pregunta, respuesta in resultados:
                if id_estudiante not in estudiantes:
                    estudiantes[id_estudiante] = {
                        'id_cuestionario': id_cuestionario,
                        'Cluster B': 0,
                        'Cluster C': 0,
                        'Cluster D': 0,
                        'Cluster E': 0,
                        'TOTAL': 0,
                        'diagnostico_TEPTclusterB': "NO",
                        'diagnostico_TEPTclusterC': "NO",
                        'diagnostico_TEPTclusterD': "NO",
                        'diagnostico_TEPTclusterE': "NO"
                    }

                valor = respuesta_valores.get(respuesta, 0)

                # Asignar valores a los clusters correspondientes
                if id_pregunta in ['PCL013', 'PCL014', 'PCL015', 'PCL016', 'PCL017']:
                    estudiantes[id_estudiante]['Cluster B'] += valor
                    if 2 <= valor <= 4:
                        estudiantes[id_estudiante]['diagnostico_TEPTclusterB'] = "SI"
                elif id_pregunta in ['PCL018', 'PCL019']:
                    estudiantes[id_estudiante]['Cluster C'] += valor
                    if 2 <= valor <= 4:
                        estudiantes[id_estudiante]['diagnostico_TEPTclusterC'] = "SI"
                elif id_pregunta in ['PCL020', 'PCL021', 'PCL022', 'PCL023', 'PCL024', 'PCL025', 'PCL026']:
                    estudiantes[id_estudiante]['Cluster D'] += valor
                    if 2 <= valor <= 4:
                        estudiantes[id_estudiante]['diagnostico_TEPTclusterD'] = "SI"
                elif id_pregunta in ['PCL027', 'PCL028', 'PCL029', 'PCL030', 'PCL031', 'PCL032']:
                    estudiantes[id_estudiante]['Cluster E'] += valor
                    if 2 <= valor <= 4:
                        estudiantes[id_estudiante]['diagnostico_TEPTclusterE'] = "SI"

            # Calcular totales y crear tuplas de resultados
            resultados_finales = []
            for id_estudiante, datos in estudiantes.items():
                datos['TOTAL'] = (
                    datos['Cluster B'] +
                    datos['Cluster C'] +
                    datos['Cluster D'] +
                    datos['Cluster E']
                )

                tupla_resultado = (
                    id_estudiante,
                    datos['id_cuestionario'],
                    datos['Cluster B'],
                    datos['Cluster C'],
                    datos['Cluster D'],
                    datos['Cluster E'],
                    datos['TOTAL'],
                    datos['diagnostico_TEPTclusterB'],
                    datos['diagnostico_TEPTclusterC'],
                    datos['diagnostico_TEPTclusterD'],
                    datos['diagnostico_TEPTclusterE'],
                    *([None] * 8)  # Completar hasta 19 columnas
                )
                resultados_finales.append(tupla_resultado)

            return resultados_finales

        except mysql.connector.Error as err:
            print(f"Error en la base de datos: {err}")
            return []
        finally:
            if conexion:
                conexion.close()

    def calcular_escala_ansiedad_depresion(self, id_cuestionario: int) -> List[Tuple]:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()

            # Mapeo de respuestas a valores numéricos
            respuesta_valores = {
                'EAD001': {"Todos los días": 3, "Muchas veces": 2, "A veces": 1, "Nunca": 0},
                'EAD002': {"Como siempre": 0, "No lo bastante": 1, "Solo un poco": 2, "Nada": 3},
                'EAD003': {"Definitivamente y es muy fuerte": 3, "Sí, pero no es muy fuerte": 2, "Un poco pero no me preocupa": 1, "Nada": 0},
                'EAD004': {"Al igual que siempre lo hice": 0, "No tanto ahora": 1, "Casi nunca": 2, "Nunca": 3},
                'EAD005': {"La mayoría de las veces": 3, "Con bastante frecuencia": 2, "A veces, aunque no muy seguido": 1, "Solo en ocasiones": 0},
                'EAD006': {"Nunca": 3, "No muy seguido": 2, "A veces": 1, "Casi siempre": 0},
                'EAD007': {"Siempre": 0, "Por lo general": 1, "No muy seguido": 2, "Nunca": 3},
                'EAD008': {"Por lo general en todo momento": 3, "Muy seguido": 2, "A veces": 1, "Nunca": 0},
                'EAD009': {"Nunca": 0, "En ciertas ocasiones": 1, "Con bastante frecuencia": 2, "Muy seguido": 3},
                'EAD010': {"Totalmente": 3, "No me preocupa como debiera": 2, "Podría tener un poco más de cuidado": 1, "Me preocupo al igual que siempre": 0},
                'EAD011': {"Mucho": 3, "Bastante": 2, "No mucho": 1, "Nada": 0},
                'EAD012': {"Igual que siempre": 0, "Menos de lo que acostumbraba": 1, "Mucho menos de lo que acostumbraba": 2, "Nada": 3},
                'EAD013': {"Muy frecuentemente": 3, "Bastante seguido": 2, "No muy seguido": 1, "Nada": 0},
                'EAD014': {"Seguido": 0, "A veces": 1, "No muy seguido": 2, "Rara vez": 3},
            }

            consulta = """
                SELECT id_estudiante, id_cuestionario, id_pregunta, respuesta1
                FROM respuestaestudiante
                WHERE id_cuestionario = %s
            """
            
            cursor.execute(consulta, (id_cuestionario,))
            resultados = cursor.fetchall()

            # Diccionario para almacenar los datos procesados
            estudiantes = {}

            # Procesar las respuestas y asignar valores
            for id_estudiante, id_cuestionario, id_pregunta, respuesta in resultados:
                if id_estudiante not in estudiantes:
                    estudiantes[id_estudiante] = {
                        'id_cuestionario': id_cuestionario,
                        'TOTAL': 0,
                        'subescaladeAnsiedad': 0,
                        'subescaladeDepresion': 0
                    }
                
                # Obtener el valor numérico de la respuesta
                valor = respuesta_valores.get(id_pregunta, {}).get(respuesta, 0)
                estudiantes[id_estudiante]['TOTAL'] += valor

                # Clasificar en ansiedad o depresión
                if id_pregunta in ['EAD001', 'EAD003', 'EAD005', 'EAD007', 'EAD009', 'EAD011', 'EAD013']:
                    estudiantes[id_estudiante]['subescaladeAnsiedad'] += valor
                elif id_pregunta in ['EAD002', 'EAD004', 'EAD006', 'EAD008', 'EAD010', 'EAD012', 'EAD014']:
                    estudiantes[id_estudiante]['subescaladeDepresion'] += valor

            # Generar resultados finales
            resultados_finales = []
            for id_estudiante, datos in estudiantes.items():
                # Diagnóstico TOTAL
                if datos['TOTAL'] <= 7:
                    diagnostico_TOTAL = "Ausencia de ansiedad y/o depresión clínicamente relevante"
                elif datos['TOTAL'] <= 10:
                    diagnostico_TOTAL = "Requiere consideración"
                else:
                    diagnostico_TOTAL = "Presencia de sintomatología relevante y un probable caso de ansiedad y/o depresión"

                # Diagnóstico Subescala de Ansiedad
                if datos['subescaladeAnsiedad'] <= 7:
                    diagnostico_subescaladeAnsiedad = "Ausencia de ansiedad y/o depresión clínicamente relevante"
                elif datos['subescaladeAnsiedad'] <= 10:
                    diagnostico_subescaladeAnsiedad = "Requiere consideración"
                else:
                    diagnostico_subescaladeAnsiedad = "Presencia de sintomatología relevante y un probable caso de ansiedad y/o depresión"

                # Diagnóstico Subescala de Depresión
                if datos['subescaladeDepresion'] <= 7:
                    diagnostico_subescaladeDepresion = "Ausencia de ansiedad y/o depresión clínicamente relevante"
                elif datos['subescaladeDepresion'] <= 10:
                    diagnostico_subescaladeDepresion = "Requiere consideración"
                else:
                    diagnostico_subescaladeDepresion = "Presencia de sintomatología relevante y un probable caso de ansiedad y/o depresión"

                # Crear tupla de resultado
                tupla_resultado = (
                    id_estudiante,
                    datos['id_cuestionario'],
                    datos['TOTAL'],
                    datos['subescaladeAnsiedad'],
                    datos['subescaladeDepresion'],
                    diagnostico_TOTAL,
                    diagnostico_subescaladeAnsiedad,
                    diagnostico_subescaladeDepresion,
                    *([None] * 11)  # Completar hasta 19 columnas
                )
                resultados_finales.append(tupla_resultado)

            return resultados_finales

        except mysql.connector.Error as error:
            print(f"Error al conectar con la base de datos: {error}")
            return []
        except Exception as e:
            print(f"Error general: {e}")
            return []
        finally:
            if conexion:
                conexion.close()
    def cargar_resultados_en_tabla(self, resultados: List[Tuple]):
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()
            
            # Obtener resultados existentes
            existing_results = self.get_existing_results()
            
            # Filtrar solo los nuevos resultados
            nuevos_resultados = []
            duplicados = 0
            
            for resultado in resultados:
                # Los dos primeros elementos son id_estudiante e id_cuestionario
                key = (str(resultado[0]), str(resultado[1]))
                if key not in existing_results:
                    nuevos_resultados.append(resultado)
                else:
                    duplicados += 1

            if duplicados > 0:
                print(f"Se encontraron {duplicados} resultados duplicados que no serán insertados.")

            if not nuevos_resultados:
                print("No hay nuevos resultados para insertar.")
                return

            query = """
                INSERT INTO Tabla_resultados (
                    id_estudiante, id_cuestionario, 
                    respuesta_1, respuesta_2, respuesta_3, respuesta_4, respuesta_5,
                    respuesta_6, respuesta_7, respuesta_8, respuesta_9, respuesta_10,
                    nueva_columna_11, nueva_columna_12, nueva_columna_13, nueva_columna_14,
                    nueva_columna_15, nueva_columna_16, nueva_columna_17
                ) VALUES (
                    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
                )
            """

            for resultado in nuevos_resultados:
                # Convertir el resultado a una lista para poder modificarla
                resultado_list = list(resultado)
                
                # Asegurarse de que el resultado tenga 19 valores
                while len(resultado_list) < 19:
                    resultado_list.append(None)
                    
                # Truncar si hay más de 19 valores
                resultado_list = resultado_list[:19]
                
                cursor.execute(query, tuple(resultado_list))

            conexion.commit()
            print(f"Se insertaron {len(nuevos_resultados)} nuevos resultados correctamente.")

        except mysql.connector.Error as err:
            print(f"Error en la base de datos: {err}")
        finally:
            if conexion:
                conexion.close() 
                
    def cargar_resultados_en_tabla(self, resultados: List[Tuple]) -> int:
        try:
            conexion = self.db.connect()
            cursor = conexion.cursor()
            
            # Obtener resultados existentes
            existing_results = self.get_existing_results()
            
            # Filtrar solo los nuevos resultados
            nuevos_resultados = []
            duplicados = 0
            
            for resultado in resultados:
                # Los dos primeros elementos son id_estudiante e id_cuestionario
                key = (str(resultado[0]), str(resultado[1]))
                if key not in existing_results:
                    nuevos_resultados.append(resultado)
                else:
                    duplicados += 1

            if duplicados > 0:
                print(f"Se encontraron {duplicados} resultados duplicados que no serán insertados.")

            if not nuevos_resultados:
                print("No hay nuevos resultados para insertar.")
                return 0

            query = """
                INSERT INTO Tabla_resultados (
                    id_estudiante, id_cuestionario, 
                    respuesta_1, respuesta_2, respuesta_3, respuesta_4, respuesta_5,
                    respuesta_6, respuesta_7, respuesta_8, respuesta_9, respuesta_10,
                    nueva_columna_11, nueva_columna_12, nueva_columna_13, nueva_columna_14,
                    nueva_columna_15, nueva_columna_16, nueva_columna_17
                ) VALUES (
                    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
                )
            """

            for resultado in nuevos_resultados:
                resultado_list = list(resultado)
                while len(resultado_list) < 19:
                    resultado_list.append(None)
                resultado_list = resultado_list[:19]
                cursor.execute(query, tuple(resultado_list))

            conexion.commit()
            return len(nuevos_resultados)

        except mysql.connector.Error as err:
            print(f"Error en la base de datos: {err}")
            return 0
        finally:
            if conexion:
                conexion.close()

# Código de uso
if __name__ == "__main__":
    # Configuración de la base de datos
    db = PsicologiaDB(
        host='localhost',
        user='root',
        password='MyCLFDBss8**',
        database='proyectopsicologia',
        port='3306'
    )
    
    # Crear instancia del analizador
    analyzer = PsicologiaAnalyzer(db)
    total_nuevos_resultados = 0  # Contador global

    # Configuración de las pruebas
    pruebas = {
        "experiencias_adversas": [14, 21, 22, 23, 24],
        "escala_autocuidado": [15, 25, 26, 27, 28],
        "escala_disociativa": [16, 29, 30, 31, 32],
        "escala_ansiedad_depresion": [17, 33, 34, 35, 36],
        "PCL5": [18, 37, 38, 39, 40]
    }

    # Diccionarios de códigos para las diferentes escalas
    codigos_autocuidado = {
        'AD': ['EDA001', 'EDA008', 'EDA012', 'EDA016', 'EDA023', 'EDA028', 'EDA031'],
        'TA': ['EDA002', 'EDA006', 'EDA015', 'EDA020', 'EDA027'],
        'PA': ['EDA003', 'EDA011', 'EDA017', 'EDA029'],
        'R': ['EDA004', 'EDA009', 'EDA013', 'EDA018', 'EDA024'],
        'NP': ['EDA005', 'EDA021', 'EDA025', 'EDA030'],
        'NN': ['EDA007', 'EDA010', 'EDA014', 'EDA019', 'EDA022', 'EDA026']
    }

    codigos_disociativa = {
        'Amnesia': ['DES003', 'DES004', 'DES005', 'DES006', 'DES008', 'DES010', 'DES025', 'DES026'],
        'Disociacion': ['DES001', 'DES002', 'DES014', 'DES015', 'DES016', 'DES017', 'DES018', 'DES020', 'DES022', 'DES023'],
        'DespersonalizacionyDesrealizacion': ['DES007', 'DES011', 'DES012', 'DES013', 'DES027', 'DES028'],
        'Muy_importante': ['DES003', 'DES004', 'DES007', 'DES009', 'DES011', 'DES022'],
        'Importante': ['DES010', 'DES013', 'DES027']
    }

    # Ejecutar todas las pruebas para todas las aplicaciones y cargar resultados
    for prueba, ids_cuestionarios in pruebas.items():
        print(f"\nProcesando {prueba}...")
        for id_cuestionario in ids_cuestionarios:
            print(f"Procesando cuestionario {id_cuestionario}...")
            
            if prueba == "experiencias_adversas":
                resultados = analyzer.obtener_puntaje_final(id_cuestionario)
            elif prueba == "escala_autocuidado":
                resultados = analyzer.calcular_escala_autocuidado(id_cuestionario, codigos_autocuidado)
            elif prueba == "escala_disociativa":
                resultados = analyzer.calcular_escala_disociativa(id_cuestionario, codigos_disociativa)
            elif prueba == "escala_ansiedad_depresion":
                resultados = analyzer.calcular_escala_ansiedad_depresion(id_cuestionario)
            elif prueba == "PCL5":
                resultados = analyzer.calcular_PCL5(id_cuestionario)

            if resultados:
                nuevos = analyzer.cargar_resultados_en_tabla(resultados)
                total_nuevos_resultados += nuevos
                print(f"Se cargaron {nuevos} nuevos resultados para el cuestionario {id_cuestionario}.")
            else:
                print(f"No se encontraron resultados para el cuestionario {id_cuestionario}.")

    print("\nProceso completado.")
    print(f"Total de nuevos resultados cargados: {total_nuevos_resultados}")


