<?php
session_start();
$title = "Play Pairs";
$stylesheet = "DataBase/Pairs.css";
include("DataBase/Header.php");
if (!isset($_SESSION['avatarCreated'])) { // this lines of php will make sure that the avatars are only generated once 
    include_once("DataBase/functions.php");
    createAvatars();
    $_SESSION['avatarCreated'] = true;
}

/*
This is the Pairs Game , it contains javascipt code for designing the apperamce and logic of the game 
the game it self is a level based game which allows users to play again , progress to next level and submit their score , (or register to the website)
important notes about the logic of the game and the code is available in the code . 
*/
?>

<main>
    <div class="StartGame">
        <abbr title="Just Click It :)"><button onclick='startGame()'>Start Game</button></abbr>
    </div>

    <script>
        localStorage.setItem("GameTime", 0);
        localStorage.setItem("GameAttempts", 0);

        function startGame() { // This function will be called only once , starts the game , and will disappear afterwords 
            document.querySelector(".StartGame").style.display = "none";

            setTimeout(function() {
                cardGame(); // call the cardgame function after 10 seconds 
            }, 5000);

            setTimeout(function() { // setting the values for the first level 
                localStorage.setItem("ToPair", 2);
                localStorage.setItem("TotalPairs", 3);
                localStorage.setItem("Level", 1);
                displayInfo();
            }, 1000);
        }

        const LevelScores = [];
        const StringLevelScores = JSON.stringify(LevelScores); // This array is used to store the score for each level (index -1 === Level's Score)
        localStorage.setItem("LevelScores", StringLevelScores);

        function cardGame(ToPair = 2, TotalPairs = 3, Level = 1) { // main function for runing the game 
            if (Level == 1) { // making sure that the values are set 
                localStorage.setItem("ToPair", ToPair);
                localStorage.setItem("TotalPairs", TotalPairs);
                localStorage.setItem("Level", Level);
            }
            const height = ((ToPair * TotalPairs) / 5 * Level) + 50; // This line uses a formula to increase the height of the wrapper class (main div) to keep the cards fit in the div  

            const StartTime = Date.now(); // starts the timer for the game 
            // creating Elements necessary : 
            const wrapper = document.createElement('div');
            wrapper.style.height = `${height}vh`;
            wrapper.classList.add('wrapper');
            const Ul = document.createElement('ul');
            Ul.classList.add('cards');
            wrapper.appendChild(Ul);
            document.body.appendChild(wrapper);
            const cardsList = document.querySelector('.cards');
            const start = document.querySelector('.StartGame button');
            const Information = document.getElementById("Information");
            Information.style.display = 'none'; // Hide the Information about the game 

            start.style.display = 'none'; // Hide the Start Game button 


            for (let i = 1; i <= ToPair; i++) { // Making the cards with two for loops , the first one is for how many cards to match and the inner loop for how many cards that the game contains 
                for (let j = 1; j <= TotalPairs; j++) {
                    // create a new li element
                    const li = document.createElement('li');
                    li.classList.add('card');

                    // create the front view div
                    const frontView = document.createElement('div');
                    frontView.classList.add('view', 'front-view');

                    // create the Emojies span and add it to the front view div
                    const emojiesSpan = document.createElement('span');
                    emojiesSpan.classList.add('Emojies');
                    emojiesSpan.textContent = "?";
                    frontView.appendChild(emojiesSpan);

                    // create the back view div
                    const backView = document.createElement('div');
                    backView.classList.add('view', 'back-view');

                    // create the avatar image and add it to the back view div
                    const avatarImg = document.createElement('img');
                    avatarImg.setAttribute('src', `DataBase/emoji/avatars/avatar${j}.png`);
                    avatarImg.setAttribute('alt', 'Avatar Image');
                    avatarImg.setAttribute('width', '50');
                    avatarImg.setAttribute('height', '50');
                    backView.appendChild(avatarImg);

                    // add the front and back views to the li element
                    li.appendChild(frontView);
                    li.appendChild(backView);

                    // add the li element to the cards list
                    cardsList.appendChild(li);
                }
            }

            const cards = document.querySelectorAll(".card");
            let firstCard, secondCard, thirdCard, fourthCard, fifthCard, sixthCard, seventhCard; // we have seven pairs in total 
            let finished = false;
            const MaxScore = 10000; // Max Score 
            let MatchedNum = 0;
            let Attempts = 0;

            function ShuffleCards() { // Selecting random avatar images for pairing between all avatar images 
                let selectedAvatars = [];
                let AllAvatars = [];
                for (let i = 1; i <= 108; i++) {
                    AllAvatars.push(i);
                }
                for (let i = 1; i <= TotalPairs; i++) {
                    let randomAvatar = Math.floor(Math.random() * AllAvatars.length); // generate a random index
                    let selectedAvatar = AllAvatars.splice(randomAvatar, 1)[0]; // remove the element at the random index and add it to the selectedAvatars array
                    for (let j = 0; j < ToPair; j++) {
                        selectedAvatars.push(selectedAvatar);
                    }
                }

                selectedAvatars.sort(() => Math.random() > 0.5 ? 1 : -1);
                finished = false;
                MatchedNum = 0;
                firstCard = secondCard = thirdCard = fourthCard = fifthCard = sixthCard = seventhCard = "";

                cards.forEach((card, index) => { 
                    card.classList.remove("fliped");
                    let Tag = card.querySelector("img");
                    Tag.src = `DataBase/emoji/avatars/avatar${selectedAvatars[index]}.png`;
                    switch (ToPair) { // checking to see how many cards should be paired and how many cards should be fliped 
                        case 2:
                            card.addEventListener("click", flip2);
                            break;
                        case 3:
                            card.addEventListener("click", flip3);
                            break;
                        case 4:
                            card.addEventListener("click", flip4);
                            break;
                        case 5:
                            card.addEventListener("click", flip5);
                            break;
                        case 6:
                            card.addEventListener("click", flip6);
                            break;
                        case 7:
                            card.addEventListener("click", flip7);
                            break;
                        default:
                            console.log("Problem With Adding Event Listener In cardGame()");
                            break;
                    }
                });
            }
            // the flio functions are used to determine how many cards should be selected in final comparison of their path 
            function flip2(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    secondCard = clicked;
                    finished = true;

                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;

                    MatchCards(firstCardImg, secondCardImg);

                }
            }

            function flip3(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && clicked !== secondCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    if (!secondCard) {
                        return secondCard = clicked;
                    }
                    thirdCard = clicked
                    finished = true;

                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;
                    let thirdCardImg = thirdCard.querySelector("img").src;

                    MatchCards(firstCardImg, secondCardImg, thirdCardImg);

                }
            }

            function flip4(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && clicked !== secondCard && clicked !== thirdCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    if (!secondCard) {
                        return secondCard = clicked;
                    }
                    if (!thirdCard) {
                        return thirdCard = clicked;
                    }
                    fourthCard = clicked;
                    finished = true;

                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;
                    let thirdCardImg = thirdCard.querySelector("img").src;
                    let fourthCardImg = fourthCard.querySelector("img").src;

                    MatchCards(firstCardImg, secondCardImg, thirdCardImg, fourthCardImg);

                }
            }

            function flip5(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && clicked !== secondCard && clicked !== thirdCard && clicked !== fourthCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    if (!secondCard) {
                        return secondCard = clicked;
                    }
                    if (!thirdCard) {
                        return thirdCard = clicked;
                    }
                    if (!fourthCard) {
                        return fourthCard = clicked;
                    }
                    fifthCard = clicked;
                    finished = true;


                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;
                    let thirdCardImg = thirdCard.querySelector("img").src;
                    let fourthCardImg = fourthCard.querySelector("img").src;
                    let fifthCardImg = fifthCard.querySelector("img").src;

                    MatchCards(firstCardImg, secondCardImg, thirdCardImg, fourthCardImg, fifthCardImg);

                }
            }

            function flip6(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && clicked !== secondCard && clicked !== thirdCard && clicked !== fourthCard && clicked !== fifthCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    if (!secondCard) {
                        return secondCard = clicked;
                    }
                    if (!thirdCard) {
                        return thirdCard = clicked;
                    }
                    if (!fourthCard) {
                        return fourthCard = clicked;
                    }
                    if (!fifthCard) {
                        return fifthCard = clicked;
                    }
                    sixthCard = clicked;
                    finished = true;


                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;
                    let thirdCardImg = thirdCard.querySelector("img").src;
                    let fourthCardImg = fourthCard.querySelector("img").src;
                    let fifthCardImg = fifthCard.querySelector("img").src;
                    let sixthCardImg = sixthCard.querySelector("img").src;

                    MatchCards(firstCardImg, secondCardImg, thirdCardImg, fourthCardImg, fifthCardImg, sixthCardImg);

                }
            }

            function flip7(m) {
                let clicked = m.target; // when user clicks a card 
                if (clicked !== firstCard && clicked !== secondCard && clicked !== thirdCard && clicked !== fourthCard && clicked !== fifthCard && clicked !== sixthCard && !finished) { // prevents the user from clicking the same card twice 
                    clicked.classList.add("fliped");
                    if (!firstCard) {
                        return firstCard = clicked;
                    }
                    if (!secondCard) {
                        return secondCard = clicked;
                    }
                    if (!thirdCard) {
                        return thirdCard = clicked;
                    }
                    if (!fourthCard) {
                        return fourthCard = clicked;
                    }
                    if (!fifthCard) {
                        return fifthCard = clicked;
                    }
                    if (!sixthCard) {
                        return sixthCard = clicked;
                    }
                    seventhCard = clicked;
                    finished = true;


                    let firstCardImg = firstCard.querySelector("img").src;
                    let secondCardImg = secondCard.querySelector("img").src;
                    let thirdCardImg = thirdCard.querySelector("img").src;
                    let fourthCardImg = fourthCard.querySelector("img").src;
                    let fifthCardImg = fifthCard.querySelector("img").src;
                    let sixthCardImg = sixthCard.querySelector("img").src;
                    let seventhCardImg = seventhCard.querySelector("img").src;


                    MatchCards(firstCardImg, secondCardImg, thirdCardImg, fourthCardImg, fifthCardImg, sixthCardImg, seventhCard);
                }
            }

            function MatchCards(...images) { // This function will take a list in a size between 2-7 and which are the selected cards to be compared 
                Attempts++; // keeps track of number of attempts 
                if (images.every((image) => image === images[0])) { // checking to see if all the image paths are the same as the first card selected 
                    MatchedNum++;
                    if (MatchedNum === TotalPairs) {
                        const StringAllScores = localStorage.getItem('LevelScores');
                        let AllScores = JSON.parse(StringAllScores);
                        const EndTime = Date.now();

                        let Time = EndTime - StartTime; // calculating the total time for level
                        var Level = parseInt(localStorage.getItem("Level")); // current level stored in local storage 

                        let UserScore = MaxScore - ((Attempts * 1000 / TotalPairs) + (Time / TotalPairs) - (Level * 1000)); // calculating the user's score 
                        UserScore = Math.floor(UserScore); // removing the decimal points 


                        var newScore = false;
                        var Failed = false;
                        if (UserScore > 0) {
                            let Element = true;
                            if (typeof AllScores[Level - 1] === "undefined") {
                                AllScores[Level - 1] = 0;
                            }

                            setTimeout(() => { // checking to see if the score for the current level is higher than the privious score 
                                if (AllScores[Level - 1] <= UserScore && AllScores[Level - 1] !== 0) {
                                    newScore = true;
                                    const bestScore = document.getElementById('BestScore');
                                    bestScore.textContent = `New High Score ${UserScore}`;
                                    bestScore.style.backgroundColor = "#ffd700";
                                    bestScore.style.display = "inline-block";
                                    const wrapperBackColor = document.querySelector('.wrapper');
                                    wrapperBackColor.style.background = 'radial-gradient(circle, #ffd700, #ffd700,#faec99)';
                                }
                                AllScores[Level - 1] = UserScore; // seting the new score as the highest score for level and updateing the list 
                                const UpdatedAllScores = JSON.stringify(AllScores);
                                localStorage.setItem('LevelScores', UpdatedAllScores);
                            }, 500)
                        } else {
                            Failed = true;
                            const Fail = document.getElementById('Status');
                            Fail.textContent = "Fail";
                            Fail.style.color = "rgb(187, 14, 14)";
                            Fail.style.display = "inline-block";
                            const FailScore = document.getElementById('Score');
                            FailScore.innerHTML = `<br><br> Ur Score :( &nbsp;&nbsp;&nbsp; ${UserScore} <br><br> Time : ${Math.floor(Time/1000)}s &nbsp;&nbsp;&nbsp;&nbsp; Attempts : ${Attempts}`;
                            FailScore.style.backgroundColor = "rgb(2, 0, 17)";
                            FailScore.style.display = "inline-block";
                        }

                        var GameTime = parseInt(localStorage.getItem("GameTime"));
                        GameTime += Math.floor(Time / 1000);
                        localStorage.setItem("GameTime", GameTime);
                        var GameAttempts = parseInt(localStorage.getItem("GameAttempts"));
                        GameAttempts += Attempts;
                        localStorage.setItem("GameAttempts", GameAttempts);

                        if (Failed) {
                            let Wrapper = document.querySelector("div.wrapper");
                            Wrapper.remove();
                            var RetryButton = document.getElementById("RetryButton");
                            RetryButton.style.backgroundColor = "rgb(195, 51, 51)";
                            RetryButton.style.bottom = "50px";
                            RetryButton.style.left = "140px";
                            RetryButton.style.display = "inline-block";
                        }

                        if (!Failed) {
                            setTimeout(() => {
                                const SuccessScore = document.getElementById('Score');
                                SuccessScore.innerHTML = `<br><br> Ur Score :) &nbsp;&nbsp;&nbsp; ${UserScore} <br><br> Time : ${Math.floor(Time/1000)}s &nbsp;&nbsp;&nbsp;&nbsp; Attempts : ${Attempts}`;
                                SuccessScore.style.color = "gold";
                                SuccessScore.style.backgroundColor = "rgb(2, 0, 17)";
                                SuccessScore.style.display = "inline-block";
                                const Success = document.getElementById('Status');
                                Success.textContent = "Success";
                                Success.style.color = "green";
                                Success.style.fontSize = "150px";
                                Success.style.display = "inline-block";
                                let Wrapper = document.querySelector("div.wrapper");
                                Wrapper.remove();
                                if (!newScore) {
                                    var RetryButton = document.getElementById("RetryButton");
                                    RetryButton.style.bottom = "100px";
                                    RetryButton.style.left = "180px";
                                    RetryButton.style.backgroundColor = "#409442";
                                    RetryButton.style.display = "inline-block";
                                }
                                var NextLevelButton = document.getElementById("NextLevelButton");
                                NextLevelButton.style.display = "inline-block";
                            }, 1500);
                        }

                        if (localStorage.getItem("Username") && localStorage.getItem("Password")) {
                            var EndGame = document.getElementById("SubmitGame");
                            EndGame.style.display = "inline-block";
                        }else {
                            var EndGame = document.getElementById("register");
                            EndGame.style.display = "inline-block";
                        }

                    }


                    switch (ToPair) {
                        case 2:
                            firstCard.removeEventListener("click", flip2);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip2);
                            secondCard = "";
                            break;
                        case 3:
                            firstCard.removeEventListener("click", flip3);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip3);
                            secondCard = "";
                            thirdCard.removeEventListener("click", flip3);
                            thirdCard = "";
                            break;
                        case 4:
                            firstCard.removeEventListener("click", flip4);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip4);
                            secondCard = "";
                            thirdCard.removeEventListener("click", flip4);
                            thirdCard = "";
                            fourthCard.removeEventListener("click", flip4);
                            fourthCard = "";
                            break;
                        case 5:
                            firstCard.removeEventListener("click", flip5);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip5);
                            secondCard = "";
                            thirdCard.removeEventListener("click", flip5);
                            thirdCard = "";
                            fourthCard.removeEventListener("click", flip5);
                            fourthCard = "";
                            fifthCard.removeEventListener("click", flip5);
                            fifthCard = "";
                            break;
                        case 6:
                            firstCard.removeEventListener("click", flip6);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip6);
                            secondCard = "";
                            thirdCard.removeEventListener("click", flip6);
                            thirdCard = "";
                            fourthCard.removeEventListener("click", flip6);
                            fourthCard = "";
                            fifthCard.removeEventListener("click", flip6);
                            fifthCard = "";
                            sixthCard.removeEventListener("click", flip6);
                            sixthCard = "";
                            break;
                        case 7:
                            firstCard.removeEventListener("click", flip7);
                            firstCard = "";
                            secondCard.removeEventListener("click", flip7);
                            secondCard = "";
                            thirdCard.removeEventListener("click", flip7);
                            thirdCard = "";
                            fourthCard.removeEventListener("click", flip7);
                            fourthCard = "";
                            fifthCard.removeEventListener("click", flip7);
                            fifthCard = "";
                            sixthCard.removeEventListener("click", flip7);
                            sixthCard = "";
                            seventhCard.removeEventListener("click", flip7);
                            seventhCard = "";
                            break;
                        default:
                            console.log("Error With Number Of Pairs In MatchCards()");
                            break;
                    }
                    return finished = false;
                }

                setTimeout(() => {
                    // adding the Shake class to cards after 200ms
                    switch (ToPair) {
                        case 7:
                            seventhCard.classList.add("shake");
                        case 6:
                            sixthCard.classList.add("shake");
                        case 5:
                            fifthCard.classList.add("shake");
                        case 4:
                            fourthCard.classList.add("shake");
                        case 3:
                            thirdCard.classList.add("shake");
                        case 2:
                            secondCard.classList.add("shake");
                            firstCard.classList.add("shake");
                            break;
                        default:
                            console.log("Error With (Shake) In MatchCards()");
                            break;
                    }
                }, 300);

                setTimeout(() => {
                    // removing both shake and fliped classed fron cards (after they are matched)
                    switch (ToPair) {
                        case 7:
                            seventhCard.classList.remove("shake", "fliped");
                            seventhCard = "";
                        case 6:
                            sixthCard.classList.remove("shake", "fliped");
                            sixthCard = "";
                        case 5:
                            fifthCard.classList.remove("shake", "fliped");
                            fifthCard = "";
                        case 4:
                            fourthCard.classList.remove("shake", "fliped");
                            fourthCard = "";
                        case 3:
                            thirdCard.classList.remove("shake", "fliped");
                            thirdCard = "";
                        case 2:
                            secondCard.classList.remove("shake", "fliped");
                            secondCard = "";
                            firstCard.classList.remove("shake", "fliped");
                            firstCard = "";
                            break;
                        default:
                            console.log("Error With (Shake) In MatchCards()");
                            break;
                    }
                    finished = false;
                }, 900);
            }

            ShuffleCards(); // default shuffling the cards 

            cards.forEach(card => {
                // adding click event to all cards
                switch (ToPair) {
                    case 2:
                        card.addEventListener("click", flip2);
                        break;
                    case 3:
                        card.addEventListener("click", flip3);
                        break;
                    case 4:
                        card.addEventListener("click", flip4);
                        break;
                    case 5:
                        card.addEventListener("click", flip5);
                        break;
                    case 6:
                        card.addEventListener("click", flip6);
                        break;
                    case 7:
                        card.addEventListener("click", flip7);
                        break;
                    default:
                        console.log("Problem With Adding Event Listener In MatchCards()");
                        break;
                }
            })
        }
    </script>

    <script>
        function Send() { // sending a post request to leaderboard with user's game result 

            var Level = parseInt(localStorage.getItem("Level"));
            const AllScores = localStorage.getItem('LevelScores');
            var TotalAttempts = parseInt(localStorage.getItem("GameAttempts"));
            var TotalTime = parseInt(localStorage.getItem("GameTime"));
            const Username = localStorage.getItem("Username");
            // Create a new form element
            const form = document.createElement('form');

            // Set the action and method attributes of the form
            form.action = 'leaderboard.php';
            form.method = 'post';

            // Create new input elements
            const Time = document.createElement('input');
            const Scores = document.createElement('input');
            const Attempts = document.createElement('input');
            const BestLevel = document.createElement('input');
            const User = document.createElement('input');

            // Set the name and value attributes of the input elements
            Time.name = "Time";
            Time.value = TotalTime;
            Scores.name = "Score";
            Scores.value = AllScores ;
            Attempts.name = "Attempts";
            Attempts.value = TotalAttempts;
            BestLevel.name = "Level";
            BestLevel.value = Level;
            User.name = "username";
            User.value = Username ;

            // Add the input elements to the form
            form.appendChild(Time);
            form.appendChild(Scores);
            form.appendChild(Attempts);
            form.appendChild(BestLevel);
            form.appendChild(User);

            // Add the form to the document body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }



        function RetryLevel() { // setting the display of all buttons to none and calling the cardsgame with the values for the current level 
            var register = document.getElementById("register");
            register.style.display = "none";
            var EndGame = document.getElementById("SubmitGame");
            EndGame.style.display = "none";
            var RetryButton = document.getElementById("RetryButton");
            RetryButton.style.display = "none";
            var NextLevelButton = document.getElementById("NextLevelButton");
            NextLevelButton.style.display = "none";
            var Score = document.getElementById("Score");
            Score.style.display = "none";
            var Status = document.getElementById("Status");
            Status.style.display = "none";

            var ToPair = parseInt(localStorage.getItem("ToPair"));
            var TotalPairs = parseInt(localStorage.getItem("TotalPairs"));
            var Level = parseInt(localStorage.getItem("Level"));

            setTimeout(function() {
                displayInfo();
            }, 500);

            setTimeout(() => {
                cardGame(ToPair, TotalPairs, Level);
            }, 5000);

        }

        function NextLevel() { // setting all the button displays to none and increasing the number of cards , and cards to match , saving them and calling the cardgame function with updated values 
            var register = document.getElementById("register");
            register.style.display = "none";
            var EndGame = document.getElementById("SubmitGame");
            EndGame.style.display = "none";
            const Fail = document.getElementById("Status");
            Fail.style.display = "none";
            const Score = document.getElementById("Score");
            Score.style.display = "none";
            const bestScore = document.getElementById('BestScore');
            bestScore.style.display = "none";
            var RetryButton = document.getElementById("RetryButton");
            RetryButton.style.display = "none";
            var NextLevelButton = document.getElementById("NextLevelButton");
            NextLevelButton.style.display = "none";

            var ToPair = parseInt(localStorage.getItem("ToPair"));
            var TotalPairs = parseInt(localStorage.getItem("TotalPairs"));
            var Level = parseInt(localStorage.getItem("Level"));

            Level++;

            if (TotalPairs <= 108) {
                    TotalPairs ++ ;
                if (Level === 10 || Level === 20 || Level === 40 || Level === 65 || Level === 100) {
                    ToPair += 1;
                }
                localStorage.setItem("ToPair", ToPair);
                localStorage.setItem("TotalPairs", TotalPairs);
                localStorage.setItem("Level", Level);

                var ToPair = parseInt(localStorage.getItem("ToPair"));
                var TotalPairs = parseInt(localStorage.getItem("TotalPairs"));
                var Level = parseInt(localStorage.getItem("Level"));

                setTimeout(function() {
                    displayInfo();
                }, 500);
                setTimeout(() => {
                    cardGame(ToPair, TotalPairs, Level);
                }, 5000);
            } else {
                setTimeout(function() {
                    displayInfo();
                }, 500);
                setTimeout(() => {
                    Level = 1;
                    cardGame(ToPair, TotalPairs, Level);
                }, 5000);
            }

        }

        function displayInfo() { // Displayes information about the level that is going to begin
            const level = document.getElementById('Level');
            const matchNum = document.getElementById('MatchNum');
            const personalBest = document.getElementById('PersonalBest');
            const cardNum = document.getElementById('CardNum');

            let Cards = parseInt(localStorage.getItem("TotalPairs"));
            let Match = parseInt(localStorage.getItem("ToPair"));
            let Level = parseInt(localStorage.getItem("Level"));

            const StringAllScores = localStorage.getItem('LevelScores');
            let AllScores = JSON.parse(StringAllScores);

            if (typeof AllScores[Level - 1] === 'undefined') {
                personalBest.style.fontSize = "x-Large";
                personalBest.style.color = "rgb(25, 144, 35)";
                personalBest.textContent = `New Max Level Reached`;
            } else {
                personalBest.style.fontSize = "x-Large";
                personalBest.style.color = "#4CAF50";
                personalBest.textContent = `Highest Score For This Level Is ${AllScores[Level - 1]}`;
            }

            level.textContent = `Level : ${Level}`;
            matchNum.textContent = `Match ${Match} Cards Together`;

            cardNum.textContent = `Total Number Of Cards : ${Cards * Match}`;

            document.getElementById("Information").style.display = "block";
        }
    </script>

    <br><br>
    <span id="BestScore" style="display: none;"></span>
    <span id="Status" style="display: none;"></span>
    <span id="Score" style="display: none;"></span>

    <script>
        // Buttons used to call relavent functions and continue the game untill the user submits their score 
    </script>


   <div class="Container">
   <abbr title="The Score Will Be Set To Zero"><button class="RetryLevel" id="RetryButton" onclick="RetryLevel()" style="display:none;">Play Again</button></abbr>
    <abbr title="Go Anywhere As Long As It's Forward"><button class="NextLevel" id="NextLevelButton" onclick="NextLevel()" style="display:none;">Next Level</button></abbr>
   </div>
    <abbr title="Giving Up So Soon ??? DiD You Knew Max Level Has 756 Cards and You Have To Choose 7 Cards With Each Attempt :)"><button class="SubmitGame" id="SubmitGame" onclick="Send()" style="display:none;">End And Submit</button></abbr>
    <abbr title="Register To Our Website To Take Your Rightful Place In The Leaderboard :)"><button class="register" id="register" style="display:none;" onclick="window.location.href = 'registration.php'">Register Now</button></abbr>
    <p class="GameInfo" id="Information" style="display:none;">
        <br><b id="Level" style="font-size: xx-large;  color: rgb(239, 31, 72);"></b><br><b id="CardNum"></b><br><b id="MatchNum"></b><br><b id="PersonalBest"></b><br><b id="ScoreSoFar"></b>
    </p>

</main>
</body>

</html>