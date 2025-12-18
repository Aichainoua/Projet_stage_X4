# 1. On passe à la version 20 (Alpine) car vos dépendances le demandent
FROM node:20-alpine

WORKDIR /app

# 2. INSTALLATION DES OUTILS SYSTÈME MANQUANTS
# Python et Make sont obligatoires pour compiler "better-sqlite3"
RUN apk add --no-cache python3 make g++

COPY package*.json ./

# 3. Installation des paquets Node
RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "run", "dev"]