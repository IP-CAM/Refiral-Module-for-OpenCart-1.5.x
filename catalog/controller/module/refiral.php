<?php
/**
* @author Refiral
* @copyright Copyright (c) 2014 Refiral
* @license GPLv2
*/

class ControllerModuleRefiral extends Controller 
{
	protected $template = 'default/template/module/refiral.tpl';
	protected $order;
	protected $products;
	protected $cartInfo;

	protected function index()
	{	
		$this->data['refiral_apikey'] = $this->config->get('refiral_apikey');
		$this->data['refiral_enable'] = $this->config->get('refiral_enable');

	    $this->load->model('checkout/order');
	    $this->load->model('account/order');

	    $this->data['refiral_html'] = $this->getHtml();
 		$this->render();
	}

	/** Helper functions start **/

	// Get JS code to be embedded
	protected function getHtml()
	{
		if(!(bool)($this->data['refiral_enable']))
			$html = '<!-- Refiral module is disabled -->';
		else if(empty($this->data['refiral_apikey']))
			$html = '<!-- Refiral API Key is empty -->';
		else
		{
			$html = '<script type="text/javascript">var apiKey = "'.$this->data['refiral_apikey'].'";</script>'."\n";
			$html .= '<script type="text/javascript" src="http://www.refiral.com/api/all.js"></script>'."\n";

			if(isset($this->session->data['coupon']) && !isset($this->session->data['refiral_coupon']))
			{
				$this->session->data['refiral_coupon'] = $this->session->data['coupon'];
			}

            if (isset($this->session->data['refiral_order_id']) && isset($this->request->get['route']) &&
                $this->request->get['route'] == 'checkout/success')
            {
                $html .= $this->getInvoiceCallHtml();
                unset($this->session->data['refiral_order_id']);
            } 
            else if (isset($this->session->data['order_id']))
            {
                $this->session->data['refiral_order_id'] = $this->session->data['order_id'];
            }
		}

		return $html;
	}

	// Get JS code to be embedded on checkout page
	protected function getInvoiceCallHtml()
	{
		$this->order = $this->model_account_order->getOrder($this->session->data['refiral_order_id']); // get the order
		$this->cartInfo = $this->getCartInfo(); // get subtotal and cart info

		$order_total = round($this->order['total']); // get total amount
		$order_subtotal = round($this->cartInfo['subtotal']);

		// Check if coupon code was applied
		if (isset($this->session->data['refiral_coupon']))
		{
			$order_coupon = $this->session->data['refiral_coupon']; // get coupon code
			unset($this->session->data['refiral_coupon']); 
		}
		else
			$order_coupon = ''; // coupon code was not applied
		
		$order_cart = $this->cartInfo['productsinfo'];
		$order_name = $this->order['firstname'].' '.$this->order['lastname'];
		$order_email = $this->order['email'];

		return '<script type="text/javascript">invoiceRefiral("'.$order_total.'", "'.$order_subtotal.'", "'.$order_coupon.'", "'.$order_cart.'", "'.$order_name.'", "'.$order_email.'");</script>'."\n";
	}

	// Get subtotal of the order
	protected function getCartInfo()
	{
		$this->products = $this->model_account_order->getOrderProducts($this->order['order_id']); // get all products
		
        $return = array('subtotal' => 0, 'productsinfo' => '');
        foreach ($this->products as $product)
        {
            $return['subtotal'] += $product['total'];
            $return['productsinfo'] .= $product['product_id'].'-'.$product['quantity'].', ';
        }
        return $return;
	}

	/** Helper functions end **/
}
?>