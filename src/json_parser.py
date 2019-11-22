import json
import time
from src import dbUpdate
from src import jsonFetcher
from src.lor_deckcodes import decode


# The following function will run continuously, once a second, checking to see if the user is in game.
# If they are, we'll use the game result to update the database in relevant ways.
def check_game_state():
    deck_code = None

    while jsonFetcher.poll_active_deck()['DeckCode'] is None:
        print("STATUS: ", "not in game")
        time.sleep(5)

    while jsonFetcher.poll_active_deck()['DeckCode'] is not None:
        print("STATUS: ", "in game")

        summoner = jsonFetcher.poll_positional_rectangles()['PlayerName']
        deck_code = jsonFetcher.poll_active_deck()['DeckCode']

        if dbUpdate.search_decks(deck_code) is True:
            dbUpdate.add_deck(deck_code)

        if dbUpdate.search_users(summoner) is True:
            dbUpdate.add_user(summoner)

        print("SUMMONER: ", summoner, "DECK: ", deck_code)

        while jsonFetcher.poll_active_deck()['DeckCode'] is not None:
            time.sleep(0.1)

    if deck_code is not None and summoner is not None:
        print("STATUS: ", "post game")

        game_result = jsonFetcher.poll_game_result()['LocalPlayerWon']
        deck = decode.decode_deck(deck_code)

        print("STATUS: ", "updating database")
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

        check_game_state()


if __name__ == "__main__":
    dbUpdate.check_cards()
    check_game_state()
