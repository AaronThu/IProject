sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "CREATE_SCRIPT.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "Alter_Script_IProject.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "CONVERSIE_RUBRIEKEN_SCRIPT.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "CONVERSIE_LANDEN_SCRIPT.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "INSERT_SCRIPT.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "CREATE Tables voor conversie.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "INSERT_TEST_USERS.sql"
sqlcmd -S mssql2.iproject.icasites.nl -d iproject2 -U iproject2 -P k1kQ2Ynu4M -i "CONVERSIE_USERS.sql"
pause

