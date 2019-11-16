import mysql.connector

# #### Constants #### #
HOST = "localhost"
USER = "tim"
PASSWORD = "a"
DATABASE = "rordb"


def connect_to_db():
    database = mysql.connector.connect(
        host=HOST,
        user=USER,
        passwd=PASSWORD,
        database=DATABASE
    )
    return database


# ### USERS ### #
# Call the following function to add a user to the database ror_users database.
def add_user(new_user):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "INSERT INTO ror_users(summonerName, total_wins, totalGames, longest_expedition," \
          "most_consecutive_expedition_wins, expedition_wins, expedition_games) VALUES (%s, 0, 0, 0, 0, 0, 0)"
    values = (new_user,)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


# Call the following function to update certain values of a user.
def update_user(user_name, parameter):
    database = connect_to_db()
    my_cursor = database.cursor()

    if parameter == "wins":
        sql = "UPDATE ror_users SET total_wins = total_wins+1, totalGames = totalGames+1 WHERE summonerName = %s"

    elif parameter == "longest_expedition":
        sql = "UPDATE ror_users SET longest_expedition = longest_expedition+1 WHERE summonerName = %s"

    elif parameter == "most_consecutive_expedition_wins":
        sql = "UPDATE ror_users SET most_consecutive_expedition_wins = most_consecutive_expedition_wins+1 " \
              "WHERE summonerName = %s"

    elif parameter == "expedition_wins":
        sql = "UPDATE ror_users SET expedition_wins = expedition_wins+1, expedition_games = expedition_games+1 " \
              "WHERE summonerName = %s"

    elif parameter == "total_games":
        sql = "UPDATE ror_users SET totalGames = totalGames+1 WHERE summonerName = %s"

    elif parameter == "expedition_games":
        sql = "UPDATE ror_users SET expedition_games = expedition_games+1 WHERE summonerName = %s"

    else:
        print("A valid attribute was not entered.")
        exit(1)

    values = (user_name,)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


def search_users(user_name):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "SELECT summonerName FROM ror_users WHERE summonerName = %s"
    values = (user_name,)
    my_cursor.execute(sql, values)

    if my_cursor.fetchone() is None:
        return True
    else:
        return False


# ### CARDS ### #
# Call the following function to add cards to the database.
def add_card(card_id, card_name, card_type):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "INSERT INTO ror_cards(cardID, cardName, gamesPlayed, cardType, gamesWon, expeditionGames, expeditionWins) " \
          "VALUES (%s, %s, %s, 0, 0, 0, 0)"
    values = (card_id, card_name, card_type)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


# Call the following function to update a card in the database.
def update_card(card_id, parameter):
    database = connect_to_db()
    my_cursor = database.cursor()

    if parameter == "games_won":
        sql = "UPDATE ror_cards SET gamesWon = gamesWon+1, gamesPlayed = gamesPlayed+1 WHERE cardID = %s"

    elif parameter == "expedition_wins":
        sql = "UPDATE ror_cards SET expeditionWins = expeditionWins+1, expeditionGames = expeditionGames+1" \
              " WHERE cardID = %s"

    elif parameter == "games_played":
        sql = "UPDATE ror_cards SET gamesPlayed = gamesPlayed+1 WHERE cardID = %s"

    elif parameter == "expeditionGames":
        sql = "UPDATE ror_cards SET expeditionGames = expeditionGames+1 WHERE cardID = %s"

    else:
        print ("A valid parameter was not entered")
        exit(1)

    values = (card_id,)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


# Call the following function to search for a user
def search_cards(card_id):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "SELECT cardID FROM ror_cards WHERE cardID = %s"
    values = (card_id,)
    my_cursor.execute(sql, values)

    if my_cursor.fetchone() is None:
        return True
    else:
        return False


# ### DECKS ### #
# Call teh following function to add a deck to the database.
def add_deck(deck_code):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "INSERT INTO ror_decks(deckString, wins, totalGames) VALUES (%s, 0, 0)"
    values = (deck_code,)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


# Call the following function to update a deck in the database.
def update_deck(deck_code, parameter):
    database = connect_to_db()
    my_cursor = database.cursor()

    if parameter == "wins":
        sql = "UPDATE ror_decks SET wins = wins+1, totalGames = totalGames+1  WHERE deckString = %s"

    elif parameter == "total_games":
        sql = "UPDATE ror_decks SET totalGames = totalGames+1 WHERE deckString = %s"

    else:
        print("A valid parameter was not entered")
        exit(1)

    values = (deck_code,)
    my_cursor.execute(sql, values)

    database.commit()
    database.close()


def search_decks(deck_code):
    database = connect_to_db()
    my_cursor = database.cursor()

    sql = "SELECT deckString FROM ror_decks WHERE deckString = %s"
    values = (deck_code,)
    my_cursor.execute(sql, values)

    if my_cursor.fetchone() is None:
        return True
    else:
        return False
