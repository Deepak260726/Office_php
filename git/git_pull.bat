cmdow @ /min

cd "%CD:~0,3%Apache24\htdocs\niya\"

git pull

REM APP VERSION FILE
cd "%CD:~0,3%Apache24\htdocs\niya\storage\app\"

if not exist "version.txt" echo. > "version.txt"

cd "%CD:~0,3%Apache24\htdocs\niya\"

FOR /F "tokens=*" %%g IN ('git describe') do (SET version=%%g)

FOR /F "tokens=*" %%g IN ('git --no-pager log -1 "--format=%%ai"') do (SET timstamp=%%g)

REM FOR /F "tokens=*" %%g IN ('git rev-parse --short HEAD') do (SET commit_id=%%g)

echo %version% %timstamp% > %CD:~0,3%Apache24\htdocs\niya\storage\app\version.txt

cd "%CD:~0,3%Apache24\htdocs\niya\"

REM UPDATE .ENV FILE
php artisan config:clear
php artisan cache:clear

php artisan version:set

REM CONFIG CACHE - DISABLED FOR CLOUD
REM php artisan config:cache

REM VIEW CACHE CLEAR
php artisan view:cache

exit