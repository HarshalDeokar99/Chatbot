<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {
	function __construct()
  {
      parent::__construct();
      $this->load->model('Response_model');       
  }
	public function index()
	{
      $this->load->view('chatbot');
	}

	public function getAnswer()
	{
		$input = json_decode($this->input->raw_input_stream, true); 
		$question = $input['question'] ?? ''; 

		$answer=$this->Response_model->getAns(base64_encode($question));
		$data=array();
		if(empty($answer))
		{
			$this->Response_model->insertUnAns(base64_encode($question));
			$data['message']='success';
			$data['result']="I am sorry. I can't understand your question, Please rephrase your question and make sure it is related to this site. Thank you :)";
		}
		else
		{
			//add log in faq
			$this->Response_model->insertFaqLog($answer[0]->id);
			$data['message']='success';
			$data['result']=$answer[0]->response_message;
		}
		echo json_encode($data);
	}

	public function hello()
	{
		echo "hi";
	}
}
