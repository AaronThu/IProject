sqlcmd -S localhost -d iproject2 -i "CREATE_SCRIPT.sql"
sqlcmd -S localhost -d iproject2 -i "Alter_Script_IProject.sql"
sqlcmd -S localhost -d iproject2 -i "CONVERSIE_RUBRIEKEN_SCRIPT.sql"
sqlcmd -S localhost -d iproject2 -i "CONVERSIE_LANDEN_SCRIPT.sql"
sqlcmd -S localhost -d iproject2 -i "INSERT_SCRIPT.sql"
sqlcmd -S localhost -d iproject2 -i "CREATE Tables voor conversie.sql"
sqlcmd -S localhost -d iproject2 -i "INSERT_TEST_USERS.sql"
sqlcmd -S localhost -d iproject2 -i "CONVERSIE_USERS.sql"
sqlcmd -S localhost -d iproject2 -i "9800-Auto's, motoren en boten 1.sql" -x
sqlcmd -S localhost -d iproject2 -i "9800-Auto's, motoren en boten 2.sql" -x
sqlcmd -S localhost -d iproject2 -i "11232-Film en DVD.sql" -x
sqlcmd -S localhost -d iproject2 -i "12081-Baby.sql" -x
sqlcmd -S localhost -d iproject2 -i "CONVERSIE_VOORWERPEN_SCRIPT.sql"
pause

