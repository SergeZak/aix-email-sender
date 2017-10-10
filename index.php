<?php

function getItems(array $someArray)
{
    $listItems = '';

    foreach ($someArray as $item){
        $listItems .= '<li>'.$item.'</li>';
    }

    return $listItems;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || count($data) === 0) {
    echo json_encode(['error'=> 'There is no data']);
    die();
}


$to  = "dev@aixsystem.com,p.khosro@gmail.com,sergezak9@gmail.com";

$subject = "New form submit at aixsystem.com by ". $data['email'];

$message = '  
<html><head> 
<title>New form submit at aixsystem.com by '.$data['name'].' - '.$data['email'].' -</title> 
</head><body>';

$message .= '
    <h3>Name: '.$data['name'].'</h3>
    <p>Email: '.$data['email'].'</p>
    <br />
    
    <p>The project is about: '.$data['project_about'].'</p>
    <br>
   
';

if (count($data['website_purposes'])) {
    $message .= '
        <p>Website Purposes:</p>
        <ul>'.getItems($data['website_purposes']).'</ul>
        <br>    
    ';
}

if ($data['website_auditory'] != '') {
    $message .= '<p>Target website auditory is: '.$data['website_auditory'].'</p><br>';
}


if (count($data['device'])) {
    $message .= '
        <p>Which devices:</p>
        <ul>'.getItems($data['device']).'</ul>
        <br>   
    ';
}


if (count($data['platform'])) {
    $message .= '
        <p>Platforms:</p>
        <ul>'.getItems($data['platform']).'</ul>
        <br>   
    ';
}

if ($data['project_business_case'] != '') {
    $message .= '<p>Does client have his own business case: '.$data['project_business_case'].'</p><br>';
}


if ($data['problem_to_be_solved'] != '') {
    $message .= '<p>Problems to be solved: '.$data['problem_to_be_solved'].'</p><br>';
}

if ($data['end_product_goal'] != '') {
    $message .= '<p>The goal of the end product: '.$data['end_product_goal'].'</p><br>';
}

if ($data['technology_preference'] != '') {
    $message .= '<p>Does client have technology preferences: '.$data['technology_preference'].'</p><br>';
}

if ($data['technology_preference_description'] != '') {
    $message .= '<p>Technology preferences description: '.$data['technology_preference_description'].'</p><br>';
}

$message .= '
    <p>Budget is:  '.$data['budget_amount'].' '.$data['budget_currency'].'s</p>
    <br />
    
    <p>Deadline: '.$data['deadline'].'</p>
    <br />
    
    <p>Comment: '.$data['comment'].'</p>
    <br />
';

$message .= '</body></html>';

$headers  = "Content-type: text/html; charset=utf8";

$result = mail($to, $subject, $message, $headers);

if ($result) {
    $response = [
        'data' => $data,
        'success' => true,
        'message' => $message
    ];
}
else {
    $response = [
        'success' => false
    ];
}

echo json_encode($response);
