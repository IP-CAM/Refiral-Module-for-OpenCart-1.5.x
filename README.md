<h1>Refiral Module for OpenCart 1.5.x</h1>

<h2>Overview</h2>
Launch your referral campaign virally.
Boost your sales up to 3X with our new hybrid marketing channel. Run your personalized, easy to integrate fully automated referral program.


<h2>Getting Started</h2>
<h3>Installation</h3>
<ol>
<li>Upload the "admin" and "catalog" folders included here to your OpenCart installation, over the top of the "admin" and "catalog" folders already there.</li>
<li>Open this file - <pre>catalog/controller/checkout/success.php</pre> 
and insert this line  <pre>$this->session->data['refiral_order_id'] = $this->session->data['order_id'];</pre>

after <pre>if (isset($this->session->data['order_id'])) {</pre>

and before <pre>$this->cart->clear();</pre>
It should look like 
<pre>
if (isset($this->session->data['order_id'])) {
    $this->session->data['refiral_order_id'] = $this->session->data['order_id'];
	$this->cart->clear();
    ...
    ...
</pre>
</li>

<li>Once you have inserted the code, open admin panel and go to "Extensions"->"Modules".</li>
<li>In the modules list, find "Refiral - Launch your referral campaign virally" and click on "Install".</li>
<li>You have successfully installed Refiral module.</li>
</ol>

<h3>Activating Campaign</h3>
<ol>
<li>After installation, click on "Edit" to edit the module settings.</li>
<li>Add "Refiral API Key" (get it by signing up on Refiral.com) and select Enabled from "Enable Campaign" drop-down option.</li>
<li>Click on "Save" button.</li>
</ol>
<br/>
Congratulations, you have successfully integrated Refiral with your store.

<strong><a href="http://www.refiral.com" target="_blank">Refiral.com</a></strong>
