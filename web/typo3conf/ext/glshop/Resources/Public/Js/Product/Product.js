!function($){var InputFieldTest={start:function(){var t=$(document).find("input[type=text]"),e=API.isDesktopTest(),i=["filter-product-artnr"];$.each(t,function(t,a){e?-1==i.indexOf($(a).attr("id"))&&$(a).attr("type","text").attr("maxlength",4):$(a).attr("type","number").removeAttr("maxlength")})}},Price={getProductPrice:function(t,e){for(var i=Product.products,a=0,r=0;r<i.length;r++)if(i[r].uid==t)for(var n=0;n<i[r].varianten.length;n++)i[r].varianten[n].uid==e&&(a=i[r].varianten[n].preis);return a}},API={usedIds:new Array,isMobile:window.matchMedia("only screen and (max-width: 750px)").matches,isTablet:window.matchMedia("only screen and (max-width: 974px)").matches,isDesktop:window.matchMedia("only screen and (min-width: 975px)").matches,isMobileTest:function(){var t=parseInt($(window).width());return 750>=t?!0:!1},isTabletTest:function(){var t=parseInt($(window).width());return 974>=t?!0:!1},isDesktopTest:function(){var t=parseInt($(window).width());return t>=975?!0:!1},createRandomNumber:function(){var t=Math.floor(10002*Math.random()+1);return-1==$.inArray(t,this.usedIds)?(this.usedIds.push(t),t):this.createRandomNumber()},ajax:function(async,data,type,dataType,sMsg,eMsg){var res=$.ajax({url:"index.php",async:async,global:!1,data:data,type:type,dataType:dataType,success:function(){null!=sMsg&&alert(sMsg)},error:function(){null!=eMsg&&alert(eMsg)}}).responseText;return"json"==dataType&&""!=res&&null!=res&&res.length>0&&(res=eval("("+res+")")),res},dotToComma:function(t){return t+="",t=t.replace(".",",")},commaToDot:function(t){return t+="",t=t.replace(".",""),t=t.replace(",",".")},round:function(t,e){if(1>e||e>14)return!1;var i=Math.pow(10,e),a=(Math.round(t*i)/i).toString();return-1==a.indexOf(".")&&(a+="."),a+=i.toString().substring(1),a.substring(0,a.indexOf(".")+e+1)},priceView:function(t){function e(t,e,r){e||(e=0);var n="",o=0>t?"-":"",d=Math.pow(10,e),c=Math.abs(t);c=""+parseInt(c*d+.5)/d;var l=c.indexOf(".");for(r&&e&&(c+=(-1==l?".":"")+d.toString().substring(1)),l=c.indexOf("."),-1==l?l=c.length:n=i+c.substr(l+1,e);l>0;)n=l-3>0?a+c.substring(l-3,l)+n:c.substring(0,l)+n,l-=3;return o+n}var i=",",a=".";return e(t,2,!0)},isset:function(t){return"undefined"!=typeof t&&null!=t?!0:!1}},Validate={config:{regexp:{ganzeZahl:{exp:/^([0-9_])+$/i,text:"Dieses Feld darf nur ganze Zahlen enthalten!"}},maxQty:100},updateText:function(t,e){e?$(t).show().html(e):$(t).hide().html("")},addErrorStyle:function(t){t.attr("style","border: 1px solid #A51107 !important; color: #A51107 !important; overflow:hidden; padding:0px !important;padding-left:4px !important;")},removeErrorStyle:function(t){t.removeAttr("style")},emptyField:function(t,e){var i=[];for(var a in t)""==t[a].val()&&i.push(a);if(i.length>1){for(var r="Die Felder ",n=0;n<i.length;n++)r+=0==n?'"'+i[n]+'"':', "'+i[n]+'"';return r+=" d&uuml;rfen nicht leer sein!",this.updateText(e,r),!1}return 1==i.length?(this.updateText(e,'Das Feld "'+i[0]+'" darf nicht leer sein!'),!1):(this.updateText(e,""),!0)},checkRegexp:function(t,e){var i=this.config.regexp.ganzeZahl.exp,a=this.config.regexp.ganzeZahl.text;return t.is(":visible")?i.test(t.val())?(this.removeErrorStyle(t),this.updateText(e,""),!0):(this.addErrorStyle(t),this.updateText(e,a),!1):(this.removeErrorStyle(0),this.updateText(e,""),!0)},isRadioSelected:function(t,e){return t.is(":visible")?""==t.find(":radio:checked").val()||"undefined"==typeof t.find(":radio:checked").val()?(this.addErrorStyle(t),this.updateText(e,"Bitte w&auml;hlen Sie einen Wert im markierten Bereich aus!"),!1):(this.removeErrorStyle(t),this.updateText(e),!0):!0},isButtonSelected:function(t,e){return t.is(":visible")?""==t.find("button.active").val()||"undefined"==typeof t.find("button.active").val()?(this.addErrorStyle(t),this.updateText(e,"Bitte w&auml;hlen Sie einen Wert im markierten Bereich aus!"),!1):(this.removeErrorStyle(t),this.updateText(e),!0):!0}},Product={products:null,pConfig:null,config:{halterImgPfad:"typo3conf/ext/glshop/Resources/Public/Img/Products/"},View:{initializeFirst:function(){this.iniTailView(),InputFieldTest.start(),$(window).resize(function(){Product.View.iniTailView(),InputFieldTest.start()}),this.iniDialog(),this.iniProducts()},iniTailView:function(){var t=0;API.isDesktopTest()?t=3:API.isTabletTest()?t=2:API.isMobileTest()&&(t=1);var e=$(".tailView > div:visible");e.each(function(e,i){e%t==0?$(i).addClass("lastTail"):$(i).removeClass("lastTail")})},iniDialog:function(){$("#products-success-Dialog").dialog({autoOpen:!1,resizable:!1,height:"auto",modal:!0,width:"auto",buttons:{"Weiter einkaufen":function(){$(this).dialog("close")},"Zum Warenkorb":function(){$(this).dialog("close");var t=$("base").attr("href"),e=t+"shop/?tx_glshop_glacrylshop%5Baction%5D=index&tx_glshop_glacrylshop%5Bcontroller%5D=Cart";window.location=e}}}),$("#products-error-Dialog").dialog({autoOpen:!1,resizable:!1,height:"auto",modal:!0,buttons:{OK:function(){$(this).dialog("close")}}}),$("#products-qty-Dialog").dialog({autoOpen:!1,resizable:!1,height:"auto",modal:!0,buttons:{OK:function(){$(this).dialog("close"),$("products-qty-warning").html("")}},close:function(){$("#products-success-Dialog").dialog("open")}})},iniProducts:function(){var t=new Object;t.eID="ajaxDispatcher",t.request={pluginName:"Glacrylshop",controller:"Aj",action:"getProducts",arguments:{uid:""}};var e=API.ajax(!1,t,"POST","json");Product.products=e.products,Product.pConfig=e.config},helper:{view:{createProductDetailView:function(t){var e=Product.View.helper.functions.getHalter(t);$("#product-detail-name").html(e.name),$("#montage").html(e.montage),$("#product-detail-beschreibung").html(e.beschreibung),Product.View.helper.view.createVariantenAuswahl(e),Product.View.helper.view.createImagePreview(e),Product.View.helper.view.insertInfoData(e.varianten[0])},createVariantenAuswahl:function(t){for(var e='<input type="hidden" id="product-detail-hId" value="'+t.uid+'" />',i=t.varianten,a=0;a<i.length;a++)e+='<div><input class="chooseProductVarianteBtn" '+(0==a?'checked="checked"':"")+' type="radio" id="var_'+i[a].uid+'_id" name="variante" value="'+i[a].uid+'"><label for="var_'+i[a].uid+'_id">'+i[a].name+"</label></div>",e+='<div class="productVarianteDetails">'+i[a].material+"<br/> Art.Nr.:"+i[a].artnr+"</div>";$(".product-price-preview span").html(API.priceView(parseInt(Product.pConfig)*parseFloat(t.varianten[0].preis))+" &euro;"),$("#product-detail-varianten-container").html(e)},createImagePreview:function(t){for(var e="",i="",a=0;a<t.varianten.length;a++)e+="<span>",e+='<input type="hidden" name="detail-img-variante" value="'+t.varianten[a].uid+'" />',i=Product.config.halterImgPfad+Product.View.helper.functions.getMiniImgData("path")+Product.View.helper.functions.getMiniImgData("name",t.varianten[a].bild),e+='<img class="product-detail-imgBtn" title="'+t.varianten[a].material+'" width="60" height="60" class="img-responsive" src="'+i+'" />',e+="</span>";$("#product-detail-view-Imgs").html(e);var r=Product.config.halterImgPfad+t.varianten[0].bild;i=Product.config.halterImgPfad+Product.View.helper.functions.getMiniImgData("path")+Product.View.helper.functions.getMiniImgData("name",t.varianten[0].bild);var n="";n+='<a href="'+r+'" data-lightbox="halter" data-title="">',n+='<img class="img-responsive" src="'+r+'" />',n+="</a>",$("#product-detail-view-Img-preview").html(n)},insertInfoData:function(t){var e='<div class="row">';e+='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">',e+="<div><b>Name:</b> <span>"+t.name+"</span></div>",e+="</div>",e+="</div>",e+='<div class="row">',e+='<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">',e+='<div class="product-detail-info-data"><b>Material:</b> <span>'+t.material+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Anwendung:</b> <span>'+t.beschreibung+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Maße:</b> <span>'+(0!=t.halterkantenlaenge?t.halterkantenlaenge+" x "+t.halterkantenlaenge+"mm":"&Oslash;"+t.durchmesser+"mm")+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Wandabstand:</b> <span>'+(0!=t.wandabstand?API.dotToComma(t.wandabstand)+"mm":"-")+"</span></div>";var i="";i=-1==t.materialVon&&-1==t.materialBis?"variabel":-1==t.materialVon&&-1!=t.materialBis?"bis "+t.materialBis+"mm":-1!=t.materialVon&&-1==t.materialBis?"ab "+t.materialVon+"mm":t.materialVon+" - "+t.materialBis+"mm",e+='<div class="product-detail-info-data"><b>Plattenstärke:</b> <span>'+i+"</span></div>",e+='<div class="clearer"></div>',e+="</div>",e+='<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">',e+='<div class="product-detail-info-data"><b>Plattenbohrung:</b> <span>'+(0!=t.plattenbohrungUnterseite?API.dotToComma(t.plattenbohrungUnterseite)+"mm":"-")+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Kopfform:</b> <span>'+(""!=t.kopfform?t.kopfform:"-")+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Kopfstärke:</b> <span>'+(0!=t.kopfstaerke?API.dotToComma(t.kopfstaerke)+"mm":"-")+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Befestigung:</b> <span>'+(""!=t.befestigung?t.befestigung:"-")+"</span></div>",e+='<div class="clearer"></div>',e+='<div class="product-detail-info-data"><b>Länge:</b> <span>'+(0!=t.laenge?t.laenge+"mm":"-")+"</span></div>",e+='<div class="clearer"></div>',e+="</div>",e+="</div>",$("#technik").html(e)}},functions:{getHalter:function(t){for(var e=0;e<Product.products.length;e++)if(Product.products[e].uid==t)return Product.products[e]},getHalterVariante:function(t,e){for(var i=0;i<Product.products.length;i++)if(Product.products[i].uid==t)for(var a=0;a<Product.products[i].varianten.length;a++)if(Product.products[i].varianten[a].uid==e)return Product.products[i].varianten[a]},getMiniImgData:function(t,e){switch(t){case"path":return"mini/";case"name":var i=e.split(".");return i[0]+"Mini.jpg"}}}},actions:{initialize:function(){$("body").on("click",".show-product-detail-Tail-Btn",Product.View.actions.showProductDetailFunction),$("body").on("click",".product-detail-close-text",Product.View.actions.closeProductDetailFunction),$("body").on("click",".add-product-to-cart-Tail-Btn",Product.View.actions.addProductTailToCartFunction),$("body").on("click",".chooseProductVarianteBtn",Product.View.actions.chooseProductVarianteFunction),$("body").on("click",".product-detail-imgBtn",Product.View.actions.changeProductVarianteImgFunction),$("body").on("click","#back-to-Top-Lnk",Product.View.actions.backToTopFunction),$("body").on("click","#show-product-filter",Product.View.actions.showProductFilterFunction),$("body").on("keyup","#filter-product-artnr",Product.View.actions.filterArtNrFunction)},filterArtNrFunction:function(t){var e=$("#filter-product-artnr").val(),i=$(".tailView").find("div[data-hid]");$.each(i,function(t,i){for(var a=[],r=$(i).attr("data-hid"),n=Product.View.helper.functions.getHalter(r),o=0;o<n.varianten.length;o++){var d=n.varianten[o];-1==d.artnr.indexOf(e)?a.push("true"):a.push("false")}-1==a.indexOf("false")?$(i).hide():$(i).show()}),Product.View.iniTailView()},showProductFilterFunction:function(){$("#product-filter-fields").toggle(),$("#product-filter-fields").is(":visible")?$(this).html("Filter schlie&szlig;en"):($(this).html("Filter &ouml;ffnen"),$("#filter-product-artnr").val(""),Product.View.actions.filterArtNrFunction())},changeProductVarianteImgFunction:function(t){var e=$("#product-detail-hId").val(),i=$(this).prev("input").val(),a=Product.View.helper.functions.getHalterVariante(e,i),r=Product.config.halterImgPfad+a.bild;$("#product-detail-view-Img-preview a").attr("href",r),$("#product-detail-view-Img-preview a img").attr("src",r),$("#product-detail-varianten-container div").find("input[name=variante][value="+i+"]").prop("checked",!0),$(".product-price-preview span").html(API.priceView(parseInt(Product.pConfig)*parseFloat(a.preis))+" &euro;"),Product.View.helper.view.insertInfoData(a)},chooseProductVarianteFunction:function(t){var e=$("#product-detail-hId").val(),i=$(this).val(),a=Product.View.helper.functions.getHalterVariante(e,i);$(".product-price-preview span").html(API.priceView(parseInt(Product.pConfig)*parseFloat(a.preis))+" &euro;"),Product.View.helper.view.insertInfoData(a);var r=Product.config.halterImgPfad+a.bild;Product.config.halterImgPfad+Product.View.helper.functions.getMiniImgData("path")+Product.View.helper.functions.getMiniImgData("name",a.bild);$("#product-detail-view-Img-preview a").attr("href",r),$("#product-detail-view-Img-preview a img").attr("src",r)},backToTopFunction:function(t){t.preventDefault();var e=$(this).attr("href");$("html, body").animate({scrollTop:$(e).offset().top},"slow")},showProductDetailFunction:function(t){t.preventDefault();var e=$(this).val();Product.View.helper.view.createProductDetailView(e),$(".tailView").hide(),$(".product-detail-view").show()},closeProductDetailFunction:function(t){t.preventDefault(),$(".tailView").show(),$(".product-detail-view").hide(),$("#product-detail-qty").val(1),Product.View.iniTailView()},addProductTailToCartFunction:function(t){t.preventDefault();var e=$("#product-detail-hId").val(),i=$("#product-detail-varianten-container").find("div input[name=variante]:checked").val(),a=$("#product-detail-qty"),r=$(".product-main").prev("div.error"),n=!0;if(n=n&&Validate.emptyField({"Stück":a},r),n=n&&Validate.checkRegexp(a,r)){var o={halter:{uid:e,vid:i}},d=Price.getProductPrice(e,i),c=new Object;c.eID="ajaxDispatcher",c.request={pluginName:"Glacrylshop",controller:"Aj",action:"addToCart",arguments:{artikel:o,anzahl:a.val(),preis:d,schild:!1}};var l=API.ajax(!1,c,"POST","json");l?Number(a.val())>Validate.config.maxQty?($("#products-qty-warning").html(a.val()),$("#products-qty-Dialog").dialog("open")):$("#products-success-Dialog").dialog("open"):$("#products-error-Dialog").dialog("open");var d=parseInt(Product.pConfig)*parseFloat(Price.getProductPrice(e,i));a.val("1");var s=$(this).parent("div").parent("div").prev("div").find("p.product-price-preview span");s.html(API.dotToComma(API.round(d,2)))}}}}};$(function(){Product.View.initializeFirst(),Product.View.actions.initialize()})}(jQuery);