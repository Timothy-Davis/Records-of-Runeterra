import mysql.connector


# The following function will update a record in the records table of the RoR database.
# The function parameters should be formatted like (110, "SummonerName", "first", "record")
def update_record(newValue, newHolder, place, record):
    mydb = mysql.connector.connect(
        host="localhost",
        user="tim",
        passwd="a",
        database="rordb"
    )

    mycursor = mydb.cursor()
    if place == "first":
        sql = "UPDATE records SET first_place_holder = %s, first_place_value = %s WHERE record_name = %s"
        val = (newHolder, newValue, record)
    elif place == "second":
        sql = "UPDATE records SET second_place_holder = %s, second_place_value = %s WHERE record_name = %s"
        val = (newHolder, newValue, record)
    elif place == "third":
        sql = "UPDA++TE records SET third_place_holder = %s, third_place_value = %s WHERE record_name = %s"
        val = (newHolder, newValue, record)
    else:
        print("Plese enter a proper place value.")
        return 1

    mycursor.execute(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "record(s) affected")
