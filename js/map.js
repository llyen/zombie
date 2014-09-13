var brushSize = ["1x1","3x3","5x5"]; //wielkosc
var brushSizeIndex = 0; //wyborwielkosc
var limitedObjectIndex = 0; //onlyone


/* class definition */
function mapObject(x, y, id, image, solid)
{
    this.x = x;
    this.y = y;
    this.id = id;
    this.image = image;
    this.solid = solid || false;
}
	
function mapField(id, name, image, solid, speed, effect)
{
    this.id = id;
    this.name = name;
    this.image = image;
    this.solid = solid;
    this.speed = speed;
    this.effect = effect;
}

function champion(x, y, x_index, y_index, health, damage)
{
    this.x = x;
    this.y = y;
    this.x_index = x_index;
    this.y_index = y_index;
    this.health = health;
    this.damage = damage;
}

function enemySpawn(x, y, x_index, y_index)
{
    this.x = x;
    this.y = y;
    this.x_index = x_index;
    this.y_index = y_index;
}

function zombie(x, y, health, damage, path) //id, image
{
    this.x = x;
    this.y = y;
    this.health = health;
    this.damage = damage;
    this.path = path;
}

function battleResource(id, name, image, type, damage, damagePattern, effect, count)
{
    this.id = id;
    this.name = name;
    this.image = image;
    this.type = type;
    this.damage = damage;
    this.damagePattern = damagePattern;
    this.effect = effect;
    this.count = count;
}

function turret(x, y, type, damage, damagePattern, effect)
{
	this.x = x;
	this.y = y;
	this.type = type;
	this.damage = damage;
	this.damagePattern = damagePattern;
	this.effect = effect;
}

function mapIndexToXY(index)
{
    switch(index)
    {
        case 0:
            return 0;
        case 1:
            return 32;
        case 2:
            return 64;
        case 3:
            return 96;
        case 4:
            return 128;
        case 5:
            return 160;
        case 6:
            return 192;
        case 7:
            return 224;
        case 8:
            return 256;
        case 9:
            return 288;
        case 10:
            return 320;
        case 11:
            return 352;
        case 12:
            return 384;
        case 13:
            return 416;
        case 14:
            return 448;
        case 15:
            return 480;
        case 16:
            return 512;
        case 17:
            return 544;
        case 18:
            return 576;
        case 19:
            return 608;
    }
}

