import json
import time
from src import dbUpdate
from src import jsonFetcher
from src.lor_deckcodes import decode


# The following function will add all the cards from the Data Dragon to the database.
def add_all_cards():
    card_json = open('C:/datadragon-set1-en_us/en_us/data/set1-en_us.json', encoding='UTF-8')
    card_data = json.load(card_json)

    for i in range(len(card_data)):
        dbUpdate.add_card(card_data[i]['cardCode'], card_data[i]['name'], card_data[i]['type'])


# The following function will run continuously, once a second, checking to see if the user is in game.
# If they are, we'll use the game result to update the database in relevant ways.
def check_game_state():
    deck_code = None

    while jsonFetcher.poll_active_deck()['DeckCode'] is None:
        print("not in game")
        time.sleep(10)

    while jsonFetcher.poll_active_deck()['DeckCode'] is not None:
        print("in game")
        summoner = jsonFetcher.poll_positional_rectangles()['PlayerName']
        deck_code = jsonFetcher.poll_active_deck()['DeckCode']
        if dbUpdate.search_decks(deck_code) is True:
            dbUpdate.add_deck(deck_code)
        print(summoner, deck_code)
        while jsonFetcher.poll_active_deck()['DeckCode'] is not None:
            time.sleep(3)

    if deck_code is not None and summoner is not None:
        print("post game")
        game_result = jsonFetcher.poll_game_result()['LocalPlayerWon']
        deck = decode.decode_deck(deck_code)

        if game_result:
            for i in range(len(deck)):
                dbUpdate.update_card(deck[i][2:], 'games_won')
            dbUpdate.update_user(summoner, "wins")
            dbUpdate.update_deck(deck_code, "wins")

        else:
            for i in range(len(deck)):
                dbUpdate.update_card(deck[i][2:], 'games_played')
            dbUpdate.update_user(summoner, "total_games")
            dbUpdate.update_deck(deck_code, "total_games")


if __name__ == "__main__":
    check_game_state()
