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

$to  = "sergezak9@gmail.com, dev@aixsystem.com";

$subject = "New form submit at aixsystem.com by ". $data['email'];

$message = '  
<html> 
    <head> 
        <title>New form submit at aixsystem.com by '.$data['name'].' - '.$data['email'].' -</title> 
    </head> 
    <body> 
        <h3>Name: '.$data['name'].'</h3>
        <p>Email: '.$data['email'].'</p>
        <br />
        
        <p>The project is about:</p>
        <ul>'.getItems($data['project_about']).'</ul>
        <br>
        
        <p>Which devices:</p>
        <ul>'.getItems($data['device']).'</ul>
        <br>
        
        <p>Platforms:</p>
        <ul>'.getItems($data['platform']).'</ul>
        <br>
        
        <p>Deadline: '.$data['deadline'].'</p>
        <br>
        
        <p>Budget is:  '.$data['budget_amount'].' '.$data['budget_currency'].'s</p>
         
    </body> 
</html>';

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
