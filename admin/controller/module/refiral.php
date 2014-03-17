<?php
/**
* @author Refiral
* @copyright Copyright (c) 2014 Refiral
* @license GPLv2
*/

class ControllerModuleRefiral extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/refiral');
		$this->load->model('setting/setting');
      	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('refiral', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		/*
		 * Static text
		 */
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['text_account_setting'] = $this->language->get('text_account_setting');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['entry_apikey'] = $this->language->get('entry_apikey');
		$this->data['entry_enable'] = $this->language->get('entry_enable');	

		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['button_add_module'] = $this->language->get('button_add_module');					
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
		$this->document->setTitle($this->data['heading_title']);

		/*
		 * Setting of breadcrumbs
		 */
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
		);		
		$this->data['breadcrumbs'][] = array(
	       		'text'      => $this->language->get('text_module'),
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
	      		'separator' => ' :: '
	      		);

	   $this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/refiral', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
      	);
		/*
		 * cancel and save
		 */
      	$this->data['action'] = $this->url->link('module/refiral', 'token=' . $this->session->data['token'], 'SSL');
      	$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

      	if (isset($this->request->post['refiral_apikey'])) {
      		$this->data['refiral_apikey'] = $this->request->post['refiral_apikey'];
      	} else {
      		$this->data['refiral_apikey'] = $this->config->get('refiral_apikey');
      	}  	
		if (isset($this->request->post['refiral_enable'])) {
      		$this->data['refiral_enable'] = $this->request->post['refiral_enable'];
      	} else {
      		$this->data['refiral_enable'] = $this->config->get('refiral_enable');
      	}

      	$this->data['modules'] = array();
      	if (isset($this->request->post['refiral_module'])) {
      		$this->data['modules'] = $this->request->post['refiral_module'];
      	} elseif ($this->config->get('refiral_module')) {
      		$this->data['modules'] = $this->config->get('refiral_module');
      	}

      	$this->load->model('design/layout');
      	$this->data['layouts'] = $this->model_design_layout->getLayouts();
      	$this->template = 'module/refiral.tpl';
      	$this->children = array(
		'common/header',
		'common/footer',
      	);

      	$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/refiral')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
