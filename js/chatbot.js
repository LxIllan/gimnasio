//links
//https://github.com/nlp-compromise/nlp_compromise
//https://github.com/nlp-compromise/nlp_compromise/blob/master/docs/api.md

//http://eloquentjavascript.net/09_regexp.html
//https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions

var nlp = window.nlp_compromise;

var messages = []; //array that hold the record of each string in chat
var lastUserMessage = ""; //keeps track of the most recent input string from the user
var botMessage = ""; //var keeps track of what the chatbot is going to say
var botName = 'GYMBot'; //name of the chatbot
//
//
//****************************************************************
//edit this function to change what the chatbot says
function chatbotResponse(userMessage) {    
    $.ajax({
        type: 'POST',
        url: 'use_chatbot.php',
        data: { question:userMessage },
        cache: false,
        async: false,
        success: function(reply) {
            botMessage = reply;
        }
    });    
    //botMessage = nlp.sentence(lastUserMessage).replace('[Noun]', 'cat').text() //replace all nouns with cat
    //botMessage = nlp.statement(lastUserMessage).negate().text();   //negate sentense
    //botMessage = nlp.statement(lastUserMessage).to_future().text(); //   to_past    to_present
    //botMessage = nlp.text(lastUserMessage).root();  //makes the sentence simple
    //botMessage = nlp.noun(lastUserMessage).pluralize() //will make a noun plural (for single words)
}
//****************************************************************
//
//this runs each time enter is pressed.
//It controls the overall input and output
function newEntry() {
    //if the message from the user isn't empty then run 
    if (document.getElementById("chatbox").value != "") {
        //pulls the value from the chatbox ands sets it to lastUserMessage
        lastUserMessage = document.getElementById("chatbox").value;
        //sets the chat box to be clear
        document.getElementById("chatbox").value = "";
        //adds the value of the chatbox to the array messages
        messages.push('<b>Yo:</b> ' + lastUserMessage);
        //Speech(lastUserMessage);  //says what the user typed outloud
        //sets the variable botMessage in response to lastUserMessage
        chatbotResponse(lastUserMessage); 
        //add the chatbot's name and message to the array messages
        messages.push("<b>" + botName + ":</b> " + botMessage);
        botMessage = '';
        // says the message using the text to speech function written below
        // Speech(botMessage);
        //outputs the last few array elements of messages to html
        for (var i = 1; i < 8; i++) {
            if (messages[messages.length - i])
                document.getElementById("chatlog" + i).innerHTML = messages[messages.length - i];
        }
    }
}

//text to Speech
//https://developers.google.com/web/updates/2014/01/Web-apps-that-talk-Introduction-to-the-Speech-Synthesis-API
function Speech(say) {
    if ('speechSynthesis' in window) {
        var utterance = new SpeechSynthesisUtterance(say);
        //msg.voice = voices[10]; // Note: some voices don't support altering params
        //msg.voiceURI = 'native';
        //utterance.volume = 1; // 0 to 1
        utterance.rate = 1; // 0.1 to 10
        utterance.pitch = 1; //0 to 2
        //utterance.text = 'Hello World';
        //utterance.lang = 'en-US';
        speechSynthesis.speak(utterance);
    }
}

//runs the keypress() function when a key is pressed
document.onkeypress = keyPress;
//if the key pressed is 'enter' runs the function newEntry()
function keyPress(e) {
    var x = e || window.event;
    var key = (x.keyCode || x.which);
    if (key == 13 || key == 3) {
        //runs this function when enter is pressed
        newEntry();
    }
}