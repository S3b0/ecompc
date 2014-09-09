function addAjaxLoader(e){$(e).addClass("ajaxloader")}function remAjaxLoader(e){$(e).removeClass("ajaxloader")}function goBackToIndex(){$("#tx-ecompc-ajax-header-instructions").show(),$("#tx-ecompc-ajax-header-backlink").hide(),$("#tx-ecompc-package-select-option-index").hide(),$("#tx-ecompc-package-select-index").fadeIn()}function ajaxCaller(e,t,n,r,i,s){addAjaxLoader(t);var o=e.replace(" ","").split(",");$.ajax({async:"true",url:"index.php",type:"POST",dataType:"json",data:{eID:"EcomProductConfigurator",id:n,type:1407764086,request:r},success:i?i:function(e){remAjaxLoader(t);if(o.length)for(key in o){var n=o[key].split(":");$(n[0]).html(e[n[1]]).fadeIn()}onAjaxSuccessGeneric(e,e["action"]=="updatePackages"),onAjaxSuccessUpdateIndex(e),onAjaxSuccessUpdatePackages(e),s&&ajaxCaller("","#tx-ecompc-ajax-loader",e.pid,{actionName:"updatePackages",arguments:{cObj:e.cObj}});switch(e.proceed){case"index":goBackToIndex();break;case"selectPackageOptions":ajaxCaller("#tx-ecompc-package-select-option-index:content","#tx-ecompc-ajax-loader",e.pid,{actionName:"selectPackageOptions",arguments:{configurationPackage:e["package"],cObj:e.cObj}});break;default:}},error:function(e,t,n){console.log("Request failed with "+t+": "+n+"!")}})}function onAjaxSuccessUpdatePackages(e){e["action"]=="updatePackages"&&e.cfgres&&($("#ecom-configurator-result-canvas").html(e.cfgres).fadeIn(),function(e){var t=e("#tx-ecompc-canvas .ecom-configurator-summary-table");e("#tx-ecompc-canvas .ecom-configurator-result-review-config").on("click",function(n){n.preventDefault(),e(this).stop().toggleClass("active"),t.stop().slideToggle("slow").toggleClass("active"),t.hasClass("active")&&e("html, body").stop().animate({scrollTop:t.offset().top},"slow")})}(jQuery))}function onAjaxSuccessUpdateIndex(e){if(e.packagesLinksInnerHTML)for(key in e.packagesLinksInnerHTML){var t=$("#tx-ecompc-configure-package-"+key);$("#tx-ecompc-configure-package-"+key+" > .ecom-configurator-package-select").html(e.packagesLinksInnerHTML[key][2]),e.packagesLinksInnerHTML[key][0]?t.removeClass("inactive-package").addClass("active-package"):t.removeClass("active-package").addClass("inactive-package"),e.packagesLinksInnerHTML[key][1]?t.children(".ecom-configurator-package-state").removeClass("unchecked").addClass("checked"):t.children(".ecom-configurator-package-state").removeClass("checked").addClass("unchecked")}e.selcps<tcp&&$("#ecom-configurator-result-canvas").html("").hide()}function onAjaxSuccessGeneric(e,t){$("#ecom-configurator-process-value").animate({value:e.selcps/tcp}),$(".ecom-configurator-process-value-print").each(function(t,n){$({countNum:$(n).text()}).animate({countNum:Math.floor(e.selcps/tcp*100)},{duration:800,easing:"linear",step:function(){$(n).text(Math.floor(this.countNum))},complete:function(){$(n).text(this.countNum)}})}),e.cfgp&&$("#tx-ecompc-config-header-cfgp").html(e.cfgp),t||($("#tx-ecompc-ajax-header-instructions").hide(),$("#tx-ecompc-ajax-header-backlink").css("display","inline-block"))}function updatePackage(e,t,n,r){var i={actionName:"setOption",arguments:{cObj:t,opt:n,uns:r}};ajaxCaller("","#tx-ecompc-ajax-loader",e,i,null,1)}function resetPackage(e,t,n){var r={actionName:"resetPackage",arguments:{cObj:t,"package":n}};ajaxCaller("","#tx-ecompc-ajax-loader",e,r,function(e){remAjaxLoader("#tx-ecompc-ajax-loader"),onAjaxSuccessGeneric(e),onAjaxSuccessUpdateIndex(e),ajaxCaller("#tx-ecompc-package-select-option-index:content","#tx-ecompc-ajax-loader",e.pid,{actionName:"selectPackageOptions",arguments:{configurationPackage:e["package"],cObj:e.cObj}},null,1)})}(function(){$(".ecom-configurator-package-box").on("click",function(e){e.preventDefault();if($(this).hasClass("inactive-package"))return;var t=$(this).attr("data-page"),n=$(this).attr("data-package"),r=$(this).attr("data-cObj"),i={actionName:"selectPackageOptions",arguments:{configurationPackage:n,cObj:r}};$("#tx-ecompc-package-select-index").hide(),ajaxCaller("#tx-ecompc-package-select-option-index:content","#tx-ecompc-ajax-loader",t,i)}),$("#tx-ecompc-ajax-header-backlink").on("click",function(e){e.preventDefault(),goBackToIndex()})})(jQuery);
