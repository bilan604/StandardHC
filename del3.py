import requests

print("OK")
#url = "http://127.0.0.1:8000"
#url = "http://172.26.46.251" # from python
#url = "http://8.210.139.205"
#url = "http://34.123.30.204/"
url = "http://standard-hc.com"
resp = requests.get(url)
print(resp.text)
