import mysql.connector
from src import json_parser


# The following function will update a record in the records table of the RoR database.
# The function parameters should be formatted like (110, "SummonerName", "first", "record")
def update_record(new_value, new_holder, place, record):
    mydb = mysql.connector.connect(
        host="localhost",
        user="tim",
        passwd="a",
        database="rordb"
    )

    mycursor = mydb.cursor()

    if place == "first":
        sql = "UPDATE records SET third_place_holder = second_place_holder, third_place_value = second_place_value WHERE record_name = %s"
        val = (record,)
        mycursor.execute(sql, val)
        mydb.commit()

        sql = "UPDATE records SET second_place_holder = first_place_holder, second_place_value = first_place_value WHERE record_name = %s"
        val = (record,)
        mycursor.execute(sql, val)

        sql = "UPDATE records SET first_place_holder = %s, first_place_value = %s WHERE record_name = %s"
        val = (new_holder, new_value, record)

    elif place == "second":
        sql = "UPDATE records SET third_place_holder = second_place_holder, third_place_value = second_place_value WHERE record_name = %s"
        val = (record,)
        mycursor.execute(sql, val)

        sql = "UPDATE records SET second_place_holder = %s, second_place_value = %s WHERE record_name = %s"
        val = (new_holder, new_value, record)

    elif place == "third":
        sql = "UPDATE records SET third_place_holder = %s, third_place_value = %s WHERE record_name = %s"
        val = (new_holder, new_value, record)

    else:
        print("Please enter a proper place value.")
        return 1

    mycursor.execute(sql, val)
    mydb.commit()
