<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Web API</title>



        <style>
            .zone{
                display:none;
            }
            body {
                font-family: 'Nunito', sans-serif;
            }
            .centerBlock{
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                min-height: 100vh;
                background-color: #333333;
                color: white;
            }
            .genre{
                display: block;
                margin: 20px auto;

            }
        </style>
        <script src='/jquery-3.7.1.min.js'></script>
    </head>
    <body class="centerBlock">
        <div>
            Выберите нужное дейстивие
            <div>
                <label ><input type="radio" name="radgroup" value="1" onchange="selectOption(this)">
                    Добавить игру
                </label>
                <label ><input type="radio" name="radgroup" value="2" onchange="selectOption(this)">
                    Получить игру
                </label>
                <label ><input type="radio" name="radgroup" value="3" onchange="selectOption(this)">
                    Отредактировать игру
                </label>
                <label ><input type="radio" name="radgroup" value="4" onchange="selectOption(this)">
                    Удалить игру
                </label>
                <label ><input type="radio" name="radgroup" value="5" onchange="selectOption(this)">
                    Получить игры по категории
                </label>
            </div>

            <div id="zone1" class="zone" >
                <p>Заполните все поля для добавления игры</p>
                <div>
                    <label>Название игры:</label>
                    <input type='text' id="gameName">
                </div>
                <div>
                    <label>Разработчик игры:</label>
                    <input type='text' id="gameDev">
                </div>
                <div>
                    <label>Категории</label>
                    <div id="genreList">
                        <input class="genre" name="addGameGenres">
                    </div>
                    <button name="add"  onclick="addGenre(this)">Добавить жанр</button>
                </div>
            </div>

            <div id="zone2" class="zone">
                <p>Введите целое число в поле ниже, что бы получить информацию об игре</p>
                <input type='text' id="gameIdFind">
            </div>

            <div id="zone3" class="zone">
                <p>Заполните все поля для редактирования игры</p>
                <div>
                    <label>ID игры:</label>
                    <input type='text' id="redactGameId">
                </div>
                <div>
                    <label>Новое название игры:</label>
                    <input type='text' id="redactGameName">
                </div>
                <div>
                    <label>Новый разработчик игры:</label>
                    <input type='text' id="redactGameDev">
                </div>
                <div>
                    <label>Новые категории</label>
                    <div id="genreList">
                        <input class="genre" name="redactGameGenres">
                    </div>
                    <button name="redact" onclick="addGenre(this)" >Добавить жанр</button>
                </div>
            </div>

            <div id="zone4" class="zone">
                <p>Введите целое число в поле ниже, что бы удалить игру</p>
                <input type='text' id="gameIdDel">
                
                
            </div>

            <div id="zone5" class="zone">
                <p>Введите категорию игр</p>
                <input type='text' id="gameGenreFind">
                
                
            </div>
            <button id="reqButton" onclick="callApi()" style="display:none">Выполнить запрос</button>
            <div id="resultField">

            </div>
        </div>

    </body>

    <script>
        function checkParams(params){
            let check=true

            for(let i=0;i<params.length;i++){
                if (params[i].replace(/\s+/g, '')==''){
                    check =false
                    break
                }
            }
            return check

        }
        function addGenre (elem){
            console.log(elem)
            let newGenre=document.createElement("input")
            newGenre.name=elem.name+"GameGenres"
            newGenre.classList.add("genre")

            elem.parentElement.children[1].append(newGenre)
        }

        function getGame(){
            $.ajax({
                url : '/api/getGame',
                type : 'GET',
                data : {
                    'id' : document.getElementById("gameIdFind").value
                },
                dataType:'json',
                success : function(data) {     
                    console.log(data['genreInfo']) 
                    let result=document.createElement("p")        
                    if ('response' in data){
                        result=data['response']
                        document.getElementById("resultField").innerHTML=result
                    }
                    else{

                        result.innerHTML="Информация об игре:"
                        document.getElementById("resultField").append(result)
                        let name=document.createElement("p")    
                        let dev=document.createElement("p")    
                        let genres=document.createElement("ul")
                        
                        name.innerHTML=data['gameInfo']['gameName']
                        dev.innerHTML=data['gameInfo']['gameDev']

                        for(let i=0;i<data['genreInfo'].length;i++){
                            let genre=document.createElement("li")
                            genre.innerHTML=data['genreInfo'][i]['genre']

                            genres.append(genre)
                        }

                        document.getElementById("resultField").append(name,dev,genres)

                    }
                }
            });

        }
        function getByGenre(){
            
            $.ajax({ 


                url : '/api/getGamesByGenre',
                type : 'GET',
                data : {
                    'genre' : document.getElementById("gameGenreFind").value
                },
                dataType:'json',
                success : function(data) {       
                    
                    if (data.length!=0){
                        for(let i=0;i<data.length;i++){
                            let genre = document.createElement("p")

                            genre.innerHTML=data[i]['gameName']

                            document.getElementById("resultField").append(genre)
                        }
                    }
                    else{
                        document.getElementById("resultField").innerHTML="Нет игр с таким жанром"
                    }
                }
            });

        }
        function delGame(){
            
            $.ajax({
                url : '/api/delGame',
                type : 'POST',
                data : {
                    'id' : document.getElementById("gameIdDel").value
                },
                dataType:'text',
                success : function(data) {              
                    document.getElementById("resultField").innerHTML=data
                }
            });

        }
        function addGame(){
          
            let genres=[]
            for( let i=0;i<document.getElementsByName("addGameGenres").length;i++){
                if (document.getElementsByName("addGameGenres")[i].value!=""){
                    genres.push(document.getElementsByName("addGameGenres")[i].value)
                }
            }

            $.ajax({
                url : '/api/addGame',
                type : 'POST',
                data : {
                    'gameName' : document.getElementById("gameName").value,
                    'gameDev' : document.getElementById("gameDev").value,
                    'gameGenres' : genres
                },
                dataType:'text',
                success : function(data) {      
                    document.getElementById("resultField").innerHTML=data
                }
            });

        }
        function editGame(){
            
            let genres=[]
            for( let i=0;i<document.getElementsByName("redactGameGenres").length;i++){
                if (document.getElementsByName("redactGameGenres")[i].value!=""){
                    genres.push(document.getElementsByName("redactGameGenres")[i].value)
                }
            }

            $.ajax({
                url : '/api/changeGame',
                type : 'POST',
                data : {
                    'gameId' : document.getElementById("redactGameId").value,
                    'gameName' : document.getElementById("redactGameName").value,
                    'gameDev' : document.getElementById("redactGameDev").value,
                    'gameGenres' : genres
                },
                dataType:'json',
                success : function(data) {              
                    document.getElementById("resultField").innerHTML=data
                }
            });
        }
        function selectOption(elem){
            
            
            $('.zone').css({"display":"none" });
            document.getElementById("zone"+elem.value).style.display="unset"
            document.getElementById("reqButton").style.display="unset"
            document.getElementById("resultField").innerHTML=""

        }
        function callApi(){
            document.getElementById("resultField").innerHTML=""
            let message="Заполните все поля"
            switch (document.querySelector('input[name="radgroup"]:checked').value){
                case '1':
                    if (checkParams([document.getElementById("gameName").value,document.getElementById("gameDev").value])){
                        addGame()
                    }
                    else{
                        alert(message)
                    }
                    break;
                case "2":
                    if(checkParams([document.getElementById("gameIdFind").value])){
                        getGame()
                    }
                    else{
                        alert(message)
                    }
                    break;
                case "3":
                    if(checkParams([document.getElementById("redactGameId").value, document.getElementById("redactGameName").value, document.getElementById("redactGameDev").value])){
                        editGame()
                    }
                    else{
                        alert(message)
                    }
                    
                    break;
                case "4":
                    if(checkParams([document.getElementById("gameIdDel").value])){
                        delGame()
                    }
                    else{
                        alert(message)
                    }
                   
                    break;
                case "5":
                    if(checkParams([document.getElementById("gameGenreFind").value])){
                        getByGenre()
                    }
                    else{
                        alert(message)
                    }
                    break;
                default:
                    alert("Выберите одну из опций")
                    break;
                
            }
        }


    </script>
</html>
