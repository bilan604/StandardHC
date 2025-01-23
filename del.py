

import requests
url = "http://127.0.0.1:8000"
resp = requests.get(url)
print(resp.text)


