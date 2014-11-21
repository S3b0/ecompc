function addAjaxLoader(e){$("#"+e).addClass("ajaxloader")}function removeAjaxLoader(e){$("#"+e).removeClass("ajaxloader")}function txEcompcSetOption(){$(".ecom-configurator-select-package-option-wrap").on("click",function(e){e.preventDefault();if($(this).hasClass("disabled"))return $(this).blur(),void 0;addAjaxLoader("ecom-configurator-ajax-loader"),genericAjaxRequest(t3pid,t3lang,1407764086,"setOption",{option:$(this).attr("data-option"),unset:$(this).attr("data-option-state"),cObj:t3cobj},function(e){var t=$("#ecom-configurator-optionSelection-package-info"),n=$("#ecom-configurator-result-canvas");removeAjaxLoader("ecom-configurator-ajax-loader"),updateProgressIndicators(e.progress),e.currentPackage instanceof Object&&t.html("<h2>"+e.currentPackage.frontendLabel+"</h2>"+"<p>"+e.currentPackage.hintText+"</p>").show(),e.showResult?(t.hide(),$("#ecom-configurator-result-canvas .ecom-configurator-result h3.ecom-configurator-result-label").first().html(e.configurationData[0]),$("#ecom-configurator-result-canvas .ecom-configurator-result small.ecom-configurator-result-code").first().html(getConfigurationCode(e.configurationData[1])),$("#ecom-configurator-summary-table").html(getConfigurationSummary(e.configurationData[1],e.pricingEnabled)),$(".ecompc-syntax-help").tooltip({tooltipClass:"ecompc-custom-tooltip-styling",track:!0}),n.show(),$("#ecom-configurator-show-result-button").hide(),txEcompcIndex()):(t.show(),n.hide(),e.progress===1?$("#ecom-configurator-show-result-button").show():$("#ecom-configurator-show-result-button").hide()),updatePackageNavigation(e.packages),buildSelector(e),e.pricingEnabled&&e.pricing&&$("#ecom-configurator-config-header-config-price").html(e.pricing)})})}function txEcompcIndex(){$(".ecom-configurator-package-select").on("click",function(e){e.preventDefault();if($(this).hasClass("ecom-configurator-package-state-0")||$(this).hasClass("current"))return!1;addAjaxLoader("ecom-configurator-ajax-loader"),genericAjaxRequest(t3pid,t3lang,1407764086,"index",{"package":$(this).attr("data-package"),cObj:t3cobj},function(e){var t=$("#ecom-configurator-optionSelection-package-info"),n=$("#ecom-configurator-result-canvas");removeAjaxLoader("ecom-configurator-ajax-loader"),e.currentPackage instanceof Object&&t.html("<h2>"+e.currentPackage.frontendLabel+"</h2>"+"<p>"+e.currentPackage.hintText+"</p>").show(),e.showResult?(t.hide(),n.show(),$("#ecom-configurator-show-result-button").hide()):(t.show(),n.hide(),e.progress===1?$("#ecom-configurator-show-result-button").show():$("#ecom-configurator-show-result-button").hide()),updatePackageNavigation(e.packages),buildSelector(e)})})}function getOptionHint(e,t,n,r){var i=$("#ecom-configurator-select-package-option-info-hint-box"),s=$("#ecom-configurator-select-package-option-info-hint-box > div");return i.addClass("ajaxloader"),s.html(""),genericAjaxRequest(t,n,1407764086,"getOptionHint",{option:e,cObj:r},function(e){s.html(e.hint),i.removeClass("ajaxloader")}),!1}function genericAjaxRequest(e,t,n,r,i,s){$.ajax({async:"true",url:"index.php",type:"POST",dataType:"json",data:{eID:"EcomProductConfigurator",id:parseInt(e),L:parseInt(t),type:parseInt(n),request:{controllerName:"DynamicConfiguratorAjaxRequest",actionName:r,arguments:i}},success:s,error:function(e,t,n){console.log("Request failed with "+t+": "+n+"!")}})}function updateProgressIndicators(e){$("#ecom-configurator-progress-value").animate({value:e}),$(".ecom-configurator-progress-value-print").each(function(t,n){$({countNum:$(n).text()}).animate({countNum:Math.floor(e*100)},{duration:800,easing:"linear",step:function(){$(n).text(Math.floor(this.countNum))},complete:function(){$(n).text(this.countNum)}})})}function updatePackageNavigation(e){for(var t in e)if(e.hasOwnProperty(t)){if(!e[t].visibleInFrontend)continue;var n=e[t].active?1:0,r=e[t].active?0:1,i=e[t].anyOptionActive,s=$("#ecom-configurator-package-"+e[t].uid+"-link i"),o=$("#ecom-configurator-package-"+e[t].uid+"-link"),u=$("#ecom-configurator-package-"+e[t].uid+"-icon");s.addClass("fa-"+(i?"check-":"")+"square-o").removeClass("fa-"+(i?"":"check-")+"square-o"),o.addClass("ecom-configurator-package-state-"+n).removeClass("ecom-configurator-package-state-"+r),u.addClass("icon-state-"+n).removeClass("icon-state-"+r),e[t].current?(o.addClass("current"),u.addClass("current")):(o.removeClass("current"),u.removeClass("current"))}}function buildSelector(e){var t=e.options,n=[],r,i=1;if(t!==null&&t.length){for(r in t)if(t.hasOwnProperty(r)){var s='<a data-t3pid="'+e.pid+'" data-t3lang="'+e.lang+'" data-t3cobj="'+e.cObj+'" data-option="'+t[r].uid+'" data-option-state="'+(t[r].active?1:0)+'" class="ecom-configurator-select-package-option-wrap '+(t[r].disabled?"disabled":"enabled")+'" tabindex="'+i+'">';e.pricingEnabled&&(s+='<span class="ecom-configurator-select-package-option-price">'+t[r].price+"</span>"),t[r].hint&&(s+='<div class="ecom-configurator-select-package-option-info-wrapper"><span class="ecom-configurator-select-package-option-info">More Info</span></div>'),s+='<div class="ecom-configurator-checkbox '+(t[r].active?"":"un")+'checked"><span class="ecom-configurator-option-checkbox-image"></span></div>',s+='<span class="ecom-configurator-select-package-option option">'+t[r].title+"</span></a>",s+='<div class="clearfix"></div>',n.push(s),i++}$("#ecom-configurator-select-options-ajax-update").html(n.join("")).show(),$("#ecom-configurator-reset-configuration-button").show(),txEcompcSetOption(),addInfoTrigger()}else e.showResult&&($("#ecom-configurator-select-options-ajax-update").html("").hide(),$("#ecom-configurator-reset-configuration-button").hide())}function getConfigurationCode(e){var t="";for(var n=0;n<e.length;n++){var r=' class="ecompc-syntax-help"',i=' title="'+e[n].pkg+'"',s="";e[n].pkg||(r="",i=""),t+="<span"+r+i+">"+s+e[n][1]+"</span>"}return t}function getConfigurationSummary(e,t){var n="<table>";for(var r=0;r<e.length;r++){if(!e[r].pkg)continue;n+="<tr><td>"+e[r].pkg+"</td><td>"+e[r][0]+(e[r][1]!=""?" ["+e[r][1]+"]":"")+"</td><td>"+(e[r].pkgUid?'<a data-package="'+e[r].pkgUid+'" class="ecom-configurator-package-select"><i class="fa fa-edit"></i></a>':"")+"</td>",t&&(n+='<td class="align-right">'+(e[r].pricing?e[r].pricing:"")+"</td>"),n+="</tr>"}return n+="</table>",n}function addInfoTrigger(){var e="#ecom-configurator-canvas .ecom-configurator-select-package-option-info",t="#ecom-configurator-canvas #ecom-configurator-select-package-option-info-hint-box",n,r,i,s;$(e).on("click",function(e){return e.preventDefault(),getOptionHint($(this).parents("a").first().attr("data-option"),t3pid,t3lang,t3cobj),n=$(document).height(),s=$(t),r=$(s).outerHeight(),i=-5,s.slideDown(),!1})}(function(){txEcompcSetOption(),txEcompcIndex(),addInfoTrigger()})(jQuery);