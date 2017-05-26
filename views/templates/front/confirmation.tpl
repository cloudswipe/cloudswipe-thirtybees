{**
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
*}
{if isset($status) && ($status == 'ok')}
    <h3>{l s='Your order on %s is complete.' sprintf=[$shop_name] mod='cloudswipepayments'}</h3>
    <p>
        <br/>- {l s='Amount' mod='cloudswipepayments'} : <span class="price"><strong>{$total|escape:'htmlall':'UTF-8'}</strong></span>
        <br/>- {l s='Reference' mod='cloudswipepayments'} : <span class="reference"><strong>{$reference|escape:'html':'UTF-8'}</strong></span>
        <br/><br/>{l s='An email has been sent with this information.' mod='cloudswipepayments'}
        <br/><br/>{l s='If you have questions, comments or concerns, please contact our' mod='cloudswipepayments'} <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='cloudswipepayments'}</a>
    </p>
{else}
    <h3>{l s='Your order on %s has not been accepted.' sprintf=[$shop_name] mod='cloudswipepayments'}</h3>
    <p>
    <p>
        <br/>- {l s='Reference' mod='cloudswipepayments'} <span class="reference"> <strong>{$reference|escape:'html':'UTF-8'}</strong></span>
        <br/><br/>{l s='Please, try to order again.' mod='cloudswipepayments'}
        <br/><br/>{l s='If you have questions, comments or concerns, please contact our' mod='cloudswipepayments'} <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='cloudswipepayments'}</a>
    </p>
{/if}
<hr/>
