jQuery(document).ready(function(c){"use strict";function t(e){return e.is(".processing")||e.parents(".processing").length}function i(e){t(e)||e.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}})}function s(e){e.removeClass("processing").unblock()}var a=c("textarea[name=reason]"),n=(c("select.pafw-ex-reason ").on("change",function(){var e=a.val();0<e.length&&(e+="\n"),a.val(e+c(this).val())}),c("input.request-exchange-return").on("click",function(){var a=c("#pafw_ex_wrapper");t(a)||(i(a),c.ajax({url:_pafw_ex.ajaxurl,type:"POST",dataType:"json",data:"action="+_pafw_ex.action+"&_wpnonce="+_pafw_ex._wpnonce+"&"+c("form.pafw-ex-request").serialize(),success:function(e){console.log(e),e.success?(void 0!==e.data.message&&alert(e.data.message),void 0!==e.data.redirect_url?window.location.replace(e.data.redirect_url):s(a)):(void 0!==e.data.message?alert(e.data.message):alert("처리중 오류가 발생했습니다. 관리자에게 문의해주세요."),s(a))}}))}),c("input.button.pafw-show-change-next-payment-date").on("click",function(){c(this).closest("div").css("display","none"),c(".pafw-change-next-payment-date-wrapper").css("display","flex")}),c("input.pafw-change-next-payment-date").on("click",function(){var a=c("div.woocommerce"),e=c("input[name=pafw-next-payment-date]").val();""===e?alert("변경하실 결제일을 입력해주세요."):confirm("다음 결제일을 "+e+" 로 변경하시겠습니까?")&&!t(a)&&(i(a),c.ajax({type:"POST",url:_pafw_subscription.ajax_url,data:{action:_pafw_subscription.slug+"-change_next_payment_date",subscription_id:_pafw_subscription.subscription_id,next_payment_date:e,_wpnonce:_pafw_subscription._wpnonce},success:function(e){e.success?window.location.reload():(alert(e.data),s(a))}}))}),c("table.subscription_details .cancel").on("click",function(e){e.preventDefault(),e.stopPropagation(),c.magnificPopup.open({items:{src:c(".pafw-cancel-reason-form"),type:"inline",midClick:!0},midClick:!0,closeBtnInside:!1,showCloseBtn:!1,fixedContentPos:!0})}),c(".pafw-cancel-reason-form .close").on("click",function(e){c.magnificPopup.close()}),c(".pafw-subscription-cancel-reason").on("change",function(e){var a=c("textarea[name=pafw-subscription-cancel-reason]");a.val(a.val()+c(this).val()+"\r\n")}),c("input.button.pafw-cancel-subscription").on("click",function(){var a=c("div.woocommerce"),e=c("textarea[name=pafw-subscription-cancel-reason]");_.isEmpty(e.val().trim())?alert("구독 취소 사유를 입력해주세요."):confirm("구독을 취소하시겠습니까?")&&!t(a)&&(c.magnificPopup.close(),i(a),c.ajax({type:"POST",url:_pafw_subscription.ajax_url,data:{action:_pafw_subscription.slug+"-cancel_subscription",subscription_id:_pafw_subscription.subscription_id,cancel_reason:e.val(),_wpnonce:_pafw_subscription._wpnonce},success:function(e){e.success?window.location.reload():(alert(e.data),s(a))}}))}),""),o=(c("table.my_account_orders .cancel, table.pafw-payment-details .cancel").on("click",function(e){e.preventDefault(),e.stopPropagation(),n=c(this).attr("href"),c.magnificPopup.open({items:{src:c(".pafw-cancel-reason-form"),type:"inline",midClick:!0},midClick:!0,closeBtnInside:!1,showCloseBtn:!1,fixedContentPos:!0})}),c(".pafw-order-cancel-reason").on("change",function(e){var a=c("textarea[name=pafw-order-cancel-reason]");a.val(a.val()+c(this).val()+"\r\n")}),c("input.button.pafw-cancel-order").on("click",function(){var a=c("div.woocommerce"),e=c("textarea[name=pafw-order-cancel-reason]");_.isEmpty(e.val().trim())?alert("주문 취소 사유를 입력해주세요."):confirm("주문을 취소하시겠습니까?")&&!t(a)&&(c.magnificPopup.close(),i(a),c.ajax({type:"POST",url:_pafw_order.ajax_url,data:{action:_pafw_order.slug+"-survey_cancel_reason",redirect_url:n,cancel_reason:e.val(),_wpnonce:_pafw_order._wpnonce},success:function(e){e.success?window.location.href=n:(alert(e.data),s(a))}}))}),c(".pafw-view-cash-receipt").on("click",function(){var n=c("div.woocommerce");i(n),c.ajax({type:"POST",url:_pafw_order.ajax_url,data:{action:_pafw_order.slug+"-pafw_view_receipt",order_id:c(this).data("order_id"),_wpnonce:_pafw_order._wpnonce},success:function(e){var a;e.success?null===(a=window.open("","","scrollbars=yes,width=480,height=700"))?alert("팝업이 차단되어 있습니다. 팝업설정을 변경하신 후 다시 시도해주세요."):(a.document.write(e.data),a.document.close()):alert(e.data),s(n)},error:function(e,a,t){alert(t),s(n)}})}),{$wrapper:null,$requestButton:null,init:function(){this.$wrapper=c("#pafw_ex_wrapper"),this.$exTypeSelector=c("#pafw_type_container > div",this.$wrapper),this.$requestButton=c("input.request-exchange-return",this.$wrapper),this.$productCheckBox=c(".product-checkbox > input[type=checkbox]",this.$wrapper),this.$orderItems=c(".cart-item-list",this.$wrapper),c(".exchange-item select",this.$wrapper).select2({templateResult:this._select2ItemTemplate.bind(this),templateSelection:this._select2ItemTemplate.bind(this),escapeMarkup:function(e){return e}}),this.bindEvent(),this.updateField()},bindEvent:function(){this.$requestButton.on("click",this.requestExchangeReturn.bind(this)),this.$exTypeSelector.on("click",this.updateField.bind(this)),this.$productCheckBox.on("change",this.loadExchangeProduct)},_select2ItemTemplate:function(e){if(!_.isUndefined(e.element)){var a=c(e.element),a=_.clone(a.data("params"));if(!_.isUndefined(a))return wp.template("select-item-template")({params:a}).replace("/*<![CDATA[*/","").replace("/*]]>*/","")}return e.text},requestExchangeReturn:function(){var a=this;t(this.$wrapper)||(i(this.$wrapper),c.ajax({url:_pafw_ex.ajaxurl,type:"POST",dataType:"json",data:"action="+_pafw_ex.action+"&_wpnonce="+_pafw_ex._wpnonce+"&"+c("form.pafw-ex-request").serialize(),success:function(e){console.log(e),e.success?(void 0!==e.data.message&&alert(e.data.message),void 0!==e.data.redirect_url?window.location.replace(e.data.redirect_url):s($wrapper)):(void 0!==e.data.message?alert(e.data.message):alert("처리중 오류가 발생했습니다. 관리자에게 문의해주세요."),s(a.$wrapper))}}))},updateField:function(){var e=c("input:checked",this.$exTypeSelector).val();c(".show-if-type",this.$wrapper).css("display","none"),c(".show-if-type.show-if-type-"+e,this.$wrapper).css("display","block"),"exchange"===e?this.$orderItems.each(function(e,a){var t=c(a).closest("div.cart-item-list").data("key");c(".product-checkbox input",c(a)).is(":checked")?c(".exchange-item-"+t).css("display","flex"):c(".exchange-item-"+t).css("display","none")}):c(".exchange-item").css("display","none")},loadExchangeProduct:function(){var e;"exchange"===c("input:checked",o.$exTypeSelector).val()&&(e=c(this).closest("div.cart-item-list").data("key"),c(this).is(":checked")?c(".exchange-item-"+e).css("display","flex"):c(".exchange-item-"+e).css("display","none"))}});"undefined"!=typeof _pafw_ex&&o.init()});