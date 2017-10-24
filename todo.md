x Lägg till stöd för typ
Lägg till stöd för taggar
Lägg till stöd för poäng på frågor och för användare
Lägg till att kunna välja accepterat svar (bara författaren)
Lägg till att kunna sortera poster/frågor på poäng eller på nyast/id

Fixa till javascripten, solkart till 6:an.
Om paginering är det en solklar 6:a!

sqlite> SELECT tag, count(PT.postId) FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId;
tag         count(PT.postId)
----------  ----------------
javascript  5
sqlite> SELECT tag, count(PT.postId) FROM tags AS T LEFT JOIN postTagLinks AS PT ON T.id = PT.tagId;
tag         count(PT.postId)
----------  ----------------
php         5
sqlite> SELECT tag, count(PT.postId) FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id;
tag         count(PT.postId)
----------  ----------------
javascript  1
kategoriet  2
monad       1
funktor     1
sqlite> SELECT tag, count(PT.postId) AS tagCount FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id ORDER BY tagCount;
tag         tagCount
----------  ----------
javascript  1
monad       1
funktor     1
kategoriet  2
sqlite> SELECT tag, count(PT.postId) AS tagCount FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id ORDER BY tagCount desc;
tag             tagCount
--------------  ----------
kategorieteori  2
javascript      1
monad           1
funktor         1
sqlite> SELECT tag, count(PT.postId) AS tagCount FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id ORDER BY tagCount desc LIMIT 2;
tag             tagCount
--------------  ----------
kategorieteori  2
javascript      1
sqlite> SELECT tag, count(PT.postId) AS tagCount FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id ORDER BY tagCount desc LIMIT 5;
tag             tagCount
--------------  ----------
kategorieteori  2
javascript      1
monad           1
funktor         1
