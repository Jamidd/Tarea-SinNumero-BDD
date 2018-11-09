from flask import Flask, jsonify, abort, request
from pymongo import MongoClient
import sys


app = Flask(__name__)

MONGODATABASE = "test"
MONGOSERVER = "localhost"
MONGOPORT = 27017

client = MongoClient(MONGOSERVER, MONGOPORT)


def remove_id(obj):
    for item in obj:
        item.pop("_id", None)


@app.route('/user/<int:user>', methods=['GET'])
def sender(user):
    mongodb = client[MONGODATABASE]
    users = mongodb.usuarios
    messages = mongodb.messages
    user_output = list()
    message_output = list()
    output = dict()
    for s in users.find({"id": user}):
        user_output.append(s)
    if len(user_output) == 0:
        return jsonify(), 404
    else:
        remove_id(user_output)
        output.update({"user": user_output[0]})
        for s in messages.find({"sender": user}):
            message_output.append(s)
        remove_id(message_output)
        output.update({"messages": message_output})
        return jsonify(output), 200


if __name__ == '__main__':
    # Pueden definir su puerto para correr la aplicación
    app.run(port=5000)
