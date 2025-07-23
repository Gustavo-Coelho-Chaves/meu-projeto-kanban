# Scanner de Rede Local em Python

Este script é uma ferramenta simples de **varredura de IPs ativos** em uma rede local (`/24`) utilizando o comando `ping`. Ele identifica dispositivos conectados que estão respondendo, ajudando a mapear quais máquinas estão ativas na sua rede.

---

## Como funciona

1. Detecta o sistema operacional (Windows, Linux ou macOS).
2. Descobre o IP local da máquina.
3. Calcula a sub-rede correspondente (máscara `/24`).
4. Executa um `ping` para cada IP possível da rede.
5. Exibe os IPs que responderem ao ping como "ativos".

---

##  Exemplo de saída

```bash
A verificar a rede: 192.168.0.0/24
[+] IP ativo encontrado: 192.168.0.1
[+] IP ativo encontrado: 192.168.0.103
[+] IP ativo encontrado: 192.168.0.201

