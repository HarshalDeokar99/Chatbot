<?php
class Response_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    function getAns($encoded_question)
    {
        $question=base64_decode($encoded_question);
        $this->db->select('questions.question, questions.id, questions.response_id, responses.response_message');
        $this->db->from('questions');
        $this->db->join('responses', 'questions.response_id = responses.id', 'left');
        $this->db->where('questions.question', $question);
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    }

    function insertUnAns($encoded_question)
    {
        $question=base64_decode($encoded_question);
        $data = [
        'question' => $question
        ];
        $this->db->insert('unanswered', $data);
    }

    function insertFaqLog($qid)
    {
        $data = [
            'question_id' => $qid
            ];
        $this->db->insert('frequent_asks', $data);
    }

}

?>
