<?php

class SimpleLogger {
    private $filename;
    private $min_loglevel;

    private $date_fmt;

    private $email;
    private $min_email_loglevel;

    private $min_stdout_loglevel;

    private $log_msg = array (
        LOG_DEBUG => 'DEBUG',
        LOG_INFO => 'INFO',
        LOG_NOTICE => 'NOTICE',
        LOG_WARNING => 'WARNING',
        LOG_ERR => 'ERROR',
        LOG_CRIT => 'CRITICAL',
        LOG_ALERT => 'ALERT',
        LOG_EMERG => 'EMERG'
    );

    public function __construct($filename, $min_loglevel = LOG_INFO) {
        $this->filename = $filename;
        $this->min_loglevel = $min_loglevel;

        $this->date_fmt = 'Y-m-d H:i:s';

        $this->email = NULL;
        $this->app_name = NULL;
        $this->min_email_loglevel = NULL;

        $this->min_stdout_loglevel = NULL;
    }

    public function setDateFormat($date_fmt) {
        $this->date_fmt = $date_fmt;
    }

    public function setEmailHandler($email, $app_name = '', $min_loglevel = LOG_ERR) {
        $this->email = $email;
        $this->app_name = $app_name;
        $this->min_email_loglevel = $min_loglevel;
    }

    public function setStdOutLevel($min_loglevel = LOG_ERR) {
        $this->min_stdout_loglevel = $min_loglevel;
    }

    private function writeMsg($message, $loglevel) {
        if ($loglevel <= $this->min_loglevel) {
            $date = date($this->date_fmt);
            $msg = "[$date] " . $this->log_msg[$loglevel] . " $message" . PHP_EOL;

            return file_put_contents($this->filename, $msg, FILE_APPEND);
        } else {
            return 0;
        }
    }

    private function emailMsg($message, $loglevel) {
        if (!is_null($this->email) && $loglevel <= $this->min_email_loglevel) {
            return mail($this->email, $this->log_msg[$loglevel] . " - $this->app_name", $message);
        } else {
            return 0;
        }
    }

    private function stdoutMsg($message, $loglevel) {
        if (!is_null($this->min_stdout_loglevel) && $loglevel <= $this->min_stdout_loglevel) {
            $date = date($this->date_fmt);
            $msg = "[$date] " . $this->log_msg[$loglevel] . " $message" . PHP_EOL;

            echo $msg;
        }
    }

    public function log($message, $loglevel = LOG_INFO) {
            $status = $this->writeMsg($message, $loglevel);
            if ($status === false && !is_null($this->min_stdout_loglevel)) {
                $this->stdoutMsg("Failed to log message to file $this->filename", LOG_CRIT);
            }

            $status = $this->emailMsg($message, $loglevel);
            if ($status === false) {
                $this->writeMsg("Failed to send email to '$this->email'", LOG_CRIT);
            }
            if ($status === true) {
                $this->writeMsg("Email sent to '$this->email'", LOG_DEBUG);
            }

            $this->stdoutMsg($message, $loglevel);
    }
}

?>
