<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Email_Redirect_ext {
    public function __construct() {
        // load settings from the addon file
        $this->loadSettings();
    }

    public function activate_extension() {
        ee()->db->insert_batch('extensions', [
            [
                'class' => __CLASS__,'priority' => 1,'version' => $this->version,'enabled' => 'y','settings' => '',
                'hook' => 'email_module_send_email_end',
                'method' => 'email_redirect',
            ]
        ]);
    }

    public function disable_extension() {
        ee()->db->where('class', __CLASS__);
        ee()->db->delete('extensions');
    }

    public function email_redirect() {
        header('Location: '. $_POST['RET']);
        die();
    }

    private function loadSettings() {
        $settings = include PATH_THIRD . 'email_redirect/addon.setup.php';

        foreach ($settings as $_key => $_setting) {
            $this->{$_key} = $_setting;
        }
    }
}