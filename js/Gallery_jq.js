$(document).ready(function(){
	$("a#example7").fancybox({'titlePosition'	: 'inside'});
	$('#slide1').timerGallery({idPre: 'img' , interval : '4000' });
	$('#slide2').timerGallery({idPre: 'img_' , interval : '5000'});
	$('#slide3').timerGallery({idPre: 'img' , interval : '4000' });
	$('#slide4').timerGallery({idPre: 'img' , interval : '4000' });

	$('.next_btn, .prev_btn, .next_2_btn, .prev_2_btn').fadeTo(1,0.8);
	$('.next_btn, .prev_btn, .next_2_btn, .prev_2_btn').hover(function(){
		$(this).fadeTo(1,0.6);
	},function(){
		$(this).fadeTo(1,0.8);
	});

	$('#next_2_2').click(function(){
		$('#workArea').css('display','block');
		$('#workArea2').css('display','none');
		$('#workArea3').css('display','none');
	});
	$('#prev_2_1').click(function(){
		$('#workArea').css('display','none');
		$('#workArea2').css('display','block');
		$('#workArea3').css('display','none');
	});
	$('#prev_2_2').click(function(){
		$('.next_2').css('display','block');
		$('#workArea').css('display','none');
		$('#workArea2').css('display','none');
		$('#workArea3').css('display','block');
	});
	$('#next_2_3').click(function(){
		$('#workArea').css('display','none');
		$('#workArea2').css('display','block');
		$('#workArea3').css('display','none');
	});
});

(function ($) {
  $.fn.timerGallery = function (options) {
    var defaults = {
      easing: 'jswing',
      idPre: 'img_',
      interval: 5000,
      name: '',
	  opacity: 0.5
    }
    settings = $.extend({}, defaults, options);
    return this.each(function () { /* Plugin Code Here */
      var idName = settings.idPre
      var interval = settings.interval
	  var op = settings.opacity
      var $this = $(this); //cache jQuery object of the element invoked on
      var mi = $this.find('.main_images li');
      var fir = $this.find('.main_images li:first');
      var fird = $this.find(".descriptions li:first");
	  var ssai= $this.find('.sub_section li a img')
	  var t = $this.find('.thumbs');
      var inter
      var now = 0;
      var next = 1;

      var setUp = function () {
        $(mi).each(function (index, element) {
          $(element).attr("id", idName + index);
        });
        $(fir).addClass('current').css('display', 'inline-block');
        $(fird).show().addClass('current_desc');
      }
      var sect = $this.find(".section");
      var len = $(sect).size();            // console.log($("#slide1").find(".section").width());
      //if($("#slide1").find(".section").width()>100){var secWid = $("#slide1").find(".section").width();}
      if(document.body.clientWidth < 701){var secWid = document.body.clientWidth;}
      else{var secWid = 866;}
      //var secWid = $("#slide1").find(".section").width();
      var count = 0;
      var eType = settings.easing;
      var arrows = function () {
        if (len > 1) {
          $this.find('.next').css('display', 'inline-block');
          $this.find('.prev').css('display', 'none');
        }
        else {          $this.find('.next').css('display', 'none');
          $this.find('.prev').css('display', 'none');
        }
      }
	  var s =secWid*len
	  $(t).width(secWid*len)
      $this.find('.prev').bind('click', function () {
        $this.find('.next').css('display', 'inline-block');
        if (count > 0) {         if(count == 1){$this.find('.prev').css('display', 'none');}
          $this.find('.thumbs').animate({
            left: '+=' + secWid + 'px'
          }, {
            duration: 'slow'
          }, eType)
          count = count - 1;
          return false;
        }
        return false;
      });
      $this.find('.next').bind('click', function () {
      	$this.find('.prev').css('display', 'inline-block');
        if (count < len - 1) {   if (count == len - 2) {$this.find('.next').css('display', 'none');}
          $this.find('.thumbs').animate({
            left: '-=' + secWid + 'px'
          }, {
            duration: 'slow'
          }, eType)
          count = count + 1
          return false;
        }
        return false;
      });
	  $('.main_images li a').click(function(){
			clearInterval(inter);
		})
      var swapImages = function () {
        var leng = $(mi).length;

        if (next != leng) {
          $this.find('#' + idName + next).fadeIn('slow');
          $this.find('#' + idName + now).hide();
          $this.find('.' + idName + now).hide("slide", {
            direction: "down"
          }, 500, function () {
            $this.find('.' + idName + next).show("slide", {
              direction: "down"
            }, 500);
            now = next;
            next = next + 1;

            $this.find('.' + idName + now).addClass('current_desc');
          });
        } else {
          next = 0;
          $this.find('#' + idName + next).fadeIn('slow');
          $this.find('#' + idName + now).hide();
          $this.find('.' + idName + now).hide("slide", {
            direction: "down"
          }, 500, function () {
            $this.find('.img_' + next).show("slide", {
              direction: "down"
            }, 500, function () {});
            now = next;
            next = next + 1;

            $this.find('.' + idName + now).addClass('current_desc').css('display', 'inline-block');
          });
        }
      }
      var time = function () {
        if (interval >= 4000) {
          inter = setInterval(swapImages, interval);
        } else {
          inter = setInterval(swapImages, 5000);
        }
      }
      setUp()
      arrows()
	  window.onload=function(){
      time() //run function
		}
    });
  }
})(jQuery);