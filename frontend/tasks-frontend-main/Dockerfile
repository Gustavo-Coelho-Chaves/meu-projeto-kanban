FROM node:18-alpine

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN NODE_OPTIONS="--max-old-space-size=1024" npm run build

EXPOSE 3000
CMD ["npm", "start"]
