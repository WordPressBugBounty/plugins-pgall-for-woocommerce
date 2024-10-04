jQuery(function(i){"use strict";var o={$forms:[],$wrapper:i(".pafw-checkout-wrap"),is_blocked:function(e){return(e=0<this.$wrapper.length?this.$wrapper:e).is(".processing")||e.parents(".processing").length},block:function(e){0<this.$wrapper.length&&(e=this.$wrapper),o.is_blocked(e)||(e.addClass("processing").block({message:i('<div class="ajax-loader"/>'),overlayCSS:{background:"#fff",opacity:.6}}),o.$forms.push(e))},unblock:function(){_.each(o.$forms,function(e,t){e.removeClass("processing").unblock()}),o.$forms=[]}};function t(e){void 0===e.data("pafwBACS")&&(this.$element=e,this._init(),e.data("pafwBACS",this))}t.prototype._init=function(){this._bindEventHandler()},t.prototype._bindEventHandler=function(){i("input[name=pafw_change_bacs_receipt_info]",this.$element).on("click",this._changeReceiptInfo.bind(this)),i("input[name=pafw_bacs_receipt_issue]",this.$element).on("click",this._refresh.bind(this)),i("input[name=pafw_bacs_receipt_usage]",this.$element).on("click",this._refresh.bind(this)),i("select[name=pafw_bacs_receipt_issue_type]",this.$element).on("change",this._refresh.bind(this)),this._refresh()},t.prototype._changeReceiptInfo=function(){i(".pafw_bacs_default_info",this.$element).css("display","none"),i("input[name=pafw_bacs_receipt_use_default]",this.$element).val("no"),this._refresh()},t.prototype._refresh=function(){var e;"yes"!==i("input[name=pafw_bacs_receipt_use_default]",this.$element).val()&&(i(".pafw_bacs_receipt",this.$element).css("display","block"),e=i("input[name=pafw_bacs_receipt_issue]:checked",this.$element).val(),i("div.receipt_issue",this.$element).css("display","none"),i("div.receipt_issue.receipt_issue_"+e,this.$element).css("display","block"),e=i("input[name=pafw_bacs_receipt_usage]:checked",this.$element).val(),i("div.receipt_usage",this.$element).css("display","none"),i("div.receipt_usage.receipt_usage_"+e,this.$element).css("display","flex"))},i.fn.pafw_hook={hooks:[],add_filter:function(e,t){void 0===i.fn.pafw_hook.hooks[e]&&(i.fn.pafw_hook.hooks[e]=[]),i.fn.pafw_hook.hooks[e].push(t)},apply_filters:function(e,t){if(void 0!==i.fn.pafw_hook.hooks[e])for(var a=0;a<i.fn.pafw_hook.hooks[e].length;++a)t[0]=i.fn.pafw_hook.hooks[e][a](t);return t[0]}},i.fn.pafw=function(t){if("object"==typeof(t=t||{}))return this.each(function(){var e=i.extend({paymentMethods:_pafw.gateway,isOrderPay:_pafw.is_checkout_pay_page,isSimplePay:!1,ajaxUrl:_pafw.ajax_url,slug:_pafw.slug,gatewayDomain:_pafw.gateway_domain,forms:i(".pafw-checkout-block form")},t);new a(i(this),e)}),this;throw new Error("잘못된 호출입니다.: "+t)};var a=function(e,t){void 0===e.data("pafw")&&(this.$element=e,this.$paymentForm=t.forms,this.options=t||{},this.uuid=this._generateUUID(),this._registerHandler(),e.data("pafw",this))};a.prototype._ajaxUrl=function(){var e;return"yes"===this.options.isSimplePay?1<(e=this.options.ajaxUrl.split("?")).length?e[0]+"?action="+this.options.slug+"-pafw_simple_payment&"+e[1]:this.options.ajaxUrl+"?action="+this.options.slug+"-pafw_simple_payment":_pafw.wc_checkout_url},a.prototype._generateUUID=function(){var a=(new Date).getTime();return"pafw_"+"xxxxxxxxxxxxxxxxxxxx".replace(/[x]/g,function(e){var t=(a+16*Math.random())%16|0;return a=Math.floor(a/16),("x"===e?t:3&t|8).toString(16)})},a.prototype._paymentComplete=function(e){window.location.href=e},a.prototype._paymentCancel=function(){i("#"+this.uuid).remove(),o.unblock()},a.prototype._paymentFail=function(e){var t=this;setTimeout(function(){alert(e),i("#"+t.uuid).remove(),o.unblock()})},a.prototype._registerHandler=function(){this.$element.on("click",this.processPayment.bind(this)),0<i(".pafw_bacs_receipt_wrapper",i(".pafw-checkout-block.pafw-payment-methods-block")).length&&_.each(i(".pafw_bacs_receipt_wrapper",i(".pafw-checkout-block.pafw-payment-methods-block")),function(e){new t(i(e))})},a.prototype._processPostMessage=function(e){e.origin===this.options.gatewayDomain&&("pafw_cancel_payment"===e.data.action||"pafw_payment_fail"===e.data.action?i.fn.payment_fail(e.data.message):"pafw_payment_complete"===e.data.action&&i.fn.payment_complete(e.data.redirect_url))},a.prototype._registerPaymentCallback=function(){i.fn.payment_complete=this._paymentComplete.bind(this),i.fn.payment_cancel=this._paymentCancel.bind(this),i.fn.payment_fail=this._paymentFail.bind(this),_.isUndefined(i.fn.pafwPostMessageHandler)||window.removeEventListener("message",i.fn.pafwPostMessageHandler,!0),i.fn.pafwPostMessageHandler=this._processPostMessage.bind(this),window.addEventListener("message",i.fn.pafwPostMessageHandler,!0)},a.prototype.openPaymentWindow=function(e,t){_.isUndefined(t.redirect_url)||_.isEmpty(t.redirect_url)?_.isUndefined(t.redirect)||_.isEmpty(t.redirect)?(document.getElementById(e)||i(document.body).append('<div id="'+e+'" style="width: 100%;height: 100%;position: fixed;top: 0;z-index: 99999;"></div>'),i("#"+e).empty().append(t.payment_form)):window.location.href=t.redirect:window.location.href=t.redirect_url},a.prototype.processPayment=function(){var a=this.uuid,n=this;if(this.$paymentForm=i(".pafw-checkout-block form:not(.no-submit)"),!1!==i(document).triggerHandler("pafw_process_payment",this)){if(!1!==i("form.pafw-checkout.pafw-payment-methods").triggerHandler("pafw_process_payment_"+i('[name="payment_method"]').val(),this)){if(o.is_blocked(this.$paymentForm))return!1;o.block(i(".pafw-checkout-block form:not(.no-submit), .pafw-need-block")),this._registerPaymentCallback(),i.ajax({type:"POST",url:this._ajaxUrl(),data:this.$paymentForm.serialize(),success:function(e){var t="";try{if(0<=(e=0<=e.indexOf("\x3c!--WC_START--\x3e")?e.split("\x3c!--WC_START--\x3e")[1]:e).indexOf("\x3c!--WC_END--\x3e")&&(e=e.split("\x3c!--WC_END--\x3e")[0]),"success"!==(t=i.parseJSON(e)).result)throw"Invalid response";n.openPaymentWindow(a,t)}catch(e){!0===t.reload||"true"===t.reload?window.location.reload():("true"===t.refresh&&i("body").trigger("update_checkout"),n.submitError(t.messages),"failure"===t.result&&t.messages&&i.fn.pafw_alert(t.messages,!1),o.unblock())}},dataType:"html"})}return!1}},a.prototype.submitError=function(e){this.$paymentForm.removeClass("processing").unblock(),this.$paymentForm.find(".input-text, select, input:checkbox").trigger("validate").blur(),i(document.body).trigger("checkout_error",[e])},a.prototype.processOrderPay=function(){var t=this.uuid,a=this,e=i("input[name=payment_method]:checked",this.$paymentForm).val();return-1===_.flatten(_.values(this.options.paymentMethods)).indexOf(e)||(o.is_blocked(this.$paymentForm)||(o.block(this.$paymentForm),this._registerPaymentCallback(),i.ajax({type:"POST",url:_pafw.ajax_url,data:{action:_pafw.slug+"-pafw_ajax_action",payment_method:e,payment_action:"process_order_pay",order_id:_pafw.order_id,order_key:_pafw.order_key,data:this.$paymentForm.serialize(),_wpnonce:_pafw._wpnonce},success:function(e){void 0!==e&&void 0!==e.success&&!0===e.success?a.openPaymentWindow(t,e.data):alert(e.data),o.unblock()}})),!1)},a.prototype.destroy=function(){},i("body").trigger("pafw_init_hook"),_.each(i("input.pafw-payment"),function(e,t){i(e).pafw()}),i(document).bind("fragment_updated",function(e,t){0<_.intersection(t,["payment-methods"]).length&&(_.each(i("input.pafw-payment"),function(e,t){i(e).pafw()}),i(".pafw-card-field-wrap").each(function(e,t){i(t).CardJs()}))})});