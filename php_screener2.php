<?php
class simpleApi {
    public function jsonToDebug($jsonText = ''): string
    {
        $data = json_decode($jsonText, true);
        $table = '';

        if (count($data)) {
            // Open the table
            $table = "<table><tr><th>Quiz</th><th>Subject</th><th>Date</th>
                       <th>Correct Answers</th><th>Total Problems</th><th>Score</th></tr>";
            // Cycle through the array
            foreach ($data as $key => $val) {
                $quiz = ($key + 1);
                $date = date('M d, Y', strtotime($val[1]));;
                $score = $this->scoreTotal($val[2], $val[3]);
                $table .= "<tr><td>$quiz</td><td>$val[0]</td><td>$date</td>";
                $table .= "<td>$val[2]</td><td>$val[3]</td><td>$score</td></tr>";
            }
            $table .= "</table>";
            return $table;
        }
        return 'No data';
    }

    private function scoreTotal($answers, $total): string
    {
        return ceil((intval($answers) / intval($total) * 100)) . '%';
    }
}

$url = "https://tthq.me/api/samplegrades.json";
$client = curl_init($url);
curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($client);
$json = new simpleApi();
echo $json->jsonToDebug($response);
