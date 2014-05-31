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

function player(x, y, health, damage)
{
    this.x = x;
    this.y = y;
    this.health = health;
    this.damage = damage;
}

function zombie()
{
    
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

/* map objects init */
function init(type)
{
    type = type || 'design';
    
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
    window.pieces = new Array(); //p
                
	var step_x = 0;
	var step_y = 0;
	var count_x = 0; //liczx
					
	for(i = 0; i < mapSize; i++)
	{
		pieces[i] = new mapObject(step_x, step_y, map[i], mapFieldsParams[map[i]]['image'], mapFieldsParams[map[i]]['solid']);
        count_x++;
        if(count_x == 20)
        {
			step_x = 0;
			step_y += 32;
			count_x = 0;
		}
		else
		{
			step_x += 32;
		}
	}

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
                        solid = 'Nie';
                    else
                        solid = 'Tak';
                    
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
                
            }
        }
    }

	createjs.Ticker.addListener(stage);

	function tick()
    {
		stage.update();
	}
}	