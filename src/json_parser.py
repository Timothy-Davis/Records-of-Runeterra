import json
from src import dbUpdate


# THe following function will add all the cards from the Data Dragon to the database.
def add_all_cards():
    card_json = open('C:/datadragon-set1-en_us/en_us/data/set1-en_us.json', encoding='UTF-8')
    card_data = json.load(card_json)

    for i in range(len(card_data)):
        dbUpdate.add_card(card_data[i]['cardCode'], card_data[i]['name'], card_data[i]['type'])
