import requests, json, datetime
# import my class
from MongoDB import MongoDB

class Youtube:
    YOUTUBE_API_KEY = "AIzaSyBGzuh44Bn4bjG2Os9XXNCdS0ZeTLWs5Rg"

    def __init__(self, url):
        self.url = url + self.YOUTUBE_API_KEY     

    def apiData(self):
        r = requests.get( self.url )
        response = r.text
        self.jsonData = json.loads( response )
        return self.jsonData



url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&chart=mostPopular&maxResults=2&key='
yt = Youtube(url)
res = yt.apiData()
items = res['items']

videosData = []
for item in items:
    data = {
        'videoId' : item['id'],
        'type' : item['kind'],
        'detail' : item['snippet']
    }

    videosData.append(data)


print(videosData)

md = MongoDB()
print(md.videosColl)