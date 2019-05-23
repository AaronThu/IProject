sqlcmd -S localhost -d master -i "CREATE_SCRIPT.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "Alter_Script_IProject.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "CONVERSIE_RUBRIEKEN_SCRIPT.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "CONVERSIE_LANDEN_SCRIPT.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "INSERT_SCRIPT.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "CREATE Tables voor conversie.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "INSERT_TEST_USERS.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "CONVERSIE_USERS.sql"
sqlcmd -S localhost -d EenmaalAndermaal -i "9800-Auto's, motoren en boten 1.sql" -x
sqlcmd -S localhost -d EenmaalAndermaal -i "9800-Auto's, motoren en boten 2.sql" -x
sqlcmd -S localhost -d EenmaalAndermaal -i "11232-Film en DVD.sql" -x
sqlcmd -S localhost -d EenmaalAndermaal -i "12081-Baby.sql" -x
sqlcmd -S localhost -d EenmaalAndermaal -i "CONVERSIE_VOORWERPEN_SCRIPT.sql"
pause

