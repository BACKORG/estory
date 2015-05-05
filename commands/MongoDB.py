from pymongo import MongoClient

class MongoDB:
    def __init__(self):
        # connect to database
        self.connectDb()


    def connectDb(self):
        server = MongoClient('mongodb://localhost:27017/')
        db = server.videoDb

        # set the videos collection
        self.videosColl = db.videos

    def insertToDb(self, data):
        result = self.videosColl.insert_many(data)
        return result.inserted_ids
