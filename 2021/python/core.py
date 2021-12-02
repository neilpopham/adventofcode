import re
import os

def load_data(file):
	path = os.path.dirname(os.path.realpath(__file__))
	file = open("%s/../data/%s" % (path, file), "r")
	data = file.read().strip()
	data = re.sub("\r", "", data)
	return data.splitlines()
