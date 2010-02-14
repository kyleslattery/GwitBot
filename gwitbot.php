<?php

// Include config file
require_once("config.php");

// Include Twitter Library (http://classes.verkoyen.eu/twitter/)
require_once("twitter.php");

// Setup twitter
$twitter = new Twitter($config['twitter']['username'], $config['twitter']['password']);

// Decode payload
if(get_magic_quotes_gpc()) $_POST['payload'] = stripslashes($_POST['payload']);
$payload = json_decode($_POST['payload']);

$numCommits = count($payload->commits);
$commitsPlural = $numCommits != 1 ? "s" : "";
$branch = str_replace("refs/heads/", "", $payload->ref);

// User is just the first commit author. Not necessarily correct, but it's the
// really the only way to know
$user = $payload->commits[0]->author->name;

$message = "{$user} pushed {$numCommits} commit{$commitsPlural} to {$branch}";

$twitter->updateStatus($message);
?>