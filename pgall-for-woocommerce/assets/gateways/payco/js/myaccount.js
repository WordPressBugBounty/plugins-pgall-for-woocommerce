jQuery(document).ready(function(c){"use strict";function a(){e.is(".processing")||e.parents(".processing").length||e.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}})}var e=c("div.pafw-escrow");({init:function(){c("#pafw-escrow-purchase-decide").on("click",this.escrow_purchase_decide)},escrow_purchase_decide:function(){confirm("구매 확인을 하시겠습니까?")&&(a(),c.ajax({url:_pafw_myaccount.ajaxurl,type:"POST",data:{action:_pafw_myaccount.slug+"-pafw_ajax_action",payment_method:_pafw_myaccount.payment_method,order_id:_pafw_myaccount.order_id,order_key:_pafw_myaccount.order_key,_wpnonce:_pafw_myaccount._wpnonce,payment_action:"escrow_purchase_decide"},success:function(c){c.success?(alert(c.data),window.location.reload()):(alert(c.data),e.removeClass("processing").unblock())}}))}}).init()});