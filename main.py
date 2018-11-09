import json
from pprint import pprint

with open('usuarios.json') as f:
    data = json.load(f)

pprint(data)

