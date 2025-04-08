# atualizar.ps1

Write-Host "Atualizando repositório..."
git pull origin main

Write-Host "`nBuildando imagens Docker..."
docker build -t frontend:latest ./frontend
docker build -t backend:latest ./backend
docker pull postgres:14

Write-Host "`nTagueando imagens para o Google Artifact Registry..."
docker tag frontend:latest southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/frontend:latest
docker tag backend:latest southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/backend:latest
docker tag postgres:14 southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/postgres:14

Write-Host "`nEnviando imagens para o Google Artifact Registry..."
docker push southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/frontend:latest
docker push southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/backend:latest
docker push southamerica-east1-docker.pkg.dev/dauntless-motif-455700-p3/kanban/postgres:14

Write-Host "`nProcesso concluido com sucesso!"
