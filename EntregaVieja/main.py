import json
from pprint import pprint

with open('messages.json', "r") as f:
	aux = f.readlines()
	print(aux.pop(0).strip())
	id = 0
	while "]" not in aux[0]:
		print(aux.pop(0).strip())
		print('"id": {},'.format(id))
		id += 1
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())
		print(aux.pop(0).strip())

	print(aux.pop(0).strip())

		



