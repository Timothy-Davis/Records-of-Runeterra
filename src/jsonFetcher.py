import json
import urllib.request

GAME_RESULT_URL = "http://localhost:21337/game-result"
ACTIVE_DECK_URL = "http://localhost:21337/active-deck"
EXPEDITIONS_STATE_URL = "http://localhost:21337/active-deck"

"""
    Until Legends of Runeterra is re-released, we have no way of polling the 
    API. So the code I will write from here until my next comment is purely
    theoretical. 

    I will have three operations in this particular module: poll_game_result, 
    poll_active_deck, and poll_expeditions_state. These three operations 
    will be called as needed by our main module, which will also be using the 
    dbUpdate module to keep the data in our database up to date.
    
"""


def poll_game_result():
    with urllib.request.urlopen(GAME_RESULT_URL) as url:
        game_result_data = json.loads(url.read().decode())
        return game_result_data


def poll_active_deck():
    with urllib.request.urlopen(ACTIVE_DECK_URL) as url:
        active_deck_data = json.loads(url.read().decode())
        return active_deck_data


def poll_expeditions_state():
    with urllib.request.urlopen(EXPEDITIONS_STATE_URL) as url:
        expeditions_state_data = json.loads(url.read().decode())
        return expeditions_state_data
