import socket

try:
    hostname = socket.gethostname()
    local_ip = socket.gethostbyname(hostname)
    print(f"Your Local IP Address is: {local_ip}")
except socket.error as e:
    print(f"Error retrieving local IP: {e}")
