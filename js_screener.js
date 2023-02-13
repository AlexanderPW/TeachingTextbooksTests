//Parent elements
const waiting = document.getElementById("waiting");
const c_response = document.getElementById("c_response");
const x_response = document.getElementById("x_response");
const err_response = document.getElementById("err_response");
const choices = document.getElementById("choices");

//Buttons
const x_button = x_response.querySelector('button');
const c_button = c_response.querySelector('button');
const error_button = err_response.querySelector('button');
const choice_buttons = choices.querySelectorAll("button");

//Answer Post
const tryAnswer = function(answerVal) {
    setWaiting();
    let data = new FormData();
    data.append( "answer", answerVal )
fetch("https://tthq.me/api/littlequiz.json",
    {
        method: "POST",
        body: data
    })
    .then(function(res){ return res.json(); })
    .then(function(data){( JSON.stringify( data ) );
        waiting.style.display = "none";
        setAnswered(data);
    })
}

//Document states
const setReady = function() {
    choices.style.display = "block"
    waiting.style.display = "none"
    c_response.style.display = "none"
    x_response.style.display = "none"
    err_response.style.display = "none"
}
const setWaiting = function() {
    choices.style.display = "none"
    waiting.style.display = "block"
}
const setAnswered = function(data) {
   switch (data.result) {
       case 'x':
           let wrong_answer = x_response.querySelectorAll('span');
           wrong_answer[0].innerHTML = data.answer;
           wrong_answer[1].innerHTML = data.correct;
           x_response.style.display = "block";
           break;
       case 'c':
           let correct_answer = c_response.querySelector('span');
           correct_answer.innerHTML = data.answer;
           c_response.style.display = "block";
           break;
       case 'err':
           let error_message = err_response.querySelector('span');
           error_message.innerHTML = data.error;
           err_response.style.display = "block"
           break;
   }
}
//Event Listeners
choice_buttons.forEach(button => {
    button.addEventListener('click', function handleClick(event) {
        tryAnswer(button.value);
    });
});
x_button.addEventListener('click', setReady);
c_button.addEventListener('click', setReady);
error_button.addEventListener('click', setReady);
document.addEventListener("DOMContentLoaded", () => {
   setReady();
});



