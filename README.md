# A web Based memory Game within a delightful Website 


Bullet Points For Webpages : 

index.php:

This is the home page of the website. It simply welcomes the new user that has registered and guides them to the pairs.php webpage. It also provides information about the game for registered users. Alternatively, users who haven't registered will be guided to the registration webpage.

registration.php:

This webpage allows new users to register to the website using local storage. The main JavaScript of the webpage helps users not to enter any wrong characters for their username and ensures that the user is entering a correct and strong password. Another feature of this webpage is that the user can create their desired avatar and see it shaping as they do so. (The avatar will be used later as an icon in the nav-bar for customising the webpage).

pairs.php:

Pairs.php is a complex levelled memory game that will entertain users. As the user progresses through the levels of the game, the game will become harder, and they will have to match more than two cards after level 10. In the final level of the game, the user should pair seven cards at a time among 756 cards, which is 108 (the maximum number of combinations with skin, mouth, and eye images) times seven (the repeated cards that they have to match). After level two, they can submit and finish the game (this will send a POST request to the leaderboard.php with information about the game), and upon completion of each game, the users could either choose to play again to overwrite their score for the current level or they can choose to progress to the next level. If the user manages to increase their score for the current level, the div will turn to gold. Some basic information about the level will be shown before the game starts.

leaderboard.php:

This is a simple webpage that will receive the POST request from the pairs.php and will write the data to a text file called GameData. The PHP code will prevent the data from being written twice and use a function to read the data from the text file.
There are two tables that will display data, one based on highest score and the other based on highest score for each level . 

Note that all colours are as specified in the project's specification, but since there was no mention of transparency, I made them a bit more transparent (for example, the background pictures or blue colour for the table).

-------------------------------250 Words----------------------------------

Points About The Submission : 

- All webpages are designed in the complex level (100% Mark) specified in specification.

About Developer : 

- Student : Amirali Famili
- Student Number : 720060845
- Candidate Number : 022378
- Email : af689@exeter.ac.uk
- Module : Web Development 
- Module Code : ECM1417