/* map objects init */
function init(type)
{
    type = type || 'design';
    
    if(type == 'deploy')
    {
        var player = new champion();
        player.health = playerInfo['health'];
        player.damage = playerInfo['damage'];
    }
    
    var menu = new Array();
    var mapFieldsParams = new Array();
    var battleResourcesImages = new Array();

    for(i = 0; i < mapFields.length; i++)
    {
        if(type == 'design')
            menu[i] = new mapField(mapFields[i]['id'], mapFields[i]['name'], mapFields[i]['image'], mapFields[i]['solid'], mapFields[i]['speed'], mapFields[i]['effect']);
        mapFieldsParams[mapFields[i]['id']] = new Array();
        mapFieldsParams[mapFields[i]['id']]['image'] = mapFields[i]['image'];
        mapFieldsParams[mapFields[i]['id']]['solid'] = (mapFields[i]['solid'] == 1) ? true : false;
    }

    
    if(type == 'deploy')
    {
        for(i = 0; i < battleResources.length; i++)
        {
            menu[i] = new battleResource(battleResources[i]['params']['id'], battleResources[i]['params']['name'], battleResources[i]['params']['img'] + '_32x32px', battleResources[i]['params']['type'], battleResources[i]['params']['dmg'], battleResources[i]['params']['dmgPattern'], battleResources[i]['params']['effect'], battleResources[i]['count']);
            battleResourcesImages[battleResources[i]['params']['id']] = battleResources[i]['params']['img'];
        }
    }
    
    
    var stage = new createjs.Stage("map");
    stage.enableMouseOver(50);
    var mapSize = 400; //ile
    var pieces = new Array(); //p
    var resources = new Array();
    var resourcesCounter = new Array();
    var resourcesLayer = new Array();
    var enemySpawns = new Array();
    var zombies = new Array();
	var turrets = new Array();
    window.wave = 1;
	var step_x = 0;
	var step_y = 0;
	var count_x = 0; //liczx
    var count_y = 0;
    var mapMatrix = new Array();
    var mapMatrixRow = new Array();
	for(i = 0; i < mapSize; i++)
	{
        if(type=='deploy' && map[i] == 8)
        {
            player.x = step_x;
            player.y = step_y;
            player.x_index = count_x;
            player.y_index = count_y;
        }
        
        if(map[i] == 7)
            enemySpawns.push(new enemySpawn(step_x, step_y, count_x, count_y));
            
		pieces[i] = new mapObject(step_x, step_y, map[i], mapFieldsParams[map[i]]['image'], mapFieldsParams[map[i]]['solid']);
        
        if(pieces[i].solid == 1)
            mapMatrixRow[count_x] = 0;
        else
            mapMatrixRow[count_x] = 1;
        
        count_x++;
        if(count_x == 20)
        {
            mapMatrix[count_y] = mapMatrixRow;
            mapMatrixRow = new Array();
			step_x = 0;
			step_y += 32;
			count_x = 0;
            count_y++;
		}
		else
		{
			step_x += 32;
		}
	}
    
    if(type == 'deploy')
        var mapGraph = new Graph(mapMatrix);

    /* map layer */
    var layer = new Array();

	for(i = 0; i < mapSize; i++)
    {
        layer[i] = new createjs.Bitmap(objectsImagesUrl + pieces[i].image + '.png');
        layer[i].x = pieces[i].x;
        layer[i].y = pieces[i].y;
        layer[i].addEventListener('mousedown', handleMouseDown);
        layer[i].addEventListener('mouseover', handleMouseOver);
        stage.addChild(layer[i]);
    }
	
    /* panel */
    var panel = new createjs.Container(); //leftmenu
    panel.x = 640;
    var panelBackground = new createjs.Bitmap(imagesUrl + 'map_menu.png');
    panelBackground.addEventListener('mouseover', handleMouseOverPanelBackground);
    panel.addChild(panelBackground);
    
    var panelFields = new Array(); //wyswietl
    var offset_x = 32;
    var offset_y = 32;
    
    if(type == 'design')
    {
        for(i = 0; i < mapFields.length; i++)
        {
            panelFields[i] = new createjs.Bitmap(objectsImagesUrl + menu[i].image + '.png');
            panelFields[i].x = offset_x + 5;
            panelFields[i].y = offset_y + 258;
            offset_x += 40;
            if(offset_x > 256)
            {
                offset_x = 32;
                offset_y += 40;
            }
            panel.addChild(panelFields[i]);
        }
	
        /* panel : current field text */
        var panelCurrentFieldText = new createjs.Text('Aktualne pole:', '20px Arial', '#FFF');
        panelCurrentFieldText.x = 80;
        panelCurrentFieldText.y = 30;
        panel.addChild(panelCurrentFieldText);
    
        /* panel : current field selection, desc */
        var currentField = menu[0];	
	
        stage.onMouseDown = function(e)
        {
            var selected = this.getObjectsUnderPoint(e.stageX, e.stageY);
            for(i = 0; i < mapFields.length; i++)
            {
                if(panelFields[i].x == selected[0].x && panelFields[i].y == selected[0].y)
                {
                    currentField = menu[i];
                    panel.removeChild(panel.getChildByName('fieldName'), panel.getChildByName('fieldImage'), panel.getChildByName('fieldDescription'));
                    
                    var fieldName = new createjs.Text(currentField.name, '20px Arial', '#FFF');
                    fieldName.x = 80;
                    fieldName.y = 80;
                    fieldName.name = 'fieldName';
                
                    var fieldImage = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                    fieldImage.x = 20;
                    fieldImage.y = 80;
                    fieldImage.name = 'fieldImage';
                
                    // parse boolean values
                    var solid;
                    var effect;
                
                    if(currentField.solid == 0)
                        solid = 'Tak';
                    else
                        solid = 'Nie';
                    
                    if(currentField.effect == 0)
                        effect = 'Brak';
                    else
                        effect = 'Tak'; //other values??
                
                    var fieldDescription = new createjs.Text("Statystyki pola:\n\nPrzechodne:"+solid+"\nEfekt:"+effect+" ", '16px Arial', '#FFF');
                    fieldDescription.x = 80;
                    fieldDescription.y = 120;
                    fieldDescription.name = 'fieldDescription';
                
                    panel.addChild(fieldName, fieldImage, fieldDescription);
                }
            }
        }
			
        /* brush : size select */
        var brushSizeText = new createjs.Text('Wielkość pędzla: '+brushSize[brushSizeIndex], '30px Arial', '#FFF');
        var brushSizeButton = new createjs.Shape();
        brushSizeButton.graphics.beginFill('rgba(255, 255, 255, 0.01)').drawRect(10, 540, 280, 40);
        brushSizeText.x = 10;
        brushSizeText.y = 550;
        brushSizeText.name = 'brushSizeText';
        brushSizeText.addEventListener('mousedown', handleMouseDownBrushSizeTextAndButton);
        brushSizeButton.addEventListener('mousedown', handleMouseDownBrushSizeTextAndButton);
        panel.addChild(brushSizeText, brushSizeButton);
    
        /* map : save button */
        var mapSaveText = new createjs.Text('Zapisz mapę', '40px Arial', '#FFF');
        var mapSaveButton = new createjs.Shape();
        mapSaveButton.graphics.beginFill('rgba(255, 255, 255, 0.01)').drawRect(40, 590, 280, 40);
        mapSaveText.x = 40;
        mapSaveText.y = 600;
        mapSaveText.name = 'mapSaveText';
        mapSaveText.addEventListener('mousedown', handleMouseDownMapSaveTextAndButton);
        mapSaveButton.addEventListener('mousedown', handleMouseDownMapSaveTextAndButton);
        panel.addChild(mapSaveText, mapSaveButton);
    }
    
    if(type == 'deploy')
    {
        var panelFieldsBackgrounds = Array();
        for(i = 0; i < battleResources.length; i++)
        {
            if(menu[i].count > 0)
            {
                panelFields[i] = new createjs.Bitmap(objectsImagesUrl + menu[i].image + '.png');
                panelFields[i].x = offset_x + 5;
                panelFields[i].y = offset_y + 258;
                panelFieldsBackgrounds[i] = new createjs.Bitmap(objectsImagesUrl + 'trawa.png');
                panelFieldsBackgrounds[i].x = panelFields[i].x;
                panelFieldsBackgrounds[i].y = panelFields[i].y;
                offset_x += 40;
                if(offset_x > 256)
                {
                    offset_x = 32;
                    offset_y += 40;
                }
                panel.addChild(panelFieldsBackgrounds[i], panelFields[i]);
            }
        }
	
        /* panel : current object text */
        var panelCurrentFieldText = new createjs.Text('Aktualny obiekt:', '20px Arial', '#FFF');
        panelCurrentFieldText.x = 80;
        panelCurrentFieldText.y = 30;
        panel.addChild(panelCurrentFieldText);
    
        /* panel : current field selection, desc */
        var currentField = menu[0];
        
        stage.onMouseDown = function(e)
        {
            var selected = this.getObjectsUnderPoint(e.stageX, e.stageY);
            for(i = 0; i < battleResources.length; i++)
            {
                if(menu[i].count > 0)
                {
                    if(panelFields[i].x == selected[0].x && panelFields[i].y == selected[0].y)
                    {
                        currentField = menu[i];
                        panel.removeChild(panel.getChildByName('fieldName'), panel.getChildByName('fieldImageBackground'), panel.getChildByName('fieldImage'), panel.getChildByName('fieldDescription'));
                    
                        if(currentField.name.length < 25)
						{
							var fieldName = new createjs.Text(currentField.name, "20px Arial", "#FFF");
						}
						else
							var fieldName = new createjs.Text(currentField.name.substr(0, 20)+"...", "18px Arial", "#FFF");
                    
                        fieldName.x = 80;
                        fieldName.y = 80;
                        fieldName.name = 'fieldName';
                
                        var fieldImageBackground = new createjs.Bitmap(objectsImagesUrl + 'trawa.png');
                        fieldImageBackground.x = 20;
                        fieldImageBackground.y = 80;
                        fieldImageBackground.name = 'fieldImageBackground';
                
                        var fieldImage = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                        fieldImage.x = 20;
                        fieldImage.y = 80;
                        fieldImage.name = 'fieldImage';
                
                        // parse boolean values
                        var effect;
                        
                        if(currentField.effect == 0)
                            effect = 'Brak';
                        else
                            effect = 'Tak'; //other values??
                
                        var fieldDescription = new createjs.Text("Statystyki obiektu:\n\nTyp: "+currentField.type+"\nObrażenia: "+currentField.damage+"\nEfekt: "+effect+"\nDostępna ilość: "+currentField.count+" ", '16px Arial', '#FFF');
                        fieldDescription.x = 80;
                        fieldDescription.y = 120;
                        fieldDescription.name = 'fieldDescription';
                
                        panel.addChild(fieldName, fieldImageBackground, fieldImage, fieldDescription);
                    }
                }
            }
        }
        
        /* begin battle button */
        var beginBattleText = new createjs.Text('Rozpocznij walkę', '28px Arial', '#FFF');
        var beginBattleButton = new createjs.Shape();
        beginBattleButton.graphics.beginFill('rgba(255, 255, 255, 0.01)').drawRect(40, 590, 280, 40);
        beginBattleText.x = 40;
        beginBattleText.y = 600;
        beginBattleText.name = 'beginBattleText';
        beginBattleText.addEventListener('mousedown', handleMouseDownBeginBattleTextAndButton);
        beginBattleButton.addEventListener('mousedown', handleMouseDownBeginBattleTextAndButton);
        panel.addChild(beginBattleText, beginBattleButton);
    }
        
    /* stage : panel */
	stage.addChild(panel);		

    /* brush : hint fields */
    var hintFields = new Array();
    hintFields['1x1'] = new createjs.Shape();
    hintFields['1x1'].graphics.beginFill('rgba(255, 255, 255, 0.5)').drawRect(1, 1, 32, 32);
    hintFields['1x1'].visible = false;
    hintFields['3x3'] = new createjs.Shape();
    hintFields['3x3'].graphics.beginFill('rgba(255, 255, 255, 0.5)').drawRect(-10, -10, 96, 96);
    hintFields['3x3'].visible = false;
    hintFields['5x5'] = new createjs.Shape();
    hintFields['5x5'].graphics.beginFill('rgba(255, 255, 255, 0.5)').drawRect(-10, -10, 160, 160);
    hintFields['5x5'].visible = false;
	stage.addChild(hintFields['1x1'], hintFields['3x3'], hintFields['5x5']);
	
    /* battle: next turn */
    function nextWave()
    {
        var playerPosition = mapGraph.nodes[player.y_index][player.x_index];
        for(i = 0; i < enemySpawns.length; i++)
        {
            var enemyPosition = mapGraph.nodes[enemySpawns[i].y_index][enemySpawns[i].x_index];
            var path = astar.search(mapGraph.nodes, enemyPosition, playerPosition, {diagonal: true, closest: true});
            zombies.push(new zombie(enemySpawns[i].x, enemySpawns[i].y, 50*wave, 30*wave, path));
            var sprite = new createjs.Bitmap(objectsImagesUrl + 'zombie1.png'); //image!!!
            sprite.x = enemySpawns[i].x;
            sprite.y = enemySpawns[i].y;
            sprite.name = 'zombieSprite_'+sprite.x+'_'+sprite.y;
            stage.addChild(sprite);
        }
        
        wave++;
    }
    
    function moveEnemy(enemy, enemyId)
    {
		//console.log(enemy);
        if(enemy.path[0])
        {
			var log = panel.getChildByName('battleLog').getChildByName('log');

			if(logLimit <= 0)
			{
				panel.getChildByName('battleLog').removeChild(log);
				var log = new createjs.Text("\n", '11px Arial', '#FFF');
				log.name = 'log';
				panel.getChildByName('battleLog').addChild(log);
			}
			
			if(turrets.length > 0)
			{	
				for(t = 0; t < turrets.length; t++)
				{
					if(turrets[t] != undefined)
					{
						if(enemy.x >= turrets[t].x - 64 && enemy.x <= turrets[t].x + 64 && enemy.y >= turrets[t].y - 64 && enemy.y <= turrets[t].y + 64)
						{
							var dmgp_x = 2;
							var dmgp_y = 3;//2, 17;
														
							if(enemy.y >= turrets[t].y - 64 && enemy.y < turrets[t].y - 32)
								dmgp_y = 1;//0, 15;
							if(enemy.y >= turrets[t].y - 32 && enemy.y < turrets[t].y)
								dmgp_y = 2;//1, 16;
							if(enemy.y > turrets[t].y && enemy.y <= turrets[t].y + 32)
								dmgp_y = 4;//3, 18;
							if(enemy.y > turrets[t].y + 32 && enemy.y <= turrets[t].y + 64)
								dmgp_y = 5;//4, 19;
						
							if(enemy.x >= turrets[t].x - 64 && enemy.x < turrets[t].x - 32)
								dmgp_x = 0;
							if(enemy.x >= turrets[t].x - 32 && enemy.x < turrets[t].x)
								dmgp_x = 1;
							if(enemy.x > turrets[t].x && enemy.x <= turrets[t].x + 32)
								dmgp_x = 3;
							if(enemy.x > turrets[t].x + 32 && enemy.x <= turrets[t].x + 64)
								dmgp_x = 4;
														
							var turretDamage = turrets[t].damage * turrets[t].damagePattern[dmgp_y][dmgp_x]/100;
							enemy.health -= turretDamage;
							log.text += "Element obronny zadał przeciwnikowi " + turretDamage + " obrażeń\n\n";
							logLimit--;
						}
					}
				}
			}
			
			if(mapIndexToXY(enemy.path[0].y) == player.x && mapIndexToXY(enemy.path[0].x) == player.y)
			{
				//atak na gracza, atak na zombie, logi
				enemy.health -= player.damage;
				log.text += "Gracz zadał przeciwnikowi " + player.damage + " obrażeń\n\n";
				logLimit--;
				
				if(enemy.health <= 0)
				{
					log.text += "Gracz zabił przeciwnika!\n\n";
					logLimit--;
					stage.removeChild(stage.getChildByName('zombieSprite_'+enemy.x+'_'+enemy.y));
					zombies.splice(enemyId, 1);
				}
				
				player.health -= enemy.damage;
				log.text += "Przeciwnik zadał graczowi " + enemy.damage + " obrażeń\n\n";
				logLimit--;
				stage.removeChild(stage.getChildByName('playerHP'));
		        var playerHP = new createjs.Text(player.health, '10px Arial', '#FFF');
				playerHP.x = player.x + 5;
				playerHP.y = (player.y == 0) ? 40: player.y - 10;
				playerHP.name = 'playerHP';
				stage.addChild(playerHP);
			}
			else
			{
				stage.removeChild(stage.getChildByName('zombieSprite_'+enemy.x+'_'+enemy.y));
				enemy.x = mapIndexToXY(enemy.path[0].y);
				enemy.y = mapIndexToXY(enemy.path[0].x);
				enemy.path.shift();
				var sprite = new createjs.Bitmap(objectsImagesUrl + 'zombie1.png');
				sprite.x = enemy.x;
				sprite.y = enemy.y;
				sprite.name = 'zombieSprite_'+enemy.x+'_'+enemy.y;
				stage.addChild(sprite);
			}
			
			if(enemy.health <= 0)
			{
				log.text += "Element obronny zabił przeciwnika!\n\n";
				logLimit--;
				stage.removeChild(stage.getChildByName('zombieSprite_'+enemy.x+'_'+enemy.y));
				zombies.splice(enemyId, 1);
			}
        }
    }
    
    /* panel : mouse over */
    function handleMouseOverPanelBackground(event)
    {
        hintFields['1x1'].visible = false;
        hintFields['3x3'].visible = false;
        hintFields['5x5'].visible = false;
    }
    
    /* brush : mouse down */
    function handleMouseDownBrushSizeTextAndButton(event)
    {
        panel.removeChild(panel.getChildByName('brushSizeText'));
        if(brushSizeIndex < 2)
            brushSizeIndex += 1;
        else
            brushSizeIndex = 0;
        
        var brushSizeText = new createjs.Text('Wielkość pędzla: '+brushSize[brushSizeIndex], '30px Arial', '#FFF');
        brushSizeText.x = 10;
        brushSizeText.y = 550;
        brushSizeText.name = 'brushSizeText';
        brushSizeText.addEventListener('mousedown', handleMouseDownBrushSizeTextAndButton);
        panel.addChild(brushSizeText);
    }
    
    /* map : mouse down */
    function handleMouseDownMapSaveTextAndButton(event)
    {
        var map = '';
        
        for(i = 0; i < mapSize; i++)
        {
            map += pieces[i].id+'x';
        }
        
        $.ajax({
            url: 'saveMap',
            type: 'post',
            data: { map: map },
            dataType: 'json',
            async: true,
            success: function(response){
                alert('Zapisano mapę.');
            },
        });
    }
    
    /* begin battle : mouse down */
    function handleMouseDownBeginBattleTextAndButton(event)
    {
        /* remove panel elements */
        panel.removeAllChildren();
        panel.addChild(panelBackground);
        
        for(i = 0; i < mapSize; i++)
            layer[i].removeAllEventListeners();
        
        var playerHP = new createjs.Text(player.health, '10px Arial', '#FFF');
        playerHP.x = player.x + 5;
        playerHP.y = (player.y == 0) ? 40: player.y - 10;
		playerHP.name = 'playerHP';
        stage.addChild(playerHP);
        
        var battleLogText = new createjs.Text('Przebieg walki:', '18px Arial', '#FFF');
        battleLogText.x = 80;
        battleLogText.y = 30;
        panel.addChild(battleLogText);
        
        var battleLog = new createjs.Container();
        battleLog.x = 10;
        battleLog.y = 50;
		battleLog.name = 'battleLog';
        panel.addChild(battleLog);
		
        /* ticker */
        //createjs.Ticker.setFPS(24);
        createjs.Ticker.setInterval(500);
        createjs.Ticker.setPaused(false);
        
        /* battle : begin */
        nextWave();
		
		var log = new createjs.Text("\n", '11px Arial', '#FFF');
		log.name = 'log';
		battleLog.addChild(log);
		window.logLimit = 25;
    }
    
	/* next wave : mouse down */
    function handleMouseDownNextWaveTextAndButton(event)
    {
		panel.removeChild(panel.getChildByName('nextWaveText'), panel.getChildByName('nextWaveButton'));
        var battleLogText = new createjs.Text('Przebieg walki:', '18px Arial', '#FFF');
        battleLogText.x = 80;
        battleLogText.y = 30;
        panel.addChild(battleLogText);
        
        var battleLog = new createjs.Container();
        battleLog.x = 10;
        battleLog.y = 50;
		battleLog.name = 'battleLog';
        panel.addChild(battleLog);
		
        /* ticker */
        //createjs.Ticker.setFPS(24);
        //createjs.Ticker.setInterval(500);
        createjs.Ticker.setPaused(false);
        
        /* battle : begin */
        nextWave();
		
		var log = new createjs.Text("\n", '11px Arial', '#FFF');
		log.name = 'log';
		battleLog.addChild(log);
		window.logLimit = 25;
    }
	
    /* layer : mouse over, mouse down */
    		
	function handleMouseOver(event) 
	{
		var target = event.target;
				
		if(brushSize[brushSizeIndex] == '1x1')
		{
			hintFields['1x1'].visible = true;
			hintFields['1x1'].x = target.x;
			hintFields['1x1'].y = target.y;
		}
		
		if(brushSize[brushSizeIndex] == '3x3')
		{
			hintFields['3x3'].visible = true;
			hintFields['3x3'].x = target.x-22;
			hintFields['3x3'].y = target.y-22;
		}
   	
    	if(brushSize[brushSizeIndex] == '5x5')
		{
			hintFields['5x5'].visible = true;
			hintFields['5x5'].x = target.x-54;
			hintFields['5x5'].y = target.y-54;
		}
	}

    
    function handleMouseDown(event)
    {
	    var target = event.target;
				
        for(i = 0; i < mapSize; i++)
		{
            if(type == 'design')
            {
                if(pieces[i].x == target.x && pieces[i].y == target.y)
                { 	
                    if(currentField.id == 8)
                	{
                		for(j = 0; j < mapSize; j++)
                		{
                			if(pieces[j].image == 'cw')
                			{
                				limitedObjectIndex = j;
                			}
                		}
        
                		pieces[i].id = currentField.id;      
                		pieces[i].image = currentField.image;  
            
                        stage.removeChild(layer[i]);
                		layer[i] = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                		layer[i].x = pieces[i].x;
                		layer[i].y = pieces[i].y;
                		layer[i].addEventListener('mousedown', handleMouseDown);
                		stage.addChild(layer[i]);

                		if(limitedObjectIndex != 0)
                		{
                			pieces[limitedObjectIndex].id = 0;      
                			pieces[limitedObjectIndex].image = 'skala.png';
                        
                			stage.removeChild(layer[limitedObjectIndex]);
                			layer[limitedObjectIndex] = new createjs.Bitmap(objectsImagesUrl + 'skala.png');
                			layer[limitedObjectIndex].x = pieces[limitedObjectIndex].x
                            layer[limitedObjectIndex].y = pieces[limitedObjectIndex].y
                            layer[limitedObjectIndex].addEventListener('mousedown', handleMouseDown);
                            stage.addChild(layer[limitedObjectIndex]);
                		}
                    }
                
                	if(currentField.id == 7 && (pieces[i].y == 0 || pieces[i].x == 0 || pieces[i].y == 608 || pieces[i].x == 608))
                	{
                		pieces[i].id = currentField.id;      
                		pieces[i].image = currentField.img;  
        
                		stage.removeChild(layer[i]);
                		layer[i] = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                		layer[i].x = pieces[i].x;
                		layer[i].y = pieces[i].y;
                		layer[i].addEventListener('mousedown', handleMouseDown);
                		stage.addChild(layer[i]);
                	}	
                	else
                	{
                		if(brushSize[brushSizeIndex] == '1x1' && currentField.id != 7 && currentField.id != 8)
                		{
                            pieces[i].id = currentField.id;      
                			pieces[i].image = currentField.img;  
			  
                			stage.removeChild(layer[i]);
                			layer[i] = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                			layer[i].x = pieces[i].x;
                			layer[i].y = pieces[i].y;
                			layer[i].addEventListener('mousedown', handleMouseDown);
                			stage.addChild(layer[i]);
                		}
						
                		if(brushSize[brushSizeIndex] == '3x3' && currentField.id != 7 && currentField.id != 8)
                		{
                			var lock = 0; //ZL
                			var tempSize = [-21, -1, 19, -20, 0, 20, -19, 1, 21]; //wielkosctab
                			var forbiddenFields = [0, 20, 40, 60, 80, 100, 120, 140, 160, 180, 200, 220, 240, 260, 280, 300, 320, 340, 360, 380, 400]; //zakazaneL
                			for(k = 0; k < 20; k++)
                			{
                				if(i == forbiddenFields[k] || i == forbiddenFields[k]-1)
                					lock = 1;
                			}
                			
                            if(lock == 0)
                			{
                				var safetyVarFirst = 0;
                				var safetyVarSecond = 9;
                			}
						
                            if(lock == 1)
                			{
                				if(i%10 == 0)
                				{
                					var safetyVarFirst = 3;
                					var safetyVarSecond = 9;
                				}
                            
                				if(i%10 != 0)
                				{
                					var safetyVarFirst = 0;
                					var safetyVarSecond = 6;
                				}
                			}
                        
                			for(l = safetyVarFirst; l < safetyVarSecond; l++)
                			{
                				if(typeof pieces[i+tempSize[l]] != 'undefined')
                				{
                					pieces[i + tempSize[l]].id = currentField.id;      
            						pieces[i + tempSize[l]].image = currentField.image;
								
                                    stage.removeChild(layer[i + tempSize[l]]);
            						layer[i + tempSize[l]] = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
            						layer[i + tempSize[l]].x = pieces[i + tempSize[l]].x;
            						layer[i + tempSize[l]].y = pieces[i + tempSize[l]].y;
            						layer[i + tempSize[l]].addEventListener('mousedown', handleMouseDown);
            						stage.addChild(layer[i + tempSize[l]]);
                                }
        					}
        				}
    
                        if(brushSize[brushSizeIndex] == '5x5' && currentField.id != 7 && currentField.id != 8)
        				{
        					var lock = 0; //ZL
        					var tempSize = [-42, -22, -2, 18, 38, -41, -21, -1, 19, 39, -40, -20, 0, 20, 40, -39, -19, 1, 21, 41, -38, -18, 2, 22, 42]; //wielkosctab
        					var forbiddenFields = [0, 1, 19, 20, 21, 39, 40, 41, 59, 60, 61, 79, 80, 81, 99, 100, 101, 119, 120, 121, 139, 140, 141, 159, 160, 161, 179, 180, 181, 199, 200, 201, 219, 220, 221, 239, 240, 241, 259, 260, 261, 279, 280, 281, 299, 300, 301, 319, 320, 321, 339, 340, 341, 359, 360, 361, 379, 380, 381, 399, 400]; //zakazaneL
        					for(k = 0; k < 60; k++)
        					{
        						if(i == forbiddenFields[k] || i == forbiddenFields[k]-1)
        							lock = 1;
        					}
						
                            if(lock == 0)
    						{
    							var safetyVarFirst = 0;
    							var safetyVarSecond = 25;
    						}
    						
                            if(lock == 1)
    						{
    							if(i%10 == 0)
    							{
    								var safetyVarFirst = 10;
    								var safetyVarSecond = 25;
    							}
		
    							if(i%10 == 1)
    							{
    								var safetyVarFirst = 5;
    								var safetyVarSecond = 25;
    							}
								
    							if(i%10 == 8)
    							{
    								var safetyVarFirst = 0;
    								var safetyVarSecond = 20;
    							}
							
    							if(i%10 == 9)
    							{
    								var safetyVarFirst = 0;
    								var safetyVarSecond = 15;
    							}
    						}
                        
    						for(l = safetyVarFirst; l < safetyVarSecond; l++)
    						{
    							if(typeof pieces[i+tempSize[l]] != 'undefined')
        						{
                    				pieces[i + tempSize[l]].id = currentField.id;      
                    				pieces[i + tempSize[l]].image = currentField.image;
                    				
                                    stage.removeChild(layer[i + tempSize[l]]);
                    				layer[i + tempSize[l]] = new createjs.Bitmap(objectsImagesUrl + currentField.image + '.png');
                    				layer[i + tempSize[l]].x = pieces[i + tempSize[l]].x;
                    				layer[i + tempSize[l]].y = pieces[i + tempSize[l]].y;
                    				layer[i + tempSize[l]].addEventListener('mousedown', handleMouseDown);
                    				stage.addChild(layer[i + tempSize[l]]);
                                }
                    		}
                        }
                    }	
                }
            }
            else
            {
                if(pieces[i].x == target.x && pieces[i].y == target.y)
                {
                    //if pieces[i].id == ? clear path to player!
                    
                    if(resourcesCounter[currentField.id] == undefined)
                            resourcesCounter[currentField.id] = 1;
                    
                    if(resources[i] != undefined && resources[i].id == currentField.id)
                    {
                        delete resources[i];
                        while(stage.getChildByName('damagePattern_' + currentField.id + '_' + i) != null)
                            stage.removeChild(stage.getChildByName('damagePattern_' + currentField.id + '_' + i));
                        turrets.splice(i, 1);
						stage.removeChild(resourcesLayer[i]);
                        resourcesCounter[currentField.id]--;
                        continue;
                    }
                    
                    if(resourcesCounter[currentField.id] <= currentField.count)
                    {
                        //pieces[i].effect ...
                        if(resources[i] != undefined)
                        {
                            resourcesCounter[resources[i].id]--;
                            while(stage.getChildByName('damagePattern_' + resources[i].id + '_' + i) != null)
                                stage.removeChild(stage.getChildByName('damagePattern_' + resources[i].id + '_' + i));
                        }
                        resources[i] = currentField;
                        stage.removeChild(resourcesLayer[i]);
                        resourcesLayer[i] = new createjs.Bitmap(objectsImagesUrl + resources[i].image + '.png');
                        resourcesLayer[i].x = pieces[i].x;
                        resourcesLayer[i].y = pieces[i].y;
                        resourcesLayer[i].addEventListener(handleMouseDown);
						
						turrets[i] = new turret(resourcesLayer[i].x, resourcesLayer[i].y, resources[i].type, resources[i].damage, resources[i].damagePattern, resources[i].effect);
						
                        stage.addChild(resourcesLayer[i]);
                        
                        resourcesCounter[resources[i].id]++;
                        
                        /* damage pattern */
                        var offset_x = 0;
                        var offset_y = 0;
                        for(var j in resources[i].damagePattern)
                        {
                            for(var k in resources[i].damagePattern[j])
                            {
                                var tmp_x = pieces[i].x - 64 + offset_x;
                                var tmp_y = pieces[i].y - 64 + offset_y;
                                if((tmp_x >= 0 && tmp_x < 640) && (tmp_y >= 0 && tmp_y < 640))
                                {
                                    var shp = new createjs.Shape();
                                    shp.graphics.beginFill("#9977ff").drawRect(tmp_x, tmp_y, 32, 32);
                                    shp.alpha = 0.4 * resources[i].damagePattern[j][k]/100;
                                    shp.name = 'damagePattern_' + resources[i].id + '_' + i;
                                    stage.addChild(shp);
                                }
                                offset_x += 32;
                            }
                            offset_x = 0;
                            offset_y += 32;
                        }
                    }
                    else
                    {
                        alert('Limit dostępnych obiektów został wykorzystany.');
                    }
                }
            }
        }
    }

    createjs.Ticker.addEventListener('tick', tick);
    createjs.Ticker.setPaused(true);
    
	function tick()
    {
        if(!createjs.Ticker.getPaused())
            if(player.health > 0)
			{
				if(zombies.length > 0)
				{
					for(z = 0; z < zombies.length; z++)
					    moveEnemy(zombies[z], z);
				}
				else
				{
					if(wave <= 5)
					{
						createjs.Ticker.setPaused(true);
		
						/* remove panel elements */
						panel.removeAllChildren();
						panel.addChild(panelBackground);
		
						/* next wave button */
						var nextWaveText = new createjs.Text('Następna tura', '28px Arial', '#FFF');
						var nextWaveButton = new createjs.Shape();
						nextWaveButton.graphics.beginFill('rgba(255, 255, 255, 0.01)').drawRect(40, 590, 280, 40);
						nextWaveButton.name = 'nextWaveButton';
						nextWaveText.x = 40;
						nextWaveText.y = 600;
						nextWaveText.name = 'nextWaveText';
						nextWaveText.addEventListener('mousedown', handleMouseDownNextWaveTextAndButton);
						nextWaveButton.addEventListener('mousedown', handleMouseDownNextWaveTextAndButton);
						panel.addChild(nextWaveText, nextWaveButton);	
					}
					else
					{
						//win
						createjs.Ticker.setPaused(true);
						var winText = new createjs.Text("Wygrana!", "72px Arial", "#FFF");
						winText.x = 150;
						winText.y = 150;
						stage.addChild(winText);
					}
				}
			}
			else
			{
				//lost
				createjs.Ticker.setPaused(true);
				var lostText = new createjs.Text("Przegrana!", "72px Arial", "#FFF");
                lostText.x = 150;
                lostText.y = 150;
                stage.addChild(lostText);
			}
		stage.update();
	}
}	