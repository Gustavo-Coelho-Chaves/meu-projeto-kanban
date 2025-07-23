import os
import platform
import ipaddress
import subprocess
import socket

param = "-n" if platform.system().lower() == "windows" else "-c"

def ping(ip):
    command = ["ping", param, "1", str(ip)]
    return subprocess.call(command, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL) == 0

def get_local_ip():
    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        s.connect(("8.8.8.8", 80))
        ip = s.getsockname()[0]
        s.close()
        return ip
    except Exception as e:
        print(f"Erro ao obter IP local: {e}")
        return None

def scan_network():
    local_ip = get_local_ip()
    if not local_ip:
        print("Não foi possível obter o IP local.")
        return
    
    network = ipaddress.ip_network(local_ip + "/24", strict=False)
    print(f"A verificar a rede: {network}")

    for ip in network.hosts():
        if ping(ip):
            print(f"[+] IP ativo encontrado: {ip}")

scan_network()
