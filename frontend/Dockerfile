# Usar uma imagem do Node.js
FROM node:18-alpine

# Definir diretório de trabalho
WORKDIR /app

# Copiar arquivos para dentro do contêiner
COPY . .

# Instalar dependências
RUN npm install

# Construir a aplicação React
RUN npm run build

# Expor a porta 3000
EXPOSE 3000

# Comando para iniciar o servidor do React
CMD ["npm", "start"]
