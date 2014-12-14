#!/usr/bin/python
import urllib.request
import sqlite3
conn = sqlite3.connect('../NFL.db')
response = urllib.request.urlopen('http://espn.go.com/nfl/standings')
html = response.read()
response.close()
from bs4 import BeautifulSoup
soup = BeautifulSoup(html)
Equipes = soup.find('table').find_all('tr')


conn.execute('''DELETE FROM Equipes''')
for Equipe in Equipes:
  rowLenght = len(Equipe.find_all('td'))
  rowContent = Equipe.find_all('td')
  conn.execute('''CREATE TABLE IF NOT EXISTS Equipes (EquipeID integer PRIMARY KEY,EquipeNom text,EquipeDefaites integer,EquipeVictoires integer,EquipePF integer,EquipePA integer)''')
  if rowLenght > 1 and rowContent[1].get_text() != 'W':
        equipe = [(str(rowContent[0].get_text().strip()),rowContent[2].get_text(),rowContent[1].get_text(),rowContent[9].get_text(),rowContent[10].get_text())]
        conn.executemany('INSERT INTO Equipes (EquipeNom,EquipeDefaites,EquipeVictoires,EquipePF,EquipePA) VALUES (?,?,?,?,?)', equipe)

conn.commit()
conn.close()