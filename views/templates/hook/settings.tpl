/**
* The MIT License (MIT)
* 
* Copyright (c) 2017 CloudSwipe
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @author Joey Beninghove
* @copyright 2017 CloudSwipe
* @license https://opensource.org/licenses/MIT MIT
*/

<link href="{$module_dir|escape}views/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<div class="row cloudswipe-header">
  <div class="col-md-2">
    <h1>
      <img src="{$module_dir|escape}views/img/cloudswipe-logo.png"
          class="cloudswipe-logo" />
    </h1>
  </div>
  <div class="col-md-8 text-center">
    <h2>The Safest and Easiest Way To Accept Payments</h2>
  </div>
  <div class="col-md-2 cloudswipe-sign-up text-right">
    <a href="https://dashboard.cloudswipe.com/merchants/sign_up"
      class="btn btn-primary"
      target="_blank"><i class="fa fa-arrow-right"></i> Sign Up Free</a>
  </div>
</div>

<div class="well">
  <div class="cloudswipe-big-features">
    <div class="row text-center">
      <div class="col-md-4 cloudswipe-big-feature">
        <i class="fa fa-eyedropper fa-4x"></i>
        <h3>Keep Your Branding</h3>
        <h4 class="col-md-10 col-md-offset-1">
          Seamless integration for a hassle free experience with your branding
        </h4>
      </div>
      <div class="col-md-4 cloudswipe-big-feature cloudswipe-gateways">
        <i class="fa fa-money fa-4x"></i>
        <h3>Gateways & SSL Included</h3>
        <h4 class="col-md-10 col-md-offset-1">
          Over 150 payment gateways and SSL are all included, no need to buy add-ons
        </h4>
      </div>
      <div class="col-md-4 cloudswipe-big-feature">
        <i class="fa fa-signal fa-4x"></i>
        <h3>Increase Conversions</h3>
        <h4 class="col-md-10 col-md-offset-1">
          When your payment page keeps your branding, more customers buy
        </h4>
      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-4 cloudswipe-big-feature">
        <i class="fa fa-code fa-4x"></i>
        <h3>Complete Customization</h3>
        <h4 class="col-md-10 col-md-offset-1">
          Your hosted payment page is skinned with your actual PrestaShop theme
        </h4>
      </div>
      <div class="col-md-4 cloudswipe-big-feature">
        <i class="fa fa-lock fa-4x"></i>
        <h3>Rock Solid Security</h3>
        <h4 class="col-md-10 col-md-offset-1">
          Your entire payment page is securely served from a PCI compliant server
        </h4>
      </div>
      <div class="col-md-4 cloudswipe-big-feature">
        <i class="fa fa-moon-o fa-4x"></i>
        <h3>Peace of Mind</h3>
        <h4 class="col-md-10 col-md-offset-1">
          Sleep well knowing all your credit card transactions are safe and secure
        </h4>
      </div>
    </div>
  </div>

  <hr />

  <div class="cloudswipe-pitch-sign-up">
    <h2>Start Accepting Payments In Minutes</h2>
    <div class="row cloudswipe-pitch">
      <div class="col-md-12">
        <p>
          <strong>CloudSwipe</strong> provides a secure, PCI compliant hosted payment page without
          having to sacrifice the hard work you put into the design of your PrestaShop
          store.  With our <strong>web page cloning technology</strong>, we can make your payment page
          look exactly like the rest of your PrestaShop site with the click of a
          button.
        </p>
      </div>
    </div>
    <div class="row cloudswipe-features">
      <div class="col-md-12">
        <ul>
          <li>Customizable payment page</li>
          <li>Over 150 payment gateways, including PayPal, Authorize.net, Stripe and many more</li>
          <li>Custom subdomain</li>
          <li>SSL Included</li>
          <li>Unlimited Transactions</li>
          <li>No Transaction Fees</li>
        </ul>
      </div>
    </div>
    <div class="cloudswipe-sign-up">
      <a href="https://dashboard.cloudswipe.com/merchants/sign_up"
        class="btn btn-primary"
        target="_blank"><i class="fa fa-arrow-right"></i> Sign Up Free</a>
    </div>
  </div>
</div>

<div class="well cloudswipe-settings">
  <div class="row">
    <div class="col-md-8">
      <div class="alert alert-info">
        Once you have signed up for CloudSwipe, and are signed into your CloudSwipe
        account, click on the <strong>Keys</strong> item in the left menu.  Copy
        and paste the <strong>Secret Key</strong> shown into the form below and
        click <strong>Save Settings</strong>.
      </div>
    </div>
  </div>

  <form action="{$request_uri|escape:'UTF-8'}" method="post">
    <div class="row">
      <div class="form-group col-md-4">
        <label for="cloudswipe_secret_key" class="control-label">Secret Key</label>
        <input type="text"
              id="cloudswipe_secret_key"
              name="cloudswipe_secret_key"
              class="form-control"
              value="{$cloudswipe_secret_key|escape:'htmlall':'UTF-8'}" />
      </div>
    </div>
    <input type="submit" value="Save Settings" name="submit_cloudswipe"
      class="btn btn-default" />
  </form>

  <div class="clearfix"></div>
</div>
