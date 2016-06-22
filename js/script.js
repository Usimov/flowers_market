            function AjaxFormRequest(form_id) {
                jQuery.ajax({
                    url:     'checkout.php',
                    type:     "POST",
                    dataType: "html",
                    data: jQuery("#"+form_id).serialize(),
                    success: function(response) {
                    $(".modal").html(response);
                }
             });
        }

            function tovar_view(dir,id,stran) {

            	var arr;
				$('.ps-active-x li img').each(function (i){
					arr = arr+"@"+$(this).attr('onclick');
					});
				if (arr == undefined) {
					$('tbody tr').each(function (i){
						arr = arr+"@"+$(this).attr('onclick');
						});
				}
				$(".close div").css("display", "block");
				//var serializedArr = JSON.stringify( arr );
                jQuery.ajax({
                    url:     'tovar_view.php',
                    type:     "GET",
                    dataType: "html",
                    data: {dir:dir,id:id,stran:stran,mass:arr},
                    success: function(response) {
                    $(".modal").html(response);
                    $(".modal-box").fadeIn();
                    $("#tiptip_holder").hide();
                  //  $("body").css("margin-left", "-16px");
                   //	$("body").css("overflow", "hidden");
                }
             });
        }

$(document).ready(function(){

			$('.close, .modal-close, #close').click(function(){
				$(this).closest('.modal-box').fadeOut();
				setTimeout(function() {$(".modal").html('');
			//	$("body").css("margin-left", "0px");
			//	$("body").css("overflow", "auto");
				$(".close div").css("display", "none");}, 400);
				return false;
			});


//	----------------------------- Админ Панель ------------------

	$('.panel_a2').toggle(function(){
		$(this).css('color','#bd0004');
		$('.panel_a5').css('color','#696969');
		$('#panel_upr_ul2').css('display','block');
		$('#panel_upr_ul3').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$(this).css('color','#696969');
		$('#panel_upr_ul2').css('display','none');
	});

	$('.panel_a3').toggle(function(){
		$('#panel_div1').css('display','block');
		$('#panel_div2').css('display','none');
	},function(){
		$('#panel_div1').css('display','none');
	});

	$('.panel_a4').toggle(function(){
		$('#panel_div2').css('display','block');
		$('#panel_div1').css('display','none');
	},function(){
		$('#panel_div2').css('display','none');
	});

	$('.panel_a5').toggle(function(){
		$(this).css('color','#bd0004');
		$('#panel_upr_ul3').css('display','block');
		$('.panel_a2').css('color','#696969');
		$('#panel_upr_ul2').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$(this).css('color','#696969');
		$('#panel_upr_ul3').css('display','none');
		$('#panel_div3').css('display','none');
		$('#panel_div4').css('display','none');
		$('#panel_div5').css('display','none');
	});

	$('.panel_a7').toggle(function(){
		$('#panel_upr_ul4').css('display','block');
		$('#panel_div3_1').css('display','block');
		$('#panel_upr_ul5').css('display','none');
		$('#panel_upr_ul6').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
		$('#panel_div3').css('display','none');
	},function(){
		$('#panel_upr_ul4').css('display','none');
		$('#panel_div3_1').css('display','none');
	});


	$('.panel_a7_2').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_2').css('display','block');
		$('#panel_div3_1, #panel_div3_3, #panel_div3_4, #panel_div3_5, #panel_div3_6, #panel_div3_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_2').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a7_3').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_3').css('display','block');
		$('#panel_div3_1, #panel_div3_2, #panel_div3_4, #panel_div3_5, #panel_div3_6, #panel_div3_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_3').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a7_4').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_4').css('display','block');
		$('#panel_div3_1, #panel_div3_2, #panel_div3_3, #panel_div3_5, #panel_div3_6, #panel_div3_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_4').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a7_5').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_5').css('display','block');
		$('#panel_div3_1, #panel_div3_2, #panel_div3_3, #panel_div3_4, #panel_div3_6, #panel_div3_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_5').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a7_6').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_6').css('display','block');
		$('#panel_div3_1, #panel_div3_2, #panel_div3_3, #panel_div3_4, #panel_div3_5, #panel_div3_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_6').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a7_7').toggle(function(){
		$('#panel_div3').css('display','block');
		$('#panel_div3_7').css('display','block');
		$('#panel_div3_1, #panel_div3_2, #panel_div3_3, #panel_div3_4, #panel_div3_5, #panel_div3_6').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div3_7').css('display','none');
		$('#panel_div3').css('display','none');
	});

	$('.panel_a8').toggle(function(){
		$('#panel_upr_ul5').css('display','block');
		$('#panel_div4_1').css('display','block');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
		$('#panel_div4').css('display','none');
		$('#panel_upr_ul4').css('display','none');
		$('#panel_upr_ul6').css('display','none');
	},function(){
		$('#panel_upr_ul5').css('display','none');
		$('#panel_div4_1').css('display','none');
	});

	$('.panel_a8_2').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_2').css('display','block');
		$('#panel_div4_1, #panel_div4_3, #panel_div4_4, #panel_div4_5, #panel_div4_6, #panel_div4_7').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_2').css('display','none');
		$('#panel_div4').css('display','none');
	});
	$('.panel_a8_3').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_3').css('display','block');
		$('#panel_div4_1, #panel_div4_2, #panel_div4_4, #panel_div4_5, #panel_div4_6, #panel_div4_7').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_3').css('display','none');
		$('#panel_div4').css('display','none');
	});
	$('.panel_a8_4').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_4').css('display','block');
		$('#panel_div4_1, #panel_div4_2, #panel_div4_3, #panel_div4_5, #panel_div4_6, #panel_div4_7').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_4').css('display','none');
		$('#panel_div4').css('display','none');
	});
	$('.panel_a8_5').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_5').css('display','block');
		$('#panel_div4_1, #panel_div4_2, #panel_div4_3, #panel_div4_4, #panel_div4_6, #panel_div4_7').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_5').css('display','none');
		$('#panel_div4').css('display','none');
	});
	$('.panel_a8_6').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_6').css('display','block');
		$('#panel_div4_1, #panel_div4_2, #panel_div4_3, #panel_div4_4, #panel_div4_5, #panel_div4_7').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_6').css('display','none');
		$('#panel_div4').css('display','none');
	});
	$('.panel_a8_7').toggle(function(){
		$('#panel_div4').css('display','block');
		$('#panel_div4_7').css('display','block');
		$('#panel_div4_1, #panel_div4_2, #panel_div4_3, #panel_div4_4, #panel_div4_5, #panel_div4_6').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div5, #panel_div5_1').css('display','none');
	},function(){
		$('#panel_div4_7').css('display','none');
		$('#panel_div4').css('display','none');
	});

	$('.panel_a9').toggle(function(){
		$('#panel_upr_ul6').css('display','block');
		$('#panel_div5_1').css('display','block');
		$('#panel_div3, #panel_div3_1').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div5').css('display','none');
		$('#panel_upr_ul4').css('display','none');
		$('#panel_upr_ul5').css('display','none');
	},function(){
		$('#panel_upr_ul6').css('display','none');
		$('#panel_div5_1').css('display','none');
	});
	$('.panel_a9_2').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_2').css('display','block');
		$('#panel_div5_1, #panel_div5_3, #panel_div5_4, #panel_div5_5, #panel_div5_6, #panel_div5_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_2').css('display','none');
		$('#panel_div5').css('display','none');
	});
	$('.panel_a9_3').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_3').css('display','block');
		$('#panel_div5_1, #panel_div5_2, #panel_div5_4, #panel_div5_5, #panel_div5_6, #panel_div5_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_3').css('display','none');
		$('#panel_div5').css('display','none');
	});
	$('.panel_a9_4').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_4').css('display','block');
		$('#panel_div5_1, #panel_div5_2, #panel_div5_3, #panel_div5_5, #panel_div5_6, #panel_div5_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_4').css('display','none');
		$('#panel_div5').css('display','none');
	});
	$('.panel_a9_5').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_5').css('display','block');
		$('#panel_div5_1, #panel_div5_2, #panel_div5_3, #panel_div5_4, #panel_div5_6, #panel_div5_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_5').css('display','none');
		$('#panel_div5').css('display','none');
	});
	$('.panel_a9_6').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_6').css('display','block');
		$('#panel_div5_1, #panel_div5_2, #panel_div5_3, #panel_div5_4, #panel_div5_5, #panel_div5_7').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_6').css('display','none');
		$('#panel_div5').css('display','none');
	});
	$('.panel_a9_7').toggle(function(){
		$('#panel_div5').css('display','block');
		$('#panel_div5_7').css('display','block');
		$('#panel_div5_1, #panel_div5_2, #panel_div5_3, #panel_div5_4, #panel_div5_5, #panel_div5_6').css('display','none');
		$('#panel_div4, #panel_div4_1').css('display','none');
		$('#panel_div3, #panel_div3_1').css('display','none');
	},function(){
		$('#panel_div5_7').css('display','none');
		$('#panel_div5').css('display','none');
	});
});

function form ( )
{
        valid1 = true;
        if ( !document.form1.p_dostavka.value )
        {
                alert ( "Укажите доставку." );
                valid1 = false;
        }
        if ( !isValidPhone(document.form1.p_phote.value) )
        {
                alert ( "Пожалуйста введите номер телефона." );
                valid1 = false;
        }
        return valid1;
}

function isValidEmailAddress(emailAddress) {
var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
return pattern.test(emailAddress);
}
function isValidPhone(phone) {
var pattern = new RegExp(/^\+?(\d[\d\-\+\(\) ]{5,}\d$)/);
return pattern.test(phone);
}
function isValidTime(time) {if(time >= 8 && time <= 22){return time;}}