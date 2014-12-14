from datetime import date
import datetime
from bs4 import BeautifulSoup
import sqlite3
conn = sqlite3.connect('NFL.db')

weekNumber = date.today().isocalendar()[1] -35

for WeekLoop in range(1, weekNumber):
    import urllib.request

    response = urllib.request.urlopen('http://espn.go.com/nfl/schedule/_/week/' + str(WeekLoop))
    html = response.read()
    response.close()
    soup = BeautifulSoup(html)
    Parties = soup.find('table').find_all('tr')

    for Partie in Parties:
      rowLenght = len(Partie.find_all('td'))
      rowContent = Partie.find_all('td')

      if rowLenght == 4 and rowContent[2].get_text() != 'Postponed'and rowContent[1].get_text() != 'HI PASSING' :
        print(rowContent[0].get_text())
        print(rowContent[0].get_text().split(' ', 1)[0])
        if 'TIME (ET)' in rowContent[1]:
            DateMatch = rowContent[0].get_text()
        else:
            links = rowContent[0].find_all('a')
            NomVisiteur = links[0].get_text().strip()
            NomHote = links[1].get_text().strip()
            IDHote = 0
            IDVisiteur = 0
            with conn:
                cur = conn.cursor()
                IDHote = cur.execute('SELECT EquipeID FROM Equipes WHERE EquipeNom =?',(NomHote ,)).fetchone()[0]
                IDVisiteur = cur.execute("SELECT EquipeID FROM Equipes WHERE EquipeNom =?",(NomVisiteur ,)).fetchone()[0]

            matchs = [(IDHote,IDVisiteur,0,0,DateHeure)]
         #   conn.executemany('INSERT INTO Parties (PartieIDHote,PartieIDVisiteur,PartiePointsHote,PartiePointsVisiteur,HeureMatch) VALUES (?,?,?,?,?)', matchs)

conn.commit()
conn.close()