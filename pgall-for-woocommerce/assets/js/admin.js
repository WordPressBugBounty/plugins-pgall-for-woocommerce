jQuery(document).ready(function(i){"use strict";function e(){return a.is(".processing")||a.parents(".processing").length}function c(){e()||a.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}})}function r(){a.removeClass("processing").unblock()}var a=i("[id^=pafw-order].postbox");({init:function(){i("#pafw-refund-request").on("click",this.refund_request),i("#pafw-repay-request").on("click",this.reqay_request),i("#pafw-check-receipt").on("click",this.check_receipt),i(".pafw-check-additional-charge-receipt").on("click",this.check_additional_charge_receipt),i("#pafw-escrow-register-delivery-info").on("click",{escrow_type:"I"},this.escrow_register_delivery_info),i("#pafw-escrow-modify-delivery-info").on("click",{escrow_type:"U"},this.escrow_register_delivery_info),i("#pafw-escrow-approve-reject").on("click",this.escrow_approve_reject),i("#pafw-vbank-refund-request").on("click",this.vbank_refund_request),i("#pafw-subscription-additional-charge").on("click",this.subscription_additional_charge),i("input.pafw-subscription-cancel-additional-charge").on("click",this.subscription_cancel_additional_charge),i("#pafw-cancel-batch-key").on("click",this.cancel_batch_key),i("#pafw-cash-amount").on("click",this.cash_amount),i("#pafw-cash-receipt").on("click",this.cash_receipt),i("#pafw-cancel-receipt").on("click",this.cancel_receipt),i("#pafw-view-receipt").on("click",this.view_receipt),i("#pafw-update-receipt-info").on("click",this.update_receipt_info),i("select[name=pafw_bacs_receipt_usage]").on("change",function(){i("div.receipt_usage").css("display","none"),i("div.receipt_usage.receipt_usage_"+i(this).val()).css("display","flex")}),i(".pafw_payment_info.bacs_receipt select, .pafw_payment_info.bacs_receipt input").on("change",function(){i("#pafw-cash-receipt").attr("disabled","disabled"),i("#pafw-update-receipt-info").removeAttr("disabled")})},refund_request:function(){var a;e()||(a={action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,order_id:_pafw_admin.order_id,_wpnonce:_pafw_admin._wpnonce,payment_action:"refund_request"},confirm("전체취소를 진행하시겠습니까?\n주문건의 전체항목이 취소가 됩니다.")&&(c(),i.post(ajaxurl,a,function(a){a?"true"==a.success||a.success?(alert(a.data),location.reload()):alert(a.data):alert("전체취소 요청 결과를 수신하지 못하였습니다.\n처리 결과 확인을 위해 영수증을 확인해 보시기 바랍니다."),r()})))},reqay_request:function(){var a;e()||(a={action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,order_id:_pafw_admin.order_id,amount:i("#repay_price").val(),_wpnonce:_pafw_admin._wpnonce,payment_action:"repay_request"},confirm("부분취소처리를 진행하시겠습니까?\n\n1) 부분취소는 매입후 취소이기 때문에 당일 처리가 되지 않습니다.\n2) 부분취소 처리를 한 경우 전체 금액 취소가 불가능하며, 남은잔액을 모두 입력하여 취소 처리만 가능합니다.\n\n - 취소 요청 금액 : "+jQuery("#repay_price").val())&&(c(),i.post(ajaxurl,a,function(a){a?a.success?(alert(a.data),location.reload()):(alert(a.data),r()):(alert("부분취소 처리결과를 수신하지 못하였습니다.\n처리 결과 확인을 위해 영수증을 확인해 보시기 바랍니다."),r())})))},check_receipt:function(){var a="",e="";_.isEmpty(_pafw_admin.receipt_popup_params)||_.isEmpty(_pafw_admin.receipt_popup_params.name)||(a=_pafw_admin.receipt_popup_params.name),_.isEmpty(_pafw_admin.receipt_popup_params)||_.isEmpty(_pafw_admin.receipt_popup_params.features)||(e=_pafw_admin.receipt_popup_params.features),window.open(_pafw_admin.receipt_url,a,e)},check_additional_charge_receipt:function(){var a="",e="";_.isEmpty(_pafw_admin.receipt_popup_params)||_.isEmpty(_pafw_admin.receipt_popup_params.name)||(a=_pafw_admin.receipt_popup_params.name),_.isEmpty(_pafw_admin.receipt_popup_params)||_.isEmpty(_pafw_admin.receipt_popup_params.features)||(e=_pafw_admin.receipt_popup_params.features),window.open(i(this).data("receipt_url"),a,e)},escrow_register_delivery_info:function(a){var e=i("#pafw-order-escrow #tracking_number").val();""===e?alert("송장번호를 입력해주세요."):confirm("배송 정보를 등록하시겠습니까?")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,order_id:_pafw_admin.order_id,tracking_number:e,_wpnonce:_pafw_admin._wpnonce,escrow_type:a.data.escrow_type,payment_action:"escrow_register_delivery_info"},success:function(a){a.success?(alert("배송정보 등록이 완료되었습니다.\n\n고객님께 물품 수령후에 에스크로 구매확인 및 거절 의사를 표시 요청을 하셔야 합니다."),window.location.reload()):(alert("관리자에게 문의하여주세요.\n\n에러 메시지 : \n"+a.data),r())}}))},escrow_approve_reject:function(){confirm("정말 환불 처리하시겠습니까?\n\n처리 이후에 이전 상태로 되돌릴 수 없습니다. 신중하게 선택해주세요.")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"escrow_approve_reject",order_id:_pafw_admin.order_id,_wpnonce:_pafw_admin._wpnonce},success:function(a){a.success?(alert(a.data),window.location.reload()):(alert(a.data),r())}}))},vbank_refund_request:function(){var a=i("#vbank_refund_bank_code").val(),e=i("#vbank_refund_acc_num").val(),n=i("#vbank_refund_acc_name").val(),t=i("#vbank_refund_reason").val();""===a?alert("환불 은행을 선택해주세요."):""===e?alert("환불 계좌번호를 입력해주세요."):""===n?alert("환불 계좌주명을 입력해주세요."):confirm("정말 환불 처리하시겠습니까?\n\n처리 이후에 이전 상태로 되돌릴 수 없습니다. 신중하게 선택해주세요.")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"vbank_refund_request",order_id:_pafw_admin.order_id,refund_bank_code:a,refund_acc_num:e,refund_acc_name:n,refund_reason:t,_wpnonce:_pafw_admin._wpnonce},success:function(a){a.success?(alert(a.data),window.location.reload()):(alert(a.data),r())}}))},subscription_additional_charge:function(){var a=0|parseInt(i("#subscription_additional_charge_amount").val()),e=i("#subscription_additional_charge_card_quota").val();a<=0?alert("추가 과금 요청 금액을 입력해주세요."):confirm("추가 과금을 요청하시겠습니까?")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"subscription_additional_charge",order_id:_pafw_admin.order_id,amount:a,card_quota:e,_wpnonce:_pafw_admin._wpnonce},success:function(a){a.success?(alert(a.data),window.location.reload()):(alert(a.data),r())}}))},subscription_cancel_additional_charge:function(){var a=i(this).data("tid"),e=i(this).data("amount");confirm("추가 과금을 취소하시겠습니까?")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"subscription_cancel_additional_charge",order_id:_pafw_admin.order_id,tid:a,amount:e,_wpnonce:_pafw_admin._wpnonce},success:function(a){a.success?(alert(a.data),window.location.reload()):(alert(a.data),r())}}))},cancel_batch_key:function(){var a=i(this).closest("div").find("#subscription_batch_key").val();_.isEmpty(a)?alert("비활성화할 배치키를 입력해주세요."):confirm("[주의] 정기결제 배치키를 비활성화 하시겠습니까? 비활성화된 정기결제 배치키는 다시 활성화하실 수 없습니다.")&&(c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"subscription_cancel_batch_key",subscription_id:_pafw_admin.order_id,batch_key:a},success:function(a){a.success?(alert(a.data),window.location.reload()):(alert(a.data),r())}}))},cash_amount:function(){c(),i.ajax({url:ajaxurl,type:"POST",data:{action:_pafw_admin.slug+"-pafw_ajax_action",payment_method:_pafw_admin.payment_method,payment_action:"cash_amount",order_id:_pafw_admin.order_id},success:function(a){a.success?(document.getElementById("npay_cash_amount")||i(document.body).append('<div id="npay_cash_amount" title="현금영수증 발행대상 금액"></div>'),i("#npay_cash_amount").empty().append(a.data).dialog({modal:!0,width:"400px",buttons:{Ok:function(){i(this).dialog("close")}}})):alert(a.data),r()}})},cash_receipt:function(){e()||confirm("현금영수증 발행을 요청하시겠습니까?")&&(c(),i.ajax({type:"POST",url:ajaxurl,data:{action:_pafw_admin.slug+"-pafw_cash_receipt",order_id:_pafw_admin.order_id,_wpnonce:_pafw_admin._wpnonce},success:function(a){a?"true"===a.success||a.success?(alert(a.data),location.reload()):(alert(a.data),r()):(alert("현금영수증 발행 요청중 오류가 발생했습니다. 잠시 후 다시 시도해주세요."),r())},error:function(a,e,n){alert(n),r()}}))},cancel_receipt:function(){e()||confirm("발행된 현금영수증을 취소하시겠습니까?")&&(c(),i.ajax({type:"POST",url:ajaxurl,data:{action:_pafw_admin.slug+"-pafw_cancel_receipt",order_id:_pafw_admin.order_id,_wpnonce:_pafw_admin._wpnonce},success:function(a){a?"true"===a.success||a.success?(alert(a.data),location.reload()):(alert(a.data),r()):(alert("현금영수증 취소 요청중 오류가 발생했습니다. 잠시 후 다시 시도해주세요."),r())},error:function(a,e,n){alert(n),r()}}))},view_receipt:function(){e()||(c(),i.ajax({type:"POST",url:ajaxurl,data:{action:_pafw_admin.slug+"-pafw_view_receipt",order_id:_pafw_admin.order_id,_wpnonce:_pafw_admin._wpnonce},success:function(a){var e;a.success?null===(e=window.open("","","scrollbars=yes,width=480,height=700"))?alert("팝업이 차단되어 있습니다. 팝업설정을 변경하신 후 다시 시도해주세요."):(e.document.write(a.data),e.document.close()):alert(a.data),r()},error:function(a,e,n){alert(n),r()}}))},update_receipt_info:function(){e()||confirm("현금영수증 발행정보를 업데이트 하시겠습니까?")&&(c(),i.ajax({type:"POST",url:ajaxurl,data:{action:_pafw_admin.slug+"-pafw_update_receipt_info",order_id:_pafw_admin.order_id,receipt_usage:i("select[name=pafw_bacs_receipt_usage]").val(),receipt_issue_type:i("select[name=pafw_bacs_receipt_issue_type]").val(),reg_number_ID:i("input[name=pafw_bacs_reg_number_ID]").val(),reg_number_POE:i("input[name=pafw_bacs_reg_number_POE]").val(),_wpnonce:_pafw_admin._wpnonce},success:function(a){a?"true"===a.success||a.success?(alert(a.data),location.reload()):(alert(a.data),r()):(alert("현금영수증 발행정보 업데이트중 오류가 발생했습니다. 잠시 후 다시 시도해주세요."),r())},error:function(a,e,n){alert(n),r()}}))}}).init()});