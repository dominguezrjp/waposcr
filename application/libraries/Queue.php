<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue {

  private $CI;

  public function __construct() {
    $this->CI =& get_instance();
    // Load the database library
    $this->CI->load->database();
  }

  public function push($job, $data = '', $queue = null) {
    // Insert the job into the jobs table
    $data = array(
      'queue' => $queue ?: 'default',
      'payload' => json_encode($data),
      'attempts' => 0,
      'available_at' => time(),
      'created_at' => time()
    );
    $this->CI->db->insert('jobs', $data);
  }

  public function pop($queue = null) {
    // Get the next available job from the jobs table
    $query = $this->CI->db->select('*')->from('jobs')->where('queue', $queue ?: 'default')->where('reserved_at', null)->where('available_at', '<=', time())->order_by('id', 'asc')->limit(1)->get();
    $row = $query->row();

    if ($row) {
      // Mark the job as reserved and return its payload
      $id = $row->id;
      $data = json_decode($row->payload, true);
      $this->CI->db->where('id', $id)->update('jobs', array('reserved_at' => time()));
      return $data;
    } else {
      return null;
    }
  }

  public function release($job) {
    // Mark the job as available again
    $this->CI->db->where('id', $job->id)->update('jobs', array('reserved_at' => null));
  }

  public function delete($job) {
    // Delete the job from the jobs table
    $this->CI->db->where('id', $job->id)->delete('jobs');
  }

  public function attempts($job) {
    // Get the number of attempts for the job
    return $job->attempts;
  }

  public function incrementAttempts($job) {
    // Increment the number of attempts for the job
    $this->CI->db->where('id', $job->id)->set('attempts', $job->attempts + 1)->update('jobs');
  }

}


// $this->load->library('queue');
// $this->queue->push('SendEmail', array('to' => 'example@example.com', 'subject' => 'Test Email', 'message' => 'This is a test email.'));


// Create a MySQL database table named "jobs" with the following columns:
// id (int, primary key, auto-increment)
// queue (varchar)
// payload (text)
// attempts (int, default 0)
// reserved_at (timestamp, nullable)
// available_at (timestamp)
// created_at (timestamp)