$('.slick').
on('init', () => {
  $('.slick-slide[data-slick-index="-2"]').addClass('lt2');
  $('.slick-slide[data-slick-index="-1"]').addClass('lt1');
  $('.slick-slide[data-slick-index="1"]').addClass('gt1');
  $('.slick-slide[data-slick-index="2"]').addClass('gt2');
}).
slick({
  centerMode: true,
  centerPadding: 0,
  slidesToShow: 3,
  responsive: [{
    breakpoint: 750,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }]
}).
on('beforeChange', (event, slick, current, next) => {
  $('.slick-slide.gt2').removeClass('gt2');
  $('.slick-slide.gt1').removeClass('gt1');
  $('.slick-slide.lt1').removeClass('lt1');
  $('.slick-slide.lt2').removeClass('lt2');

  const lt2 = current < next && current > 0 ? current - 1 : next - 2;
  const lt1 = current < next && current > 0 ? current : next - 1;
  const gt1 = current < next || next === 0 ? next + 1 : current;
  const gt2 = current < next || next === 0 ? next + 2 : current + 1;

  $(`.slick-slide[data-slick-index="${lt2}"]`).addClass('lt2');
  $(`.slick-slide[data-slick-index="${lt1}"]`).addClass('lt1');
  $(`.slick-slide[data-slick-index="${gt1}"]`).addClass('gt1');
  $(`.slick-slide[data-slick-index="${gt2}"]`).addClass('gt2');

  // Clone processing when moving from 5 to 0
  if (current === 5 && next === 0) {
    $(`.slick-slide[data-slick-index="${current - 1}"]`).addClass('lt2');
    $(`.slick-slide[data-slick-index="${current}"]`).addClass('lt1');
    $(`.slick-slide[data-slick-index="${current + 2}"]`).addClass('gt1');
    $(`.slick-slide[data-slick-index="${current + 3}"]`).addClass('gt2');
  }

  // Clone processing when moving from 0 to 5
  if (current === 0 && next === 5) {
    $(`.slick-slide[data-slick-index="${current - 1}"]`).addClass('gt2');
    $(`.slick-slide[data-slick-index="${current}"]`).addClass('gt1');
    $(`.slick-slide[data-slick-index="${current - 2}"]`).addClass('lt1');
    $(`.slick-slide[data-slick-index="${current - 3}"]`).addClass('lt2');
  }

  console.log('beforeChange', current, ':', lt2, lt1, next, gt1, gt2);
});

$('#header-link').click(function () {
  var active_link = $('.slick-slide.slick-center a').attr("href");
  window.location = active_link;
});

$(document).ready(function () {
  console.log("running");
  var element = $('table.pr_app_box_100p');
  if (element.length > 0 && element.parent().hasClass('pr_info')) {
    console.log("picked");

    element.parent().css({
      "flex-direction": "column"
    });
  }

  if ($('.small-category-top-text').children().text().trim() == 'Placeholder') {
    $('.small-category-top-text').children().css({
      'display': 'none'
    });
  }
});

function resizeIframe() {
  setTimeout(function() {
    $('iframe#tire').height($('iframe#tire').contents().find("section#wrapper").height());
  }, 1000);
}

function resizeIframerealtime() {
  $('iframe#tire').height($('iframe#tire').contents().find("section#wrapper").height());
}

$(document).ready(function () {
  var target = $('.fax').find('.showbox-right');
  for (let l = 0; l < target.length; l++) {
    const element = target.eq(l);
    var temp = element.text().trim();
    temp = "<a href='javascript:void(0)'>" + temp + "</a>";
    element.html(temp);
  }

});

$(window).resize(function () {
  resizeIframerealtime();
});