import mysql.connector

# #### Constants #### #
HOST = "localhost"
USER = "tim"
PASSWORD = "a"
USER_DB = "ror_users"
RECORDS_DB = "ror_records"
CARD_DB = "ror_cards"
FACTION_DB = "ror_factions"
DECK_DB = "ror_decks"


# The following function will update a record in the records table of the RoR database.
# The function parameters should be formatted like (110, "SummonerName", "first", "record")
def update_record(new_value, new_holder, place, record):
    records = mysql.connector.connect(
        host=HOST,
        user=USER,
        passwd=PASSWORD,
        database=RECORDS_DB
    )

    my_cursor = records.cursor()

    if place == "first":
        sql = "UPDATE records SET third_place_holder = second_place_holder, third_place_value = second_place_value " \
              "WHERE record_name = %s"

        val = (record,)
        my_cursor.execute(sql, val)

        sql = "UPDATE records SET second_place_holder = first_place_holder, second_place_value = first_place_value " \
              "WHERE record_name = %s"

        val = (record,)
        my_cursor.execute(sql, val)

        sql = "UPDATE records SET first_place_holder = %s, first_place_value = %s " \
              "WHERE record_name = %s"

        val = (new_holder, new_value, record)

    elif place == "second":
        sql = "UPDATE records SET third_place_holder = second_place_holder, third_place_value = second_place_value " \
              "WHERE record_name = %s"

        val = (record,)
        my_cursor.execute(sql, val)

        sql = "UPDATE records SET second_place_holder = %s, second_place_value = %s WHERE record_name = %s"

        val = (new_holder, new_value, record)

    elif place == "third":
        sql = "UPDATE records SET third_place_holder = %s, third_place_value = %s WHERE record_name = %s"

        val = (new_holder, new_value, record)

    else:
        print("Please enter a proper place value.")
        return 1

    my_cursor.execute(sql, val)
    records.commit()
