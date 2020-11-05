<?php
    require_once 'ChatBot.php';

    $chatBot = new ChatBot();
    $question = $_POST['question'];
    echo $chatBot->process_question($question);