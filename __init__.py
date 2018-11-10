from flask import Flask, jsonify, abort, request
from pymongo import MongoClient
import sys
import geocoder
from random import randint
import time

app = Flask(__name__)

PORT = 5000

MONGODATABASE = "test"
MONGOSERVER = "localhost"
MONGOPORT = 27017

client = MongoClient(MONGOSERVER, MONGOPORT)


def remove_id(obj):
    for item in obj:
        item.pop("_id", None)


@app.route('/')
def hello_world():
    return "Hello World!", 200


@app.route('/user/<int:user>', methods=['GET'])
def get_user(user):
    mongodb = client[MONGODATABASE]
    users = mongodb.usuarios
    messages = mongodb.messages
    user_output = list()
    message_output = list()
    output = dict()
    for s in users.find({"id": user}):
        user_output.append(s)
    if len(user_output) == 0:
        return "El usuario con ID = {} no existe.".format(user), 404
    else:
        remove_id(user_output)
        output.update({"user": user_output[0]})
        for s in messages.find({"sender": user}):
            message_output.append(s)
        remove_id(message_output)
        output.update({"messages": message_output})
        return jsonify(output), 200


@app.route('/message/<int:message>', methods=['GET'])
def get_message(message):
    mongodb = client[MONGODATABASE]
    messages = mongodb.messages
    output = list()
    for s in messages.find({"id": message}):
        output.append(s)
    if len(output) == 0:
        return "El mensaje con ID = {} no existe.".format(message), 404
    else:
        remove_id(output)
        return jsonify(output[0]), 200


@app.route('/users/<users>', methods=['GET'])
def get_inter(users):
    user_list = users.split('&')
    if len(user_list) != 2:
        return "Formato inválido, por favor intente nuevamente", 400
    mongodb = client[MONGODATABASE]
    messages = mongodb.messages
    output = list()
    for s in messages.find(
            {"$or": [{"$and": [{"sender": int(user_list[0]),
                                "receptant": int(user_list[1])}]},
                     {"$and": [{"sender": int(user_list[1]),
                                "receptant": int(user_list[0])}]}]}):
        output.append(s)
    if len(output) == 0:
        return "No se encontraron mensajes", 404
    else:
        remove_id(output)
        return jsonify(output), 200


@app.route('/search', methods=['GET'])
def search_text():
    user = request.args.get('user', None)
    mandatory = request.args.get('1', None)
    non_mand = request.args.get('2', None)
    forbidden = request.args.get('3', None)
    print(user, mandatory, non_mand, forbidden)
    queries = list()
    if user is not None:
        queries.append({"sender": int(user)})
    if non_mand is not None:
        non_mand = non_mand.split('|')
        non_words = list()
        for word in non_mand:
            non_words.append({"$text": {"$search": word}})
        queries.append({"$or": non_words})
    if mandatory is not None:
        mandatory = mandatory.split('|')
        words = list()
        for frase in mandatory:
            words.append("\"" + frase + "\"")
        queries.append({"$text": {"$search": ' '.join(words)}})
    if forbidden is not None:
        for_words = forbidden.split('|')
        new_words = list()
        for word in for_words:
            new_words.append("-" + word)
        nowo = ' '.join(new_words)
        print(nowo, "nowo")
        queries.append({"$text": {"$search": nowo}})
    if not queries:
        return "No se hicieron queries", 400
    else:
        mongodb = client[MONGODATABASE]
        messages = mongodb.messages
        output = list()
        for s in messages.find({"$and": queries}):
            output.append(s)
        if len(output) == 0:
            return "No se encontraron mensajes", 404
        else:
            remove_id(output)
            return jsonify(output), 200


@app.route('/add_message', methods=['POST'])
def add_message():
    user1 = request.args.get('1', None)
    user2 = request.args.get('2', None)
    message = request.args.get('m', None)
    try: 
        user1 = int(user1)
        user2 = int(user2)
    except:
        return "Formato incorrecto", 404

    g = geocoder.ip('me')
    lat = g.latlng[0]
    lon = g.latlng[1]

    mongodb = client[MONGODATABASE]
    messages = mongodb.messages

    while True:
        mid = randint(0,9999999999)
        output =[]
        for s in messages.find({"id": mid}):
            output.append(s)
        if len(output) == 0:
            break
    ins = {"id": mid, "message": message, "sender": user1, "receptant": user2, "lat": lat, "long": lon, "date": time.strftime("%Y-%d-%m")}
    ins = jsonify(ins)
    messages.insert(ins)
    return ins


@app.route('/delete_message', methods=['POST'])
def delete_message():
    mid = request.args.get('mid', None)
    try:
        mid = int(mid)
    except:
        return "Formato inválido, por favor intente nuevamente", 400
    if mid < 0:
        return "Formato inválido, por favor intente nuevamente", 400
    mongodb = client[MONGODATABASE]
    messages = mongodb.messages
    output = []
    for s in messages.find({"id": message}):
        output.append(s)
    if len(output) == 0:
        return "El mensaje con ID = {} no existe.".format(message), 404
    else:
        output = []
        for s in messages.remove({"id": int(mid)}):
            output.append(s)
        return "Mensaje eliminado"

if __name__ == '__main__':
    # Pueden definir su puerto para correr la aplicación
    app.run(port=PORT)
