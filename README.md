
# gameApi

В данном проекте реализованны API функции для работы с базой данных игр, их можно вызвать либо отправляя запросы на http://127.0.0.1:8000//api/, либо при помощи веб интерфейса http://127.0.0.1:8000/



API функции:

-getGame, get запрос, требует id игры, возвращяет полную информацию об игре <br /> 
-addGame, post запрос, требует полную информацию о добавляемой игре, добавляет игру в бд, сообщяет об успехе<br /> 
-delGame, post запрос, требует id игры, удаляет игру из бд, сообщяет об успехе<br /> 
-changeGame, post запрос, требует id игры и ее новую информацию, меняет игру с таким id в бд, сообщяет об успехе<br /> 
-getGamesByGenre, get запрос, требует название жанра, вовзращяет игры, у которых есть указанный жанр<br /> 

