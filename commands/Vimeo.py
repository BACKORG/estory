import vimeo as vimeoModule
# import my class
from MongoDB import MongoDB

class Vimeo:
    ACCESS_TOKEN = "d0ebd0d50dd20831d128b14001e47cf0"
    CLIENT_IDENTIFIER = "8646411980dd25c1de04e8dd9470585ed69641d1"
    CLIENT_SECRET = "oSVZ9cSdwgmmHJyyE7Zqy1xehRZxyI7uXX9P5Y7SNpImu5uBJnn9CBYSEBoAap9NcYAkk8pjTOOSo3+BPQnrEwcsT+SqcKAOgb8GNHbo041C/BSYpIUmxutVqk2fV1Ov"

    def __init__(self):
        self.vimeo = vimeoModule.VimeoClient(token=self.ACCESS_TOKEN, key=self.CLIENT_IDENTIFIER, secret=self.CLIENT_SECRET)

    def search(self, str):
        # Make the request to the server for the "/me" endpoint.
        response = self.vimeo.get('/videos?per_page=1&query='+str+'&sort=date&direction=desc&filter=CC')
        # Make sure we got back a successful response.
        assert response.status_code == 200  

        return response.json()



v = Vimeo()
data = v.search("NBA")
print(data)

md = MongoDB()
print(md.videosColl)