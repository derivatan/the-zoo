<html>
<head>
    <title>The Zoo</title>
    <style type="text/css">

        body {
            font-family: Verdana, serif;
            font-size: 5vh;
            text-align: center;
            padding: 10vh 2vh;
            background-image: linear-gradient(deepskyblue, lawngreen);
        }

        button,input {
            padding: 3vh;
            font-size: 5vh;
            background-color: darkgray;
            border: 0.3vh solid black;
            text-align: center;
        }

        .game:not(#intro) {
            display:none;
        }

    </style>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
</head>
<body>

    <h2>The Zoo</h2>

    <div class="game" id="intro">
        Think of an animal!<br />
        I will ask you questions about it, to try to figure out which.<br />
        <br />
        <button id="start-button">Start</button>
    </div>

    <div class="game" id="question">
        <div id="text"></div><br />
        <br />
        <button id="answer-yes">Yes</button>
        <button id="answer-no">No</button>
    </div>

    <div class="game" id="guess-correct">
        Hooray! I won!<br />
        <br />
        <button class="restart">Restart</button>
    </div>

    <div class="game" id="guess-wrong">
        Congrats! You won.<br/>
        <br />
        Just curious: What was your animal?<br/>
        <input id="new-animal" type="text"><br/>
        <br />
        Can you give me a question for which the answer for "<span id="new-animal-label"></span>" is "yes" and the answer for "<span id="old-animal-label"></span>" is "no".<br />
        <input id="new-question" type="text"><br />
        <br />
        <button class="restart" id="new-question-submit">Submit</button>
    </div>

    <div class="game" id="loader">
        Loading...
    </div>

</body>
<script type="text/javascript">

    var current_question_id = null;
    var guess = "";

    var activeScreen = function (id) {
        $('.game').hide();
        $('#' + id).show();
    };

    var restart = function() {
        current_question_id = null;
        guess = "";
        activeScreen('intro')
    };

    var getNextQuestion = function(question_id, question_answer) {
        var parameters = {};
        if (question_id !== null) {
            parameters = {
                "question_id": question_id,
                "question_answer": question_answer
            }
        }
        $.get('api/v1/question', parameters, function (data) {
            current_question_id = data.question.id;
            if (data.question.type === 1) { // Question::GUESS
                guess =  data.question.question;
                $('#question #text').text('Is it a ' + guess + '?')
            } else {
                $('#question #text').text(data.question.question)
            }
            activeScreen('question')
        });
    };

    $(function () {
        $('#new-animal').keyup(function () {
            $('#new-animal-label').text($(this).val());
        });

        $('#start-button').click(function () {
            activeScreen('loader');
            getNextQuestion(null, null);
        });

        $('#answer-yes').click(function () {
            if (guess !== "") {
                activeScreen('guess-correct');
            } else {
                activeScreen('loader');
                getNextQuestion(current_question_id, true)
            }
        });

        $('#answer-no').click(function () {
            if (guess !== "") {
                activeScreen('guess-wrong');
                $('#old-animal-label').text(guess);
            } else {
                activeScreen('loader');
                getNextQuestion(current_question_id, false)
            }
        });

        $('#new-question-submit').click(function () {
            $.post('api/v1/question', {
                "question_id": current_question_id,
                "new_animal": $('#new-animal').val(),
                "new_question": $('#new-question').val(),
            }, function () {
                $('#new-animal').val('');
                $('#new-question').val('');
            }, 'json');
        });

        $('.restart').click(restart);
    })

</script>
</html>
