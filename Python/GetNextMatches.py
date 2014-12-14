from datetime import date
import datetime
from bs4 import BeautifulSoup

import sqlite3
conn = sqlite3.connect('../NFL.db')
conn.execute('DELETE FROM Parties')


DateMatch = 0
weekNumber = date.today().isocalendar()[1] -35

for WeekLoop in range(weekNumber, 18):
    import urllib.request

    response = urllib.request.urlopen('http://espn.go.com/nfl/schedule/_/week/' + str(WeekLoop))
    html = response.read()
    response.close()
    soup = BeautifulSoup(html)
    Parties = soup.find('table').find_all('tr')

    for Partie in Parties:
      rowLenght = len(Partie.find_all('td'))
      rowContent = Partie.find_all('td')
      if rowLenght == 5:
        if 'TIME (ET)' in rowContent[1] :
            DateMatch = str(date.today().year) +  rowContent[0].get_text()


        else:
            if DateMatch == 0 :
                DateMatch = str(datetime.datetime.today().year + datetime.datetime.today().month)

            links = rowContent[0].find_all('a')
            NomVisiteur = links[0].get_text().strip()
            NomHote = links[1].get_text().strip()

            if DateMatch == 0 :
                DateHeure = datetime.datetime.strptime(DateMatch,"%Y%a, %b %d")
              # DateHeure = DateHeure.strftime("%Y%a, %b, %d")
            else :
                DateHeure = datetime.datetime.now()
                DateHeure = DateHeure.replace(hour = 0, minute = 0,second=0, microsecond= 0)

       #     IDHote = 0
       #     IDVisiteur = 0
      #      with conn:
               # cur = conn.cursor()
               # IDHote = cur.execute('SELECT EquipeNom FROM Equipes WHERE EquipeNom =?',(NomHote ,)).fetchone()[0]
               # IDVisiteur = cur.execute("SELECT EquipeNom FROM Equipes WHERE EquipeNom =?",(NomVisiteur ,)).fetchone()[0]

            matchs = [(NomHote,NomVisiteur,0,0,DateHeure)]
            conn.executemany('INSERT INTO Parties (PartieNomHote,PartieNomVisiteur,PartiePointsHote,PartiePointsVisiteur,PartieDate) VALUES (?,?,?,?,?)', matchs)

conn.commit()
conn.close()