jQuery(function(a){"use strict";function t(e){void 0===e.data("pafwBACS")&&(this.$element=e,this._init(),e.data("pafwBACS",this))}t.prototype._init=function(){a("body").on("updated_checkout",this._bindEventHandler.bind(this))},t.prototype._bindEventHandler=function(){a("input[name=pafw_change_bacs_receipt_info]",this.$element).on("click",this._changeReceiptInfo.bind(this)),a("input[name=pafw_bacs_receipt_issue]",this.$element).on("click",this._refresh.bind(this)),a("input[name=pafw_bacs_receipt_usage]",this.$element).on("click",this._refresh.bind(this)),a("select[name=pafw_bacs_receipt_issue_type]",this.$element).on("change",this._refresh.bind(this)),this._refresh()},t.prototype._changeReceiptInfo=function(){a(".pafw_bacs_default_info",this.$element).css("display","none"),a("input[name=pafw_bacs_receipt_use_default]",this.$element).val("no"),this._refresh()},t.prototype._refresh=function(){var e;"yes"!==a("input[name=pafw_bacs_receipt_use_default]",this.$element).val()&&(a(".pafw_bacs_receipt").css("display","block"),e=a("input[name=pafw_bacs_receipt_issue]:checked",this.$element).val(),a("div.receipt_issue").css("display","none"),a("div.receipt_issue.receipt_issue_"+e).css("display","block"),e=a("input[name=pafw_bacs_receipt_usage]:checked",this.$element).val(),a("div.receipt_usage").css("display","none"),a("div.receipt_usage.receipt_usage_"+e).css("display","flex"))};var e=a(_pafw.checkout_form_selector),i={$forms:[],is_blocked:function(e){return e.is(".processing")||e.parents(".processing").length},block:function(e){i.is_blocked(e)||(e.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),i.$forms.push(e))},unblock:function(){_.each(i.$forms,function(e,t){e.removeClass("processing").unblock()}),i.$forms=[]}},o=(a.fn.pafw_hook={hooks:[],add_filter:function(e,t){void 0===a.fn.pafw_hook.hooks[e]&&(a.fn.pafw_hook.hooks[e]=[]),a.fn.pafw_hook.hooks[e].push(t)},apply_filters:function(e,t){if(void 0!==a.fn.pafw_hook.hooks[e])for(var o=0;o<a.fn.pafw_hook.hooks[e].length;++o)t[0]=a.fn.pafw_hook.hooks[e][o](t);return t[0]}},a.fn.pafw=function(t){if("object"==typeof(t=t||{}))return this.each(function(){var e=a.extend({paymentMethods:_pafw.gateway,isOrderPay:_pafw.is_checkout_pay_page,isSimplePay:_pafw.simple_pay,ajaxUrl:_pafw.ajax_url,slug:_pafw.slug,gatewayDomain:_pafw.gateway_domain},t);new o(a(this),e)}),this;throw new Error("잘못된 호출입니다.: "+t)},function(e,t){void 0===e.data("pafw")&&(this.$paymentForm=e,this.options=t||{},this.uuid=this._generateUUID(),this._registerHandler(),e.data("pafw",this))});o.prototype._ajaxUrl=function(){var e;return"yes"===this.options.isSimplePay?1<(e=this.options.ajaxUrl.split("?")).length?e[0]+"?action="+this.options.slug+"-pafw_simple_payment&"+e[1]:this.options.ajaxUrl+"?action="+this.options.slug+"-pafw_simple_payment":wc_checkout_params.checkout_url},o.prototype._generateUUID=function(){var o=(new Date).getTime();return"pafw_"+"xxxxxxxxxxxxxxxxxxxx".replace(/[x]/g,function(e){var t=(o+16*Math.random())%16|0;return o=Math.floor(o/16),("x"===e?t:3&t|8).toString(16)})},o.prototype._paymentComplete=function(e){window.location.href=e},o.prototype._paymentCancel=function(){_pafw.is_mobile&&a("html").removeClass("pafw-payment"),a("#"+this.uuid).remove(),i.unblock()},o.prototype._paymentFail=function(e){setTimeout(function(){_pafw.is_mobile&&a("html").removeClass("pafw-payment"),a("#"+this.uuid).remove(),alert(e),i.unblock()}.bind(this))},o.prototype._maybeSetTokenInfo=function(e){e=a(e.target).closest("li");"token"===e.data("method_type")?(a('input[name="issavedtoken"]',this.$paymentForm).val(1),a('input[name="token"]',this.$paymentForm).val(e.data("token"))):(a('input[name="issavedtoken"]',this.$paymentForm).val(""),a('input[name="token"]',this.$paymentForm).val(""))},o.prototype._registerHandler=function(){this.gateways=a.fn.pafw_hook.apply_filters("pafw_gateway_objects",[this.options.paymentMethods]);var e=_.flatten(_.values(this.options.paymentMethods)).map(function(e){return"checkout_place_order_"+e}).join(" ");this.options.isOrderPay?this.$paymentForm.on("submit",this.processOrderPay.bind(this)):this.$paymentForm.on(e,this.processPayment.bind(this)),0<a(".pafw_bacs_receipt_wrapper",this.$paymentForm).length&&new t(this.$paymentForm),0<a("li[data-method_type=token]").length&&(a("input[name=payment_method]").on("click",this._maybeSetTokenInfo.bind(this)),(0<_pafw.customer_default_token?a("li[data-token="+_pafw.customer_default_token+"] input"):a("li[data-method_type=token]:first input")).trigger("click")),a("body").on("updated_checkout",this._bindEventHandler.bind(this))},o.prototype._bindEventHandler=function(){a("input[name=payment_method]").on("click",this._maybeSetTokenInfo.bind(this))},o.prototype._processPostMessage=function(e){e.origin===this.options.gatewayDomain&&("pafw_cancel_payment"===e.data.action||"pafw_payment_fail"===e.data.action?a.fn.payment_fail(e.data.message):"pafw_payment_complete"===e.data.action&&a.fn.payment_complete(e.data.redirect_url))},o.prototype._registerPaymentCallback=function(){a.fn.payment_complete=this._paymentComplete.bind(this),a.fn.payment_cancel=this._paymentCancel.bind(this),a.fn.payment_fail=this._paymentFail.bind(this),_.isUndefined(a.fn.pafwPostMessageHandler)||window.removeEventListener("message",a.fn.pafwPostMessageHandler,!0),a.fn.pafwPostMessageHandler=this._processPostMessage.bind(this),window.addEventListener("message",a.fn.pafwPostMessageHandler,!0)},o.prototype.openPaymentWindow=function(e,t){_.isUndefined(t.redirect_url)||_.isEmpty(t.redirect_url)?(document.getElementById(e)||a(document.body).append('<div id="'+e+'" class="pafw-payment-form" style="width: 100%;height: 100%;position: fixed;top: 0;left:0;z-index: 99999;outline: none !important;"></div>'),_pafw.is_mobile&&a("html").addClass("pafw-payment"),a("#"+e).empty().append(t.payment_form)):window.location.href=t.redirect_url},o.prototype.processPayment=function(){var o=this.uuid,n=this;if(!1!==this.$paymentForm.triggerHandler("pafw_process_payment_"+a('input[name="payment_method"]:checked',this.$paymentForm).val())){if(i.is_blocked(this.$paymentForm))return!1;i.block(this.$paymentForm),this._registerPaymentCallback(),a.ajax({type:"POST",url:this._ajaxUrl(),data:this.$paymentForm.serialize(),success:function(e){var t="";try{if(0<=(e=0<=e.indexOf("\x3c!--WC_START--\x3e")?e.split("\x3c!--WC_START--\x3e")[1]:e).indexOf("\x3c!--WC_END--\x3e")&&(e=e.split("\x3c!--WC_END--\x3e")[0]),"success"!==(t=a.parseJSON(e)).result)throw"Invalid response";n.openPaymentWindow(o,t)}catch(e){!0===t.reload||"true"===t.reload?window.location.reload():("true"===t.refresh&&a("body").trigger("update_checkout"),n.submitError(t.messages),i.unblock())}},dataType:"html"})}return!1},o.prototype.submitError=function(e){a(".woocommerce-NoticeGroup-checkout, .woocommerce-error, .woocommerce-message").remove(),this.$paymentForm.prepend('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">'+e+"</div>"),this.$paymentForm.removeClass("processing").unblock(),this.$paymentForm.find(".input-text, select, input:checkbox").trigger("validate").blur(),this.scrollToNotices(),a(document.body).trigger("checkout_error",[e])},o.prototype.scrollToNotices=function(e){var t=a(".woocommerce-NoticeGroup-updateOrderReview, .woocommerce-NoticeGroup-checkout");t.length||(t=a(".form.checkout")),a.scroll_to_notices(t)},o.prototype.processOrderPay=function(){var t=this.uuid,o=this,e=a("input[name=payment_method]:checked",this.$paymentForm).val();return-1===_.flatten(_.values(this.options.paymentMethods)).indexOf(e)||(i.is_blocked(this.$paymentForm)||(i.block(this.$paymentForm),this._registerPaymentCallback(),a.ajax({type:"POST",url:_pafw.ajax_url,data:{action:_pafw.slug+"-pafw_ajax_action",payment_method:e,payment_action:"process_order_pay",order_id:_pafw.order_id,order_key:_pafw.order_key,data:this.$paymentForm.serialize(),_wpnonce:_pafw._wpnonce},success:function(e){!_.isUndefined(e.success)&&e.success?o.openPaymentWindow(t,e.data):(alert(_.isUndefined(e.messages)?e.data:e.messages),i.unblock())}})),!1)},o.prototype.destroy=function(){},a("body").trigger("pafw_init_hook"),_.each(e,function(e,t){a(e).pafw()})});