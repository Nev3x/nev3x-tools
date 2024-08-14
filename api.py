import fastapi
import dhooks
import uvicorn
from fastapi.middleware.cors import CORSMiddleware
from javascript import require, On, Once, AsyncTask, once, off
import javascript
import vars
from pydantic import BaseModel

mineflayer = require('mineflayer')
pvp = require('mineflayer-pvp')
pathfinder = require('mineflayer-pathfinder')
app = fastapi.FastAPI()

origins = ["*"]  # Allow requests from all origins

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)
@app.get("/api/post/{url}/{text}/{token}")
async def postWebhook(url,text, token):
    url = str(url)
    if url.__contains__('-'):
        url = url.replace('-', '/')
    json1 = {"url":url, "text":text, "token":token}
    hook = dhooks.Webhook(url + token)
    hook.send(text)
    print(json1)
    return "Message received, webhook should be sent!"

@app.get('/api/minecraft/createBot/{username}/{host}/{port}/{id}')
def createBot(username, host, port, id):
    vars.bot.append(mineflayer.createBot({ 'host': host, 'port': port, 'username': username, 'hideErrors': False }))
    vars.ids.append(id)
    botindex = vars.ids.index(id)
    once(vars.bot[botindex], 'login')
    vars.bot[botindex].loadPlugin(pvp.plugin)
    vars.bot[botindex].loadPlugin(pathfinder.pathfinder)
    return "Bot created successfully"


class Item(BaseModel):
    message: str


@app.post('/api/minecraft/{id}')
async def send_chat_message(item: Item, id):
    botindex = vars.ids.index(id)

    vars.bot[botindex].chat(item.message)
    return f"Chat message {item.message} sent!"

class Target(BaseModel):
    target: str

@app.post('/api/minecraft/attack/{id}')
async def attack_player(target: Target, id):
    botindex = vars.ids.index(id)
    player = vars.bot[botindex].players[target.target].entity
    if player:
        vars.bot[botindex].pvp.attack(player)
        return "Attacking " + target.target
    else:
        return target.target + " not found!"

@app.post('/api/minecraft/stopattack/{id}')
async def stop_attacking(id):
    botindex = vars.ids.index(id)
    vars.bot[botindex].pvp.stop()
    return 'Stopped attacking!'



@app.post('/api/minecraft/equip_armor/{id}')
async def equip(id):
    botindex = vars.ids.index(id)

    sword = next((item for item in vars.bot[botindex].inventory.items() if 'sword' in item.name), None)
    helmet = next((item for item in vars.bot[botindex].inventory.items() if 'helmet' in item.name), None)
    torso = next((item for item in vars.bot[botindex].inventory.items() if 'chestplate' in item.name), None)
    legs = next((item for item in vars.bot[botindex].inventory.items() if 'leggings' in item.name), None)
    boots = next((item for item in vars.bot[botindex].inventory.items() if 'boots' in item.name), None)

    try:
        vars.bot[botindex].equip(sword, 'hand')
    except:
        print('error')
    try:
        vars.bot[botindex].equip(helmet, 'head')
    except:
        print('error')
    try:
        vars.bot[botindex].equip(torso, 'torso')
    except:
        print('error')
    try:
        vars.bot[botindex].equip(legs, 'legs')
    except:
        print('error')
    try:
        vars.bot[botindex].equip(boots, 'feet')
    except:
        print('error')
    return "Equiped all that bot had!"

class Player(BaseModel):
    player: str
@app.post('/api/minecraft/follow/{id}')
async def follow(player: Player, id):
    botindex = vars.ids.index(id)
    bot = vars.bot[botindex]

    target = bot.players[player.player].entity


    follow = pathfinder.goals.GoalFollow(target, 1)
    bot.pathfinder.setGoal(follow, True)
    bot.setControlState('sprint', True)
    return 'Following ' + player.player

@app.post('/api/minecraft/unfollow/{id}')
async def unfollow(id):
    botindex = vars.ids.index(id)
    bot = vars.bot[botindex]

    bot.pathfinder.setGoal(None)

    return "Stopped following player!"

@app.post('/api/minecraft/quit/{id}')
async def disconnect(id):
    botindex = vars.ids.index(id)
    bot = vars.bot[botindex]

    bot.quit('xd')

class Levenstein(BaseModel):
    doc1: str
    doc2: str

def levenshtein_distance(str1, str2):
    len_str1 = len(str1) + 1
    len_str2 = len(str2) + 1
    matrix = [[0 for n in range(len_str2)] for m in range(len_str1)]
    
    for i in range(len_str1):
        matrix[i][0] = i
    for j in range(len_str2):
        matrix[0][j] = j

    for i in range(1, len_str1):
        for j in range(1, len_str2):
            if str1[i-1] == str2[j-1]:
                cost = 0
            else:
                cost = 1
            matrix[i][j] = min(matrix[i-1][j] + 1,       
                               matrix[i][j-1] + 1,       
                               matrix[i-1][j-1] + cost)  

    return matrix[-1][-1]

def similarity_ratio(str1, str2):
    distance = levenshtein_distance(str1, str2)
    max_len = max(len(str1), len(str2))
    similarity = 1 - (distance / max_len)
    return similarity

@app.post('/api/similarity/levenstein/')
async def levenstein(docs: Levenstein):
    doc1 = docs.doc1
    doc2 = docs.doc2
    
    similarity = similarity_ratio(doc1, doc2)
    
    if similarity > 0.80:
        return f"Similarity (0.01 - 1.0): {similarity:.2f} (very high)"
    if similarity > 0.60:
        return f"Similarity (0.01 - 1.0): {similarity:.2f} (high)"
    if similarity > 0.40:
        return f"Similarity (0.01 - 1.0): {similarity:.2f} (moderate)"
    if similarity < 0.30:
        return f"Similarity (0.01 - 1.0): {similarity:.2f} (low)"
    

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)


