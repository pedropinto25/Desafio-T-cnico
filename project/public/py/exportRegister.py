import mysql.connector
import pandas as pd
from datetime import datetime, timedelta
from dotenv import load_dotenv
import os

# Carregar as variáveis de ambiente do arquivo .env
base_dir = os.path.dirname(os.path.abspath(__file__))
env_path = os.path.join(base_dir, '..', '..', '..', '.env')
load_dotenv(dotenv_path=env_path)

# Configurações da base de dados
db_config = {
    'user': os.getenv('DB_USER'),
    'password': os.getenv('DB_PASS'),
    'host': os.getenv('DB_HOST'),
    'database': os.getenv('DB_NAME')
}

# Conectar a base de dados
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

# Calcular a data  7 dias atrás
seven_days_ago = datetime.now() - timedelta(days=7)

# Query para pesquisar os dados dos últimos 7 dias
query = """
SELECT ws.id, ws.user_id, u.name, ws.start_time, ws.end_time, ws.status
FROM work_sessions ws
JOIN users u ON ws.user_id = u.id
WHERE ws.start_time >= %s
"""

# Executa a query
cursor.execute(query, (seven_days_ago,))
rows = cursor.fetchall()

# Nome das colunas
columns = ['ID da Sessão', 'ID do Utilizador', 'Nome do Utilizador', 'Início da Sessão', 'Fim da Sessão', 'Status']

# Criar um DataFrame com os dados
df = pd.DataFrame(rows, columns=columns)

# Garantir que as colunas de data estão no formato correto
df['Início da Sessão'] = pd.to_datetime(df['Início da Sessão']).dt.strftime('%Y-%m-%d %H:%M:%S')
df['Fim da Sessão'] = pd.to_datetime(df['Fim da Sessão']).dt.strftime('%Y-%m-%d %H:%M:%S')

# Exportar para CSV
csv_filename = os.path.join(base_dir, 'work_sessions_last_7_days.csv')
df.to_csv(csv_filename, index=False, sep=';', encoding='utf-8')

# Fechar a conexão com o banco de dados
cursor.close()
conn.close()

print(csv_filename)